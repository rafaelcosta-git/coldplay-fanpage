<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('checkAdmin')) {
    function checkAdmin() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: profile.php");
            exit;
        }
    }
}
?>