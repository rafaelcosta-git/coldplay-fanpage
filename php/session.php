<?php
// Configuracoes básicas para a sessao funcionar em qualquer pasta
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_start();

// Funcao para proteger a area de administracao
function checkAdmin() {
    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
        header("Location: login.php");
        exit;
    }
}
?>