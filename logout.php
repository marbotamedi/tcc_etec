<?php
// Inicia a sessão
session_start();

// Limpa todas as variáveis da sessão
$_SESSION = [];

// Destrói o cookie da sessão, se existir
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();

// Desativa o cache para evitar que o usuário volte para páginas protegidas
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redireciona para a página de login ou inicial
header("Location: login.html);
");
exit;


?>
