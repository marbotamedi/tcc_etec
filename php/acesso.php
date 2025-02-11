<?php
/* CÓDIGO DE VERIFICAÇÃO DE USUÁRIOS PARA AS PÁGINAS */
function verificar_acesso() { // Usando [1, 2, 3] como padrão

    // Verifica se o usuário está logado
    if (!isset($_SESSION['usuario_logado'])) {
        header("Location: index.php");
        exit();
    }
    $tipos_permitidos = [1, 2, 3];

    // Verifica se o tipo de usuário está entre os permitidos
    if (!in_array($_SESSION['tipo_usuario'], $tipos_permitidos)) {
        echo "<script>
                alert('Você não tem permissão para acessar esta página, por favor, logue novamente!');
                window.location.href = 'login.html';
              </script>";
        exit();
    }
}

// Após a verificação do login (no arquivo login.php)
$_SESSION['tipo_usuario'] = $user['tipo_usuario']; // Armazena o tipo do usuário na sessão

?>
