<?php
require_once __DIR__ . "/session.php";

// Proteção da página: se não houver ID de utilizador, expulsa para o login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Incluímos a Navbar aqui (ela já está preparada para lidar com os nomes)
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Perfil | Coldplay Fanpage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-dark text-light">

<div class="container mt-5 text-center">
    <?php 
        $nomeExibir = $_SESSION["user_name"] ?? $_SESSION["username"] ?? "Fã";
        $cargo = $_SESSION["user_role"] ?? "user";
    ?>

    <h1 class="display-4 fw-bold text-warning">Bem-vindo, <?= htmlspecialchars($nomeExibir) ?> 🎶</h1>

    <div class="card bg-secondary bg-opacity-25 border-0 rounded-4 p-4 mt-4 mx-auto" style="max-width: 500px;">
        <p class="lead">Esta é a tua área exclusiva de fã.</p>
        <p class="text-info fw-bold">Nível de Acesso: <?= strtoupper($cargo) ?></p>
        <hr class="border-secondary">
        
        <div class="d-grid gap-2 d-md-block">
            <a href="loja.php" class="btn btn-primary px-4 me-md-2">Ir para a Loja</a>
            
            <?php if ($cargo === 'admin'): ?>
                <a href="admin.php" class="btn btn-warning px-4">Painel Admin</a>
            <?php endif; ?>
        </div>
    </div>

    <br>
    <a href="logout.php" class="btn btn-outline-danger mt-5">
        <i class="fa-solid fa-right-from-bracket"></i> Terminar Sessão
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>