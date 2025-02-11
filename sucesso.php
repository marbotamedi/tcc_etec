<?php
// Inicia a sessão para acessar as variáveis de sessão
session_start();

// Verifica se há alguma mensagem de sucesso na sessão
if (isset($_SESSION['msg'])) {
    // Exibe a mensagem de sucesso
    header("Location: cadastroProdutos.php");
    
    // Limpa a mensagem após exibi-la
    unset($_SESSION['msg']);
} else {
    // Caso não haja mensagem, exibe uma mensagem padrão
    header("Location: cadastroProdutos.php");
}
?>