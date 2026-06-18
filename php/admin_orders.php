<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db.php";

checkAdmin();

$message = "";

// =========================
// MARCAR COMO COMPLETED
// =========================
if (isset($_GET['complete'])) {
    $id = (int) $_GET['complete'];

    mysqli_query($conn, "UPDATE orders SET status = 'completed' WHERE id = $id");

    $message = "Encomenda #$id concluída!";
}

// =========================
// LISTAR ORDERS
// =========================
$orders = [];

$query = "
SELECT 
    orders.id, 
    users.name, 
    orders.order_date, 
    orders.status
FROM orders
JOIN users ON orders.user_id = users.id
ORDER BY orders.order_date DESC
";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Encomendas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-dark text-white">

<?php include __DIR__ . "/navbar.php"; ?>

<div class="container mt-5">

    <h1>Gestão de Encomendas</h1>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <table class="table table-dark">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Data</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>

        <?php foreach ($orders as $o): ?>
        <tr>
            <td>#<?= $o['id'] ?></td>
            <td><?= htmlspecialchars($o['name']) ?></td>
            <td><?= $o['order_date'] ?></td>
            <td><?= $o['status'] ?></td>

            <td>
                <?php if ($o['status'] === 'pending'): ?>
                    <a href="?complete=<?= $o['id'] ?>" class="btn btn-success btn-sm">
                        Processar
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>