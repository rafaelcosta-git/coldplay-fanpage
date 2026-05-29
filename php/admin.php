<?php 
require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db.php";

// Garantir acesso só para admin
checkAdmin();

// CONTAGENS (MYSQLI)
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$totalProdutos = mysqli_fetch_assoc($result)['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$totalUsers = mysqli_fetch_assoc($result)['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE status = 'pending'");
$totalOrders = mysqli_fetch_assoc($result)['total'];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin | Coldplay</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- TEU CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-dark text-white">

<?php include __DIR__ . "/navbar.php"; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Painel de Controlo Administrativo</h2>
    
    <div class="row g-4">

        <!-- PRODUTOS -->
        <div class="col-md-4">
            <div class="card bg-primary bg-opacity-25 border-primary h-100 p-4 text-center shadow">
                <i class="fa-solid fa-box-open fa-3x mb-3 text-primary"></i>
                <h3>Produtos: <?= $totalProdutos ?></h3>
                <p class="text-white-50">Gerir catálogo de produtos.</p>
                <a href="admin_products.php" class="btn btn-primary mt-auto">Gerir Produtos</a>
            </div>
        </div>

        <!-- USERS -->
        <div class="col-md-4">
            <div class="card bg-info bg-opacity-25 border-info h-100 p-4 text-center shadow">
                <i class="fa-solid fa-users fa-3x mb-3 text-info"></i>
                <h3>Utilizadores: <?= $totalUsers ?></h3>
                <p class="text-white-50">Gerir contas e permissões.</p>
                <a href="admin_users.php" class="btn btn-info mt-auto">Gerir Utilizadores</a>
            </div>
        </div>

        <!-- ORDERS -->
        <div class="col-md-4">
            <div class="card bg-success bg-opacity-25 border-success h-100 p-4 text-center shadow">
                <i class="fa-solid fa-cart-check fa-3x mb-3 text-success"></i>
                <h3>Encomendas Pendentes: <?= $totalOrders ?></h3>
                <p class="text-white-50">Ver e processar pedidos.</p>
                <a href="admin_orders.php" class="btn btn-success mt-auto">Gerir Encomendas</a>
            </div>
        </div>

    </div>
</div>

</body>
</html>