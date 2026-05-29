<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "coldplay_fanpage";

// Criar ligação
$conn = mysqli_connect($host, $user, $password, $database);

// Verificar ligação
if (!$conn) {
    die("Erro na ligação: " . mysqli_connect_error());
}

?>