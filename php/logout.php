<?php
session_start();
$_SESSION = array();
session_destroy();

// O segredo está aqui: o ficheiro agora é .php e não .html
header("location: ../index.php"); 
exit;
?>