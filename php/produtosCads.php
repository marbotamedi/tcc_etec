<?php
// Inicia a sessão para acessar as variáveis de sessão, se necessário
session_start();
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "sysglr";
// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $marca = mysqli_real_escape_string($conn, $_POST['marca']);
    $preco = mysqli_real_escape_string($conn, $_POST['preco']);
    $quantidade = mysqli_real_escape_string($conn, $_POST['quantidade']);
    $validade = mysqli_real_escape_string($conn, $_POST['validade']);

    // Comando SQL para inserir os dados no banco
    $sql = "INSERT INTO produtos (nome, marca, preco, quantidade, validade) 
            VALUES ('$nome', '$marca', '$preco', '$quantidade', '$validade')";

    // Executa o comando SQL e verifica se foi bem-sucedido
    if ($conn->query($sql) === TRUE) {
        // Redireciona para outra página (opcional)
        header("Produtos Cadastrados!");
    } else {
        header("Erro ao cadastrar o produto") . $conn->error;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
