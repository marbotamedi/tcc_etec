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
    <link rel="stylesheet" href="../css/cadProd.css">
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
            <a href="#" class="menu-item">
                <img src="../imgs/financeiro-removebg-preview.png" alt="Financeiro">
                Financeiro
            </a>
            <a href="./abaCadastro.php" class="menu-item">
                <img src="../imgs/cadastro-removebg-preview.png" alt="Cadastro">
                Cadastro
            </a>
            <a href="./Relatorio.php" class="menu-item">
                <img src="../imgs/relatorios-removebg-preview.png" alt="Relatórios">
                Relatórios
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

            <div class="main">
                <!-- Conteúdo principal -->
                <div class="conteudo-principal">


                    <!-- Exibe a imagem de sucesso, se o produto foi cadastrado -->
                    <?php if (isset($_SESSION['produto_cadastrado']) && $_SESSION['produto_cadastrado'] === true): ?>
                        <div class="sucesso-cadastro">
                            <script>
                                window.onload = function() {
                                    alert('Sucesso no Cadastro!'); // Aqui você pode executar o código que desejar
                                };
                            </script>
                        </div>
                        <?php unset($_SESSION['produto_cadastrado']); // Limpa a variável de sessão 
                        ?>
                    <?php endif; ?>
                    <div class="formulariokct">
                        <div class="image">
                            <img src="../imgs/logo.jpeg" alt="" srcset="" width="350px">
                        </div>
                        <form action="processar_cadastro.php" method="POST" class="formulario">
                            <div class="form-group">
                                <label for="nome">Nome do Produto</label>
                                <input type="text" id="nome" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="marca">Marca</label>
                                <input type="text" id="marca" name="marca" required>
                            </div>
                            <div class="form-group">
                                <label for="preco">Preço</label>
                                <input type="number" id="preco" name="preco" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="quantidade">Quantidade</label>
                                <input type="number" id="quantidade" name="quantidade" required>
                            </div>
                            <div class="form-group">
                                <label for="validade">Validade</label>
                                <input type="date" id="validade" name="validade" required>
                            </div>
                            <div class="botaoenviar">
                                <button type="submit" class="cadastrar-prod">Cadastrar Produto</button>
                            </div>
                        </form>
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
    <script src="relogio.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="pesquisaProdutos.js"></script>
    <script src="menuhover.js"></script>
</body>

</html>