<?php
// Configuração do banco de dados
$host = 'localhost:3306';
$dbname = 'sysglr';
$username = 'root';
$password = '';

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta ao banco de dados
    $query = "SELECT nome, email, status01 FROM usuarios";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>


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
    <link rel="stylesheet" href="../css/graficos.css">
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
            <div class="main01">
                <!-- Conteúdo principal aqui -->
                <?php
                try {
                    // Conexão com o banco de dados
                    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Consulta ao banco de dados para buscar id, nome, email, status e pags
                    $query = "SELECT  nome, email, status01, tipo_usuario FROM usuarios";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();

                    // Busca todos os resultados e armazena em $usuarios
                    $usuarios1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
                    exit; // Encerra a execução do script em caso de erro
                }
                // Exibindo os resultados
                echo "<h1>Lista de Usuários</h1>";
                echo "<form method='POST' action='salvar_acessos.php'>"; // O formulário enviará para o arquivo 'salvar_acessos.php'
                echo "<table border='1' cellpadding='10'>";
                echo "<tr><th>Nome</th><th>Email</th><th>Status</th><th>Tipo Usuário</th></tr>";

                // Lista de usuários simulados com os acessos (1 = Acessada, 0 = Não Acessada)


                foreach ($usuarios1 as $user) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($user['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['status01']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['tipo_usuario']) . "</td>";

                    echo "</tr>";
                }

                echo "</table>";
                echo "</form>";


                ?>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    try {
                        // Conexão com o banco de dados
                        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Executa a operação de TRUNCATE na tabela usuarios
                        $query = "TRUNCATE TABLE usuarios;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();

                        // Armazena uma variável de sucesso no sessionStorage
                        echo "<script>sessionStorage.setItem('exclusao_sucesso', 'true');</script>";

                        // Redireciona para a página de sucesso após a execução do TRUNCATE
                        header("Location: usuariosBanco.php");
                        exit; // Adiciona o exit para garantir que o código pare após o redirecionamento
                    } catch (PDOException $e) {
                        echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
                    }
                }
                ?>




                <!-- Formulário HTML com Botão de Exclusão -->
                <form method="POST" action="">
                    <input type="submit" name="excluir" value="Excluir Cadastros">
                </form>
                <br>


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