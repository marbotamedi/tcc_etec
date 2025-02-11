-- Criação do banco de dados
CREATE DATABASE sysglr;
USE sysglr;


select *from produtos;
TRUNCATE table produtos;
select *from usuarios;
TRUNCATE TABLE usuarios;
drop table usuarios;


INSERT INTO produtos (nome, marca, preco, quantidade, validade)
VALUES
-- Salgados
('Coxinha de Frango', 'LIDIANE SALGADOS', 5.00, 100, '2025-03-01'),
('Coxinha de Carne', 'LIDIANE SALGADOS', 6.00, 80, '2025-03-01'),
('Empada de Frango', 'LIDIANE SALGADOS', 4.50, 120, '2025-02-28'),
('Empada de Palmito', 'LIDIANE SALGADOS', 4.80, 110, '2025-02-28'),
('Risole de Carne', 'LIDIANE SALGADOS', 5.20, 95, '2025-03-03'),
('Risole de Frango', 'LIDIANE SALGADOS', 5.00, 90, '2025-03-03'),
('Quibe Frito', 'LIDIANE SALGADOS', 6.50, 50, '2025-03-10'),
('Quibe Assado', 'LIDIANE SALGADOS', 6.00, 60, '2025-03-10'),
('Bolinho de Bacalhau', 'LIDIANE SALGADOS', 7.00, 70, '2025-03-15'),
('Bolinho de Mandioca', 'LIDIANE SALGADOS', 4.50, 65, '2025-03-15'),
('Pastel de Carne', 'LIDIANE SALGADOS', 5.00, 130, '2025-03-20'),
('Pastel de Queijo', 'LIDIANE SALGADOS', 4.80, 140, '2025-03-20'),
('Pão de Queijo', 'LIDIANE SALGADOS', 3.50, 200, '2025-03-25'),
('Tapioca de Frango', 'LIDIANE SALGADOS', 5.50, 150, '2025-03-30'),
('Tapioca de Queijo', 'LIDIANE SALGADOS', 5.00, 160, '2025-03-30'),
('Mini Pizza', 'LIDIANE SALGADOS', 6.00, 75, '2025-04-02'),
('Mini Pizza de Frango', 'LIDIANE SALGADOS', 6.50, 85, '2025-04-02'),
('Mini Pizza de Calabresa', 'LIDIANE SALGADOS', 6.50, 90, '2025-04-02'),
('Bolinhos de Arroz', 'LIDIANE SALGADOS', 4.00, 120, '2025-04-05'),
('Bolinhos de Carne', 'LIDIANE SALGADOS', 5.20, 110, '2025-04-05'),
('Bolinhos de Frango', 'LIDIANE SALGADOS', 5.00, 130, '2025-04-05'),
('Torta de Frango', 'LIDIANE SALGADOS', 7.50, 60, '2025-04-10'),
('Torta de Carne', 'LIDIANE SALGADOS', 7.80, 50, '2025-04-10'),
('Biscoito de Polvilho', 'LIDIANE SALGADOS', 3.00, 180, '2025-04-12'),
('Biscoito de Queijo', 'LIDIANE SALGADOS', 3.50, 190, '2025-04-12'),
('Torta de Palmito', 'LIDIANE SALGADOS', 8.00, 60, '2025-04-15'),
('Esfiha de Carne', 'LIDIANE SALGADOS', 5.50, 100, '2025-04-15'),
('Esfiha de Frango', 'LIDIANE SALGADOS', 5.00, 110, '2025-04-15'),

-- Sucos e Refrigerantes
('Suco de Laranja 500ml', 'LIDIANE SALGADOS', 6.00, 200, '2025-05-01'),
('Suco de Uva 500ml', 'LIDIANE SALGADOS', 6.50, 180, '2025-05-01'),
('Suco de Limão 500ml', 'LIDIANE SALGADOS', 5.50, 190, '2025-05-01'),
('Suco de Maracujá 500ml', 'LIDIANE SALGADOS', 6.00, 170, '2025-05-01'),
('Refrigerante Coca-Cola 350ml', 'LIDIANE SALGADOS', 4.50, 150, '2025-05-10'),
('Refrigerante Guaraná Antarctica 350ml', 'LIDIANE SALGADOS', 4.50, 160, '2025-05-10'),
('Refrigerante Fanta Laranja 350ml', 'LIDIANE SALGADOS', 4.50, 140, '2025-05-10'),
('Refrigerante Sprite 350ml', 'LIDIANE SALGADOS', 4.50, 150, '2025-05-10'),
('Suco de Abacaxi 500ml', 'LIDIANE SALGADOS', 6.00, 200, '2025-05-12'),
('Suco de Acerola 500ml', 'LIDIANE SALGADOS', 6.50, 210, '2025-05-12'),

-- Doces
('Brigadeiro', 'LIDIANE SALGADOS', 2.50, 200, '2025-05-15'),
('Beijinho', 'LIDIANE SALGADOS', 2.80, 150, '2025-05-15'),
('Cajuzinho', 'LIDIANE SALGADOS', 3.00, 180, '2025-05-15'),
('Pé-de-moleque', 'LIDIANE SALGADOS', 3.50, 170, '2025-05-15'),
('Bolo de Rolo', 'LIDIANE SALGADOS', 5.00, 80, '2025-05-20'),
('Bolo de Chocolate', 'LIDIANE SALGADOS', 5.00, 90, '2025-05-20'),
('Bolo de Cenoura', 'LIDIANE SALGADOS', 5.00, 100, '2025-05-20'),
('Mousse de Maracujá', 'LIDIANE SALGADOS', 4.50, 200, '2025-05-25'),
('Mousse de Limão', 'LIDIANE SALGADOS', 4.80, 190, '2025-05-25'),
('Pavê de Chocolate', 'LIDIANE SALGADOS', 5.50, 120, '2025-05-25');







INSERT INTO usuarios (nome, email, tipo_usuario)
VALUES
('João Silva', 'joao.silva@example.com', 'admin'),
('Maria Souza', 'maria.souza@example.com', 'vendedor'),
('Carlos Pereira', 'carlos.pereira@example.com', 'suporte'),
('Ana Costa', 'ana.costa@example.com', 'vendedor'),
('Pedro Oliveira', 'pedro.oliveira@example.com', 'admin');
describe usuarios;


-- Criação da tabela de usuários
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(50) UNIQUE NULL,
    senha VARCHAR(255) NOT NULL,
    tipo_usuario tinyint NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status01 ENUM('ativo', 'inativo') DEFAULT 'ativo'
    
    );




-- Criação da tabela de fornecedores
CREATE TABLE fornecedores (
    id_fornecedor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cnpj VARCHAR(18) NOT NULL,
    telefone VARCHAR(15),
    email VARCHAR(255),
    endereco TEXT
);



-- Criação da tabela de produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    marca TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    quantidade INT DEFAULT 0,
    validade DATE
);

-- Criação da tabela de estoque

-- Criação da tabela de vendas
CREATE TABLE vendas (
    id_venda INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_produto INT,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_venda DECIMAL(10, 2) NOT NULL,
    status_pagamento ENUM('pago', 'não pago') NOT NULL,
    forma_pagamento ENUM('dinheiro', 'cartão', 'transferência') NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_produto) REFERENCES produtos(id_produto)
);

-- Criação da tabela de suporte
CREATE TABLE suporte (
    id_suporte INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    descricao TEXT NOT NULL,
    status ENUM('aberto', 'fechado') DEFAULT 'aberto',
    data_abertura TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_fechamento TIMESTAMP,
    resposta_suporte TEXT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);


CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL, -- Nome completo do usuário
    cpf VARCHAR(11) NOT NULL UNIQUE, -- CPF, com 11 caracteres sem pontuação
    telefone VARCHAR(15), -- Telefone, incluindo DDD
    email VARCHAR(255) NOT NULL UNIQUE, -- E-mail, deve ser único
    endereco VARCHAR(255), -- Endereço completo do usuário
    bairro VARCHAR(100), -- Bairro
    numero INT, -- Número da casa
    cidade VARCHAR(100), -- Cidade
    estado CHAR(2) -- Estado, usando siglas como SP, RJ, etc.
)CHARACTER SET utf8 COLLATE utf8_general_ci;