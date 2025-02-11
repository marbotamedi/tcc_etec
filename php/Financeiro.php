<?php
session_start(); // Inicia a sessão para acessar as variáveis de sessão

// Verifica se o usuário está logado
if (isset($_SESSION['usuario_logado'])) {
    $nome_usuario = $_SESSION['usuario_logado']; // Armazena o nome do usuário logado
} else {
    $nome_usuario = "Usuário"; // Caso não esteja logado, exibe "Usuário"
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/cadastrarVendas.css">
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <img src="../imgs/logo.jpeg" alt="Logo" class="logo">
            <a href="../index.php" class="menu-item">
                <img src="../imgs/dashboard-removebg-preview.png" alt="Home">
                Dashboard
            </a>
            <a href="../php/Vendas.php" class="menu-item">
                <img src="../imgs/vendas-removebg-preview.png" alt="Vendas">
                Vendas
            </a>
            <a href="../php/Financeiro.php" class="menu-item">
                <img src="../imgs/financeiro-removebg-preview.png" alt="Financeiro">
                Financeiro
            </a>
            <a href="../php/abaCadastro.php" class="menu-item">
                <img src="../imgs/cadastro-removebg-preview.png" alt="Cadastro">
                Cadastro
            </a>

            <a href="../php/estoque.php" class="menu-item">
                <img src="../imgs/estoque-removebg-preview.png" alt="Estoque">
                Estoque
                <div class="item-aviso">
                    <img src="../imgs/aviso.png" alt="">
                </div>
            </a>
            <a href="../php/configuracao.php" class="menu-item">
                <img src="../imgs/configuracoes-removebg-preview.png" alt="Configurações">
                Configurações
            </a>
        </div>

        <div class="content">
            <div class="header">
                <div class="date">
                    <img src="../imgs/compromisso.png" alt="Data">
                    <span class="date-span"></span>
                </div>
                <div class="user" id="user">
                    <img src="../imgs/do-utilizador (3).png" alt="Usuário" class="foto">
                    <span><?php echo htmlspecialchars($nome_usuario); ?></span>

                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="logout.php" class="hover-1">Sair</a>
                    </div>
                </div>
            </div>
            <div class="main01">
                <div class="grupoPai">
                    <a href="./teste01.php" class="buttonCad">CADASTRAR VENDAS</a>
                    <a href="../PHP/Relatorio.php" class="buttonCad">VER RELATÓRIO</a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Função JavaScript opcional para interatividade com o menu
        function trocarUsuario() {
            var usuarioSelecionado = document.getElementById('usuario').value;
            document.getElementById('mensagem').textContent = "Usuário trocado para: " + usuarioSelecionado;
        }
    </script>
    <script src="../js/relogio.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/pesquisaProdutos.js"></script>
    <script src="../js/menuhover.js"></script>
</body>

</html>