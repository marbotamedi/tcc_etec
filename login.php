<?php
session_start(); // Inicia a sessão para armazenar o nome do usuário

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "sysglr";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];  // Agora pegando o nome
    $senha = $_POST['senha'];

    // Prepara a consulta SQL para buscar pelo nome
    $sql = "SELECT * FROM usuarios WHERE nome = '$nome'"; // Alterado para buscar pelo nome
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_logado'] = $user['nome']; // Armazena o nome na sessão
            header("Location: index.php"); // Redireciona para a página PHP
            exit();
        } else {
            echo "<script>alert('Senha incorreta.');</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado.');</script>";
    }
}

// Após a verificação do login (no arquivo login.php)
$_SESSION['tipo_usuario'] = $user['tipo_usuario']; // Armazena o tipo do usuário na sessão


$conn->close();
?>
