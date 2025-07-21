<?php
session_start();

// Limpa todas as variáveis da sessão
$_SESSION = array();

// Remove o cookie de sessão, se estiver em uso
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();

// (Opcional) Define uma mensagem de logout para exibir na tela de login
session_start();
$_SESSION['mensagem'] = "Você saiu com sucesso.";

// Redireciona para a tela de login
header("Location: login.php");
exit;
?>
