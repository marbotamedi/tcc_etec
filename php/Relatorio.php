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
    <title>Relatório</title>
    <link rel="stylesheet" href="../css/relatorio.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <img src="../imgs/logo.jpeg" alt="Logo" class="logo">
            <a href="../index.php" class="menu-item">
                <img src="../imgs/dashboard-removebg-preview.png" alt="Home">
                Dashboard
            </a>
            <a href="./Vendas.php" class="menu-item">
                <img src="../imgs/vendas-removebg-preview.png" alt="Vendas">
                Vendas
            </a>
            <a href="../php/Financeiro.php" class="menu-item">
                <img src="../imgs/financeiro-removebg-preview.png" alt="Financeiro">
                Financeiro
            </a>
            <a href="./abaCadastro.php" class="menu-item">
                <img src="../imgs/cadastro-removebg-preview.png" alt="Cadastro">
                Cadastro
            </a>
            <a href="./estoque.php" class="menu-item">
                <img src="../imgs/estoque-removebg-preview.png" alt="Estoque">
                Estoque
                <div class="item-aviso">
                    <img src="../imgs/aviso.png" alt="">
                </div>
            </a>
            <a href="./configuracao.php" class="menu-item">
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
                <!-- Conteúdo principal aqui -->
                <div class="forma-Cabecalho">
                    <h2 class="cab">RELATÓRIO</h2>
                    <div class="input-data">

                        <form id="date-form" onsubmit="handleSubmit(event)">
                            <label for="date-type">Escolha o tipo de data:</label>
                            <select id="date-type" name="date-type" onchange="toggleDateFields()">
                                <option value="range">Buscar por periodo</option>
                                <option value="specific">Data especifica</option>
                            </select>

                            <div id="date-range" style="display: none;">
                                <label for="start-date">De:</label>
                                <input type="date" id="start-date" name="start-date">
                                <label for="end-date">Até:</label>
                                <input type="date" id="end-date" name="end-date">
                            </div>

                            <div id="specific-date" style="display: none;">
                                <label for="specific-date-input">Data:</label>
                                <input type="date" id="specific-date-input" name="specific-date">
                            </div>
                            <button type="submit">Buscar</button>
                        </form>
                    </div>
                </div>
                <table id="table-products">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Preço Unitário</th>
                            <th>Total (R$)</th>
                            <th>Forma de Pagamento</th>
                            <th>Troco</th>
                        </tr>
                    </thead>
                    <tbody id="corpo-tabela">

                    </tbody>

                </table>

            </div>
            <div class="botao-Relatorio">
                <button id="print-button" onclick="printReport()">Imprimir Relatório</button>
            </div>

        </div>
    </div>


    <script>
        // Função JavaScript opcional para interatividade com o menu
        function trocarUsuario() {
            var usuarioSelecionado = document.getElementById('usuario').value;
            document.getElementById('mensagem').textContent = "Usuário trocado para: " + usuarioSelecionado;
        }

        function printReport() {
            var printContents = document.querySelector(".content").innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
        //-----------------------script que recebe o conteudo da tabela da compra---------------------------//

        // Obtém o conteúdo da tabela do localStorage
        var tableContent = localStorage.getItem("tableContent");

        // Verifica se o conteúdo existe
        if (tableContent) {
            // Exibe o conteúdo da tabela na página
            document.getElementById("corpo-tabela").innerHTML = tableContent;

            

            // Seleciona todas as células que estavam ocultas (com display: none)
            var camposOcultos = document.querySelectorAll("td[style='display: none;']");

            // Torna as células ocultas visíveis (remove o display: none)
            camposOcultos.forEach(function(campo) {
                campo.style.display = 'table-cell'; // Muda de 'none' para 'table-cell', tornando-a visível
            });
        }

        
    </script>
    <script src="../js/relogio.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/pesquisaProdutos.js"></script>
    <script src="../js/menuhover.js"></script>
    <script src="../js/enviarDados.js"></script>


    <!--CSS DA TABELA------>

</html>