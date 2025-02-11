<?php
session_start(); // Inicia a sessão para acessar as variáveis de sessão

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "sysglr";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para buscar os produtos
$sql = "SELECT validade, nome, quantidade, preco FROM produtos";
$result = $conn->query($sql);

$query = "SELECT validade FROM produtos";
if ($row = mysqli_fetch_assoc($result)) {
    $validade = $row["validade"];  // Armazena a data de validade
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Caixa - Lidiane Salgados</title>
    <style>
        /*css do pix*/
        .modal {
            display: none;
            /* Inicia escondido */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            /* Fundo transparente escuro */
        }

        .pix-modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            text-align: center;
            border-radius: 8px;
        }

        .close-modal1 {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            margin-top: 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        #qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px auto;
            /* Centraliza horizontalmente */
            width: 200px;
            /* Largura do QR Code */
            height: 200px;
            /* Altura do QR Code */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 10px 0;
            background: #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        table {
            display: table;
            border-collapse: collapse;
            width: 100%;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        table th {
            background: #f9f9f9;
            font-weight: bold;
        }

        .btn-add,
        .btn-finalize,
        .btn-confirm {
            background: #2ECC40;
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-add:hover,
        .btn-finalize:hover,
        .btn-confirm:hover {
            background: #28A135;
        }

        .btn-delete {
            background: #FF4136;
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-delete:hover {
            background: #E02E22;
        }

        .total-section {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }

        .search-bar {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }

        .search-bar input {
            width: 100%;
            padding: 8px 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Janela flutuante */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content h2 {
            margin-bottom: 20px;
        }

        .payment-methods button {
            width: 100%;
            margin: 5px 0;
            padding: 10px;
            font-size: 16px;
        }

        .close-modal {
            margin-top: 15px;
            background: #ddd;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .close-modal:hover {
            background: #bbb;
        }

        /* Nova janela flutuante para dinheiro e troco */

        .money-modal-content {
            width: 350px;
            background-color: rgb(184, 182, 182);
            padding: 20px 40px 20px 20px;
            border-radius: 5px;
        }

        .money-modal-content input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Sistema de Caixa - Lidiane Salgados</h1>
        </div>

        <!-- Barra de pesquisa -->
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Pesquise um produto..." oninput="filterProducts()">
        </div>

        <!-- Tabela dos produtos disponíveis -->
        <h3>Produtos Disponíveis</h3>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço Unitário</th>
                    <th>QTD</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody id="available-products" class="avaliar-produtos">
                <?php
                // Verifica se há resultados e exibe os produtos
                if ($result->num_rows > 0) {
                    $counter = 0; // Inicializa o contador
                    while ($row = $result->fetch_assoc()) {
                        if ($counter >= 10) break; // Interrompe após 10 produtos

                        echo "<tr>";
                        echo "<td style='display: none;'> " . date("d/m/Y", strtotime($row["validade"])) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["quantidade"]) . "</td>";
                        echo "<td>" . number_format($row["preco"], 2, ',', '.') . "</td>"; // Formata o preço
                        echo "<td><button class='btn-add' onclick='addProduct(\"" . htmlspecialchars($row["nome"]) . "\", " . $row["preco"] . ")'>Adicionar</button></td>";
                        echo "</tr>";

                        $counter++; // Incrementa o contador
                    }
                }
                ?>
            </tbody>
        </table>

        <!-- Tabela dos produtos adicionados -->
        <h3>Produtos Adicionados</h3>
        <table id="tabelaProdutos">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody id="added-products">
                <!-- Produtos adicionados serão exibidos aqui -->
            </tbody>
        </table>

        <div class="total-section">
            Total: <span id="total">R$: 0,00</span>
        </div>

        <!-- Botão para finalizar venda -->
        <button class="btn-finalize" onclick="openModal02()" id="finalizarVenda01">Finalizar Venda</button>
    </div>

    <!-- Janela flutuante para métodos de pagamento -->
    <div class="modal" id="payment-modal">
        <div class="modal-content">
            <h2>Escolha o método de pagamento</h2>
            <div class="payment-methods">
                <button onclick="openMoneyModal()" id="botaoDinheiro">Dinheiro</button>
                <button onclick="finalizeSale()" id="botaoCartoes">Débito/Crédito</button>
                <button onclick="openPixModal()" id="botaoPix">Pix</button>
            </div>
            <button class="close-modal" onclick="closeModal()">Cancelar</button>
        </div>
    </div>
    <div class="modal" id="pix-modal">
        <div class="pix-modal-content">
            <h2>Pagamento via Pix</h2>
            <div id="qr-code-text"></div> <!-- O QR Code gerado será exibido aqui -->
            <button class="btn-confirm" onclick="finalizarCompra02()">Confirmar Pagamento</button>
            <div id="pix-status" style="display: none;">
                <p>Status do pagamento: <span id="pix-status-text">Aguardando</span></p>
            </div>
            <button class="close-modal1" onclick="closePixModal()">Cancelar</button>
        </div>
    </div>



    <!-- Janela flutuante para dinheiro e troco -->
    <div class="modal" id="money-modal">
        <div class="money-modal-content">
            <h2>Pagamento em Dinheiro</h2>
            <p>Digite o valor recebido:</p>
            <input type="number" id="money-received" placeholder="Valor Recebido">
            <button class="btn-confirm" onclick="calculateChange()">Calcular Troco</button>
            <div id="change-section" style="display:none;">
                <p>Troco: R$ <span id="change-amount">0.00</span></p>
            </div>
            <button class="close-modal1" onclick="closeMoneyModal()">Cancelar</button>
            <button class="close-modal1" onclick="finalizarCompra()">Finalizar</button>
        </div>
    </div>

    <script>
        let total = 0;

        function addProduct(name, price) {
            const table = document.getElementById('added-products');
            let existingRow = Array.from(table.rows).find(row => row.cells[0].textContent === name);

            if (existingRow) {
                let qtyCell = existingRow.cells[1];
                let totalCell = existingRow.cells[3];
                let quantity = parseInt(qtyCell.textContent) + 1;
                qtyCell.textContent = quantity;
                totalCell.textContent = `R$ ${(quantity * price).toFixed(2)}`;
            } else {
                let row = table.insertRow(); // Cria uma nova linha na tabela
                const botao = document.getElementById('botaoDinheiro'); // Obtém o botão

                // Captura o texto do botão (garanta que isso seja feito antes de adicionar a linha)
                const nomeDoBotao = botao.innerText || botao.textContent;
                const troco = document.getElementById('change-amount').textContent = change.toFixed(2);


                // Adiciona o conteúdo da nova linha na tabela
                row.innerHTML = `
                <td style="display: none;" name="row-date">${currentDate}</td>
                <td name="row-name">${name}</td>
                <td>1</td>
                <td name="row-price01">${price.toFixed(2)}</td>
                <td name="row-price02">${price.toFixed(2)}</td>
                <td style="display: none">${troco}</td>
                <td style="display: none;" name="row-namebutton">${nomeDoBotao}</td> <!-- Aqui insere o texto do botão -->
                <td><button class="btn-delete" onclick="removeRow(this, ${price})">Excluir</button></td>
        `;
            }

            // Atualiza a data ao carregar a página
            window.onload = updateDate;

            total += price;
            document.getElementById('total').textContent = total.toFixed(2);
        }

        // Função para exibir a data atual no formato desejado
        function updateDate() {
            var date = new Date();
            var formattedDate = date.toLocaleDateString('pt-BR', {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric'
            });
            var dateSpan = document.querySelector(".date-span");
            if (dateSpan) {
                dateSpan.textContent = formattedDate;
            }

            return formattedDate;
        }
        var currentDate = updateDate();

        function removeRow(button, price) {
            let row = button.closest('tr');
            row.remove();
            total -= price;
            document.getElementById('total').textContent = total.toFixed(2);
        }

        // Função para filtrar os produtos com base no texto digitado
        function filterProducts() {
            const input = document.getElementById("search-input");
            const filter = input.value.toLowerCase(); // Converte a pesquisa para minúsculas
            const rows = document.querySelectorAll("#available-products tr"); // Seleciona todas as linhas da tabela

            rows.forEach(row => {
                const productName = row.cells[1].textContent.toLowerCase(); // Nome do produto
                if (productName.indexOf(filter) > -1) { // Se o nome do produto corresponder à pesquisa
                    row.style.display = ""; // Exibe a linha
                } else {
                    row.style.display = "none"; // Oculta a linha
                }
            });
        }


        function openModal() {

            document.getElementById('payment-modal').style.display = 'flex';
        }

        function openModal02() {
            var tabelaSecundaria = document.getElementById("added-products");

            // Verifica se o tbody possui linhas
            if (tabelaSecundaria.rows.length > 0) {
                // Exibe o modal
                document.getElementById('payment-modal').style.display = 'flex';
            } else {
                // Exibe alerta e bloqueia a ação
                alert("Nenhum produto foi adicionado! Adicione itens antes de finalizar a venda.");
                return;
            }
        }


        function closeModal() {
            document.getElementById('payment-modal').style.display = 'none';
        }

        function openMoneyModal() {
            document.getElementById('payment-modal').style.display = 'none';
            document.getElementById('money-modal').style.display = 'flex';
        }
        /*-------------------------------------versao pix--------------------------------------------------------------*/

        function openPixModal() {
            const pixModal = document.getElementById('pix-modal');
            pixModal.style.display = "block"; // Torna o modal visível

            // Recupera o valor do pagamento
            const valor = 5.90; // Exemplo de valor, pode ser extraído do seu HTML
            document.getElementById("qr-code-text").innerHTML = `Valor: R$ ${valor.toFixed(2)}`;

            // Faz a requisição para o backend para gerar o QR Code com base no valor
            fetch(`/gerar_qr_code/${valor}`) // Envia o valor para o backend
                .then(response => response.json())
                .then(data => {
                    // A resposta contém o QR Code em base64. Vamos exibir o QR Code no modal
                    const qrCodeDiv = document.getElementById('qr-code-text');
                    const qrImage = document.createElement('img');
                    qrImage.src = `data:image/png;base64,${data.qr_code_base64}`;
                    qrCodeDiv.innerHTML = ""; // Limpa o conteúdo anterior
                    qrCodeDiv.appendChild(qrImage); // Adiciona o QR Code gerado
                })
                .catch(error => {
                    console.error('Erro ao gerar QR Code:', error);
                    alert('Houve um erro ao tentar gerar o QR Code');
                });
        }




        function closePixModal() {
            const pixModal = document.getElementById('pix-modal');
            pixModal.style.display = "none"; // Oculta o modal
        }

        function confirmarPix() {
            const pixModal = document.getElementById('pix-modal');

            // Exibe mensagem de confirmação
            alert("Pagamento via Pix confirmado com sucesso!");

            // Fecha o modal após a confirmação
            pixModal.style.display = "none";
        }



        /*--------------------------------------------------------------------------------------------------------------------*/

        function closeMoneyModal() {


            document.getElementById('money-modal').style.display = 'none';

            openModal();
        }

        /*pegando nome do botao selecionado e jogando na tabela*/






        //---------------------------------------------------------------------------//
        function finalizarCompra() {
            // Obtém o valor do campo de entrada



            var tbody01 = document.getElementById("added-products");

            const bloquear = document.getElementById("")

            // Cria um clone da tabela para manipulação
            var clonedTable = tbody01.cloneNode(true);

            // Itera por todas as linhas da tabela clonada
            var linhas = clonedTable.querySelectorAll("tr");

            linhas.forEach(function(linha) {
                var celulas = linha.cells;

                // Verifica se a linha tem a célula "Ação" (última célula)
                if (celulas.length > 4) {
                    // Remove a célula "Ação" que contém o botão "Excluir"
                    linha.deleteCell(celulas.length - 1); // Remove a célula do botão "Excluir"
                }
            });

            // Obtém o conteúdo HTML da tabela clonada (sem a coluna "Ação")
            var tableContent = clonedTable.innerHTML;

            // Armazena o conteúdo no localStorage
            localStorage.setItem("tableContent", tableContent);

            // Redireciona para a página de destino
            window.location.href = "Relatorio.php"; // Altere para o caminho da página destino
        }
        /*-------------funcao finalizar pix02-----------------------*/

        function finalizarCompra02() {

            var tbody01 = document.getElementById("added-products");






            // Cria um clone da tabela para manipulação
            var clonedTable = tbody01.cloneNode(true);

            // Itera por todas as linhas da tabela clonada
            var linhas = clonedTable.querySelectorAll("tr");

            linhas.forEach(function(linha) {
                var celulas = linha.cells;

                // Verifica se a linha tem a célula "Ação" (última célula)
                if (celulas.length > 4) {
                    // Remove a célula "Ação" que contém o botão "Excluir"
                    linha.deleteCell(celulas.length - 1); // Remove a célula do botão "Excluir"
                }
            });

            // Obtém o conteúdo HTML da tabela clonada (sem a coluna "Ação")
            var tableContent = clonedTable.innerHTML;

            // Armazena o conteúdo no localStorage
            localStorage.setItem("tableContent", tableContent);

            // Redireciona para a página de destino
            window.location.href = "Relatorio.php"; // Altere para o caminho da página destino
        }

        /*-------------funcao finalizar pix02-----------------------*/

        function finalizarCompra02() {
            var tbody01 = document.getElementById("added-products");
            const campoQR = document.getElementById("qr-text");

            if (campoQR.value.trim() === '') {
                alert("Insira uma URL");
                return; // Impede a execução do código abaixo
            }

            // Cria um clone da tabela para manipulação
            var clonedTable = tbody01.cloneNode(true);

            // Itera por todas as linhas da tabela clonada
            var linhas = clonedTable.querySelectorAll("tr");

            linhas.forEach(function(linha) {
                var celulas = linha.cells;

                // Verifica se a linha tem a célula "Ação" (última célula)
                if (celulas.length > 4) {
                    // Remove a célula "Ação" que contém o botão "Excluir"
                    linha.deleteCell(celulas.length - 1); // Remove a célula do botão "Excluir"
                }
            });

            // Redireciona para a página de destino
            window.location.href = "Relatorio.php"; // Altere para o caminho da página destino
        }




        function finalizeSale(paymentMethod) {
            alert('Venda finalizada com pagamento por: ' + paymentMethod);
            // Aqui você pode adicionar o código para salvar a venda no banco de dados
        }

        function calculateChange() {
            const moneyReceived = parseFloat(document.getElementById('money-received').value);

            // Verifica se o valor recebido é inválido (não é número), menor que o total ou menor ou igual a zero
            if (isNaN(moneyReceived) || moneyReceived < total || moneyReceived <= 0) {
                alert('Valor recebido inválido ou insuficiente.');
                return;
            }

            // Calcula o troco
            const change = moneyReceived - total;

            // Exibe o troco
            document.getElementById('change-amount').textContent = change.toFixed(2);

            // Exibe a seção do troco
            document.getElementById('change-section').style.display = 'block';

        }


        function goBackToPayment() {
            document.getElementById('money-modal').style.display = 'none';
            openModal();

        }

        // Função para excluir todos os produtos
        function clearAllProducts() {
            let tbody = document.getElementById('added-products');
            tbody.innerHTML = ''; // Limpa todas as linhas

            // Atualiza o total
            total = 0;
            document.getElementById('total').textContent = total.toFixed(2).replace('.', ',');
        }
        //--------------------------------------------------------------------------------------------------//




        //Função para gerar qrcode teste
        function generateQRCode() {
            const qrText = document.getElementById('qr-text').value;
            const qrCodeContainer = document.getElementById('qrcode');

            // Limpa o conteúdo anterior do contêiner
            qrCodeContainer.innerHTML = "";

            if (qrText.trim() !== "") {
                // Gera o QR Code
                new QRCode(qrCodeContainer, {
                    text: qrText,
                    width: 200, // Largura do QR Code
                    height: 200, // Altura do QR Code
                    colorDark: "#000000", // Cor do QR Code
                    colorLight: "#ffffff", // Cor de fundo
                });
            } else {
                alert("Por favor, insira algum texto ou URL para gerar o QR Code.");
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>


</body>

</html>