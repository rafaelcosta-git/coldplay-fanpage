<?php
require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db.php";

// Apenas Admin
checkAdmin();

// Produtos
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$totalProdutos = mysqli_fetch_assoc($result)['total'];

// Utilizadores
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$totalUsers = mysqli_fetch_assoc($result)['total'];

// Encomendas pendentes
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE status='pending'");
$totalOrders = mysqli_fetch_assoc($result)['total'];

// Eventos
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM events");
$totalEvents = mysqli_fetch_assoc($result)['total'];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin | Coldplay</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-dark text-white">

<?php include __DIR__ . "/navbar.php"; ?>

<div class="container mt-5">

    <h1 class="text-center mb-2">
        Painel de Controlo Administrativo
    </h1>

    <p class="text-center text-secondary mb-5">
        Bem-vindo ao painel de administração.
    </p>

    <!-- RESUMO -->
    <div class="alert alert-dark border border-warning text-center mb-5">

        <strong><?= $totalProdutos ?></strong> Produtos |

        <strong><?= $totalUsers ?></strong> Utilizadores |

        <strong><?= $totalEvents ?></strong> Eventos |

        <strong><?= $totalOrders ?></strong> Encomendas Pendentes

    </div>

    <div class="row g-4">

        <!-- PRODUTOS -->
        <div class="col-md-6 col-lg-3">

            <div class="card admin-card bg-primary bg-opacity-25 border-primary h-100 p-4 text-center shadow">

                <i class="fa-solid fa-box-open fa-3x mb-3 text-primary"></i>

                <h3>Produtos</h3>

                <h2><?= $totalProdutos ?></h2>

                <p class="text-white-50">
                    Gerir catálogo de produtos.
                </p>

                <a href="admin_products.php" class="btn btn-primary mt-auto">
                    Gerir Produtos
                </a>

            </div>

        </div>

        <!-- UTILIZADORES -->
        <div class="col-md-6 col-lg-3">

            <div class="card admin-card bg-info bg-opacity-25 border-info h-100 p-4 text-center shadow">

                <i class="fa-solid fa-users fa-3x mb-3 text-info"></i>

                <h3>Utilizadores</h3>

                <h2><?= $totalUsers ?></h2>

                <p class="text-white-50">
                    Gerir contas e permissões.
                </p>

                <a href="admin_users.php" class="btn btn-info mt-auto">
                    Gerir Utilizadores
                </a>

            </div>

        </div>

        <!-- ENCOMENDAS -->
        <div class="col-md-6 col-lg-3">

            <div class="card admin-card bg-success bg-opacity-25 border-success h-100 p-4 text-center shadow">

                <i class="fa-solid fa-cart-check fa-3x mb-3 text-success"></i>

                <h3>Encomendas</h3>

                <h2><?= $totalOrders ?></h2>

                <p class="text-white-50">
                    Pedidos pendentes.
                </p>

                <a href="admin_orders.php" class="btn btn-success mt-auto">
                    Gerir Encomendas
                </a>

            </div>

        </div>

        <!-- EVENTOS -->
        <div class="col-md-6 col-lg-3">

            <div class="card admin-card bg-warning bg-opacity-25 border-warning h-100 p-4 text-center shadow">

                <i class="fa-solid fa-calendar-days fa-3x mb-3 text-warning"></i>

                <h3>Eventos</h3>

                <h2><?= $totalEvents ?></h2>

                <p class="text-white-50">
                    Gerir concertos e tours.
                </p>

                <a href="admin_events.php" class="btn btn-warning mt-auto">
                    Gerir Eventos
                </a>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>