<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sysglr";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $tipo_usuario1 = (int)($_POST['tipo_usuario'] ?? 0);

    if (empty($nome) || empty($email) || empty($senha) || empty($tipo_usuario1)) {
        echo "<script>alert('Por favor, preencha todos os campos.');</script>";
        exit();
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, ?)");
    $sql->bind_param("sssi", $nome, $email, $senha_hash, $tipo_usuario1);

    if ($sql->execute()) {
        $_SESSION['usuario_logado'] = $nome;
        echo "<script>alert('Cadastro realizado com sucesso!');</script>";
        header("Location: login.html");
        exit();
    } else {
        echo "<script>alert('Erro ao cadastrar: " . $sql->error . "');</script>";
    }
}

$conn->close();
?>
