<?php
require __DIR__ . "/session.php";

// Proteção da página
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Perfil | Coldplay Fanpage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container mt-5 text-center">
    <h1>Bem-vindo, <?= htmlspecialchars($_SESSION["username"]) ?> 🎶</h1>

    <p class="mt-3">
        Esta página só é acessível após login.
    </p>

    <a href="logout.php" class="btn btn-danger mt-4">
        Logout
    </a>
</div>

</body>
</html>
