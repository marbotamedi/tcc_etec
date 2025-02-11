<?php
// Conexão com o banco de dados
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "sysglr";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o termo de pesquisa foi passado
$termo = isset($_POST['campoPesquisa']) ? $_POST['campoPesquisa'] : '';

// Prepara a consulta SQL para buscar os produtos que correspondem ao termo de pesquisa
if ($termo != '') {
    // A consulta deve buscar nas colunas nome, marca, preço, quantidade, validade
    $sql_result = $conn->prepare("SELECT * FROM produtos WHERE nome LIKE ? OR marca LIKE ? OR preco LIKE ? OR quantidade LIKE ? OR validade LIKE ?");
    $termo_completo = "%" . $termo . "%";  // Adiciona o "%" para a busca parcial
    $sql_result->bind_param("sssss", $termo_completo, $termo_completo, $termo_completo, $termo_completo, $termo_completo);
    $sql_result->execute();
    $result = $sql_result->get_result();

    // Exibe os resultados
    if ($result->num_rows > 0) {
        while ($line = $result->fetch_assoc()) {
            echo "<tr><td>" . $line['nome'] . "</td><td>" . $line['marca'] . "</td><td>" . $line['preco'] . "</td><td>" . $line['quantidade'] . "</td><td>" . $line['validade'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum produto encontrado para o termo '$termo'.";
    }
} elseif ($termo == '') {
    // Quando o campo de pesquisa está vazio, exibe todos os produtos
    $sql_result = "SELECT * FROM produtos";
    $result = $conn->query($sql_result);

    // Exibe todos os produtos
    if ($result->num_rows > 0) {
        while ($line = $result->fetch_assoc()) {
            echo "<tr><td>" . $line['nome'] . "</td><td>" . $line['marca'] . "</td><td>" . $line['preco'] . "</td><td>" . $line['quantidade'] . "</td><td>" . $line['validade'] . "</td></tr>";
        }
    } else {
        echo "Nenhum produto encontrado.";
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
