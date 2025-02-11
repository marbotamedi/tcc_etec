<?php
session_start(); // Inicia a sessão para acessar as variáveis de sessão

// Verifica se o usuário está logado
if (isset($_SESSION['usuario_logado'])) {
    $nome_usuario = $_SESSION['usuario_logado']; // Armazena o nome do usuário logado
} else {
    $nome_usuario = "Usuário"; // Caso não esteja logado, exibe "Usuário"
}

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
$sql = "SELECT nome, marca, preco, quantidade, validade FROM produtos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/csstabela.css">
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
            <div class="main">
                <!-- Conteúdo principal aqui -->


                <table id="tabelaProdutos">
                    <thead>
                        <tr>
                            <th>Nome do Produto</th>
                            <th>Marca</th>
                            <th>Preço</th>
                            <th>Qtd</th>
                            <th>Validade</th>
                        </tr>
                    </thead>
                    <div class="formularioEstoque">
                        <form id="formPesquisa" method="GET">
                            <input type="text" placeholder="Pesquisar..." class="pesquisa" name="campoPesquisa" id="campo-Pesquisa">
                            <button type="submit" class="btn-pesquisa">Enviar</button>
                            <button type="button" id="btn-clear" class="btn-clear1">Limpar</button>
                        </form>
                    </div>
                    <tbody>
                        <?php
                        // Verifica se há resultados e exibe os produtos
                        if ($result->num_rows > 0) {
                            $counter = 0;
                            $produtos_baixo_estoque = []; // Inicializa o array para produtos com estoque baixo

                            // Saída de cada linha
                            while ($row = $result->fetch_assoc()) {
                                // Exibe apenas os primeiros 10 produtos na tabela
                                if ($counter < 10) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["marca"]) . "</td>";
                                    echo "<td>" . number_format($row["preco"], 2, ',', '.') . "</td>"; // Formata o preço
                                    echo "<td>" . htmlspecialchars($row["quantidade"]) . "</td>";
                                    echo "<td>" . date("d/m/Y", strtotime($row["validade"])) . "</td>"; // Formata a data
                                    echo "</tr>";
                                    $counter++;
                                }

                                // Verifica se a quantidade é menor ou igual a 3 e adiciona ao array
                                if ($row["quantidade"] <= 3) {
                                    $produtos_baixo_estoque[] = htmlspecialchars($row["nome"]); // Adiciona o nome do produto ao array
                                }
                            }

                            // Exibe a mensagem se houver produtos em estoque baixo
                            if (!empty($produtos_baixo_estoque)) {
                                echo '<div class="header-aviso" style="display: flex; align-items: center;">
            <img src="../imgs/aviso.png" alt="" srcset="" style="margin-right: 10px;">
            <span>Estoque baixo para: ' . implode(", ", $produtos_baixo_estoque) . '</span>
         <div class="conteudo01">
         </div> </div> ';
                            }
                        } else {
                            echo "<tr><td colspan='5'>Nenhum produto cadastrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    // Fecha a conexão
    $conn->close();
    ?>
</body>
<script src="../js/relogio.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/pesquisaProdutos.js"></script>
<script src="../js/menuhover.js"></script>


</html>