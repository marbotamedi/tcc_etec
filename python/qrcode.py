import base64
import io
from flask import Flask, request, jsonify
import qrcode
from qrcode import QRCode

app = Flask(__name__)

# Função para gerar o payload do QR Code PIX
def gerar_payload_pix(chave_pix, valor, descricao):
    payload = f"00020101021226360014BR.GOV.BCB.PIX0114{chave_pix}5204000053039865802BR5913{descricao}6009CIDADE62070503{valor:0.2f}6304"
    crc = calcular_crc(payload)
    return payload + crc

# Função para calcular o CRC16 0
def calcular_crc(payload):
    crc = 0xFFFF
    for byte in payload.encode('utf-8'):
        crc ^= byte << 8
        for _ in range(8):
            if crc & 0x8000:
                crc = (crc << 1) ^ 0x1021
            else:
                crc <<= 1
            crc &= 0xFFFF
    return f"{crc:04X}"

# Função para gerar o QR Code como uma imagem em Base64
def gerar_qr_code_base64(chave_pix, valor, descricao):
    payload = gerar_payload_pix(chave_pix, valor, descricao)
    img = qrcode.make(payload)  # Gera o QR Code
    
    # Converte a imagem para Base64
    buffered = io.BytesIO()
    img.save(buffered, format="PNG")
    qr_code_base64 = base64.b64encode(buffered.getvalue()).decode("utf-8")
    
    return qr_code_base64

# Rota para gerar o QR Code
@app.route('/gerar_qr_code/<float:valor>', methods=['GET'])
def gerar_qr_code(valor):
    chave_pix = "tailabol036@gmail.com"
    descricao = "valor teste"
    
    qr_code_base64 = gerar_qr_code_base64(chave_pix, valor, descricao)
    
    # Retorna o QR Code em base64
    return jsonify({"qr_code_base64": qr_code_base64})

# Endpoint do webhook que recebe a notificação do pagamento
@app.route('/webhook', methods=['POST'])
def webhook_pagamento():
    dados = request.json
    transaction_id = dados.get('transactionId')
    status = dados.get('status')
    
    if status == 'CONCLUIDO':
        return jsonify({"status": "Venda Aprovada!"}), 200
    else:
        return jsonify({"status": "Aguardando pagamento"}), 200

if __name__ == '__main__':
    app.run(debug=True)
