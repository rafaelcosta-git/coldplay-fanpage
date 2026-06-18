<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$result = mysqli_query(
    $conn,
    "SELECT *
     FROM orders
     WHERE user_id = $user_id
     ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Minhas Compras</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-white">

<?php include __DIR__ . "/navbar.php"; ?>

<div class="container my-5">

    <h1 class="mb-4">
        Minhas Compras
    </h1>

    <?php if(mysqli_num_rows($result) == 0): ?>

        <div class="alert alert-info">
            Ainda não efetuaste nenhuma compra.
        </div>

    <?php else: ?>

       <?php while($order = mysqli_fetch_assoc($result)): ?>

<div class="card bg-dark text-white mb-4 border border-secondary shadow">

    <div class="card-header d-flex justify-content-between bg-black border-secondary shadow-lg">

        <strong>
            Pedido #<?= $order['id']; ?>
        </strong>


        <span class="badge bg-success">
            Concluída
        </span>

    </div>

    <div class="card-body bg-dark">

        <p>
            <strong>Data:</strong>
            <?= $order['order_date']; ?>
        </p>

        <?php
        $totalOrder = 0;
        ?> 

        <?php

$products = mysqli_query(
    $conn,
    "SELECT p.name,
            p.image,
            p.price,
            oi.quantity
     FROM order_items oi
     INNER JOIN products p
        ON oi.product_id = p.id
     WHERE oi.order_id = {$order['id']}"
);

if(mysqli_num_rows($products) > 0):
?>

<h5>Produtos Comprados</h5>

<?php

while($product = mysqli_fetch_assoc($products)):

    $totalOrder += $product['price'] * $product['quantity'];
?>

<div class="d-flex align-items-center mb-3">

    <img
        src="../<?= str_replace('\\', '/', $product['image']); ?>"
        width="80"
        class="me-3 rounded"
    >

    <div>

        <strong>
            <?= $product['name']; ?>
        </strong>

        <br>

        Quantidade:
        <?= $product['quantity']; ?>

        <br>

        Preço:
        <?= number_format($product['price'], 2); ?> €

    </div>

</div>

<?php
endwhile;

endif;
?>


<?php

$events = mysqli_query(
    $conn,
    "SELECT e.name,
            e.date,
            t.quantity,
            t.price
     FROM tickets t
     INNER JOIN events e
        ON t.event_id = e.id
     WHERE t.order_id = {$order['id']}"
);

if (!$events) {
    die(mysqli_error($conn));
}

if (mysqli_num_rows($events) > 0):
?>    

 <h5 class="mt-4">Concertos Comprados</h5>

<?php

    while($event = mysqli_fetch_assoc($events)):
    
    $totalOrder += $event['price'] * $event['quantity'];
?>

    <div class="mb-3">

        <strong>
            🎫 <?= $event['name']; ?>
        </strong>

        <br>

        Data:
        <?= $event['date']; ?>

        <br>

        Quantidade:
        <?= $event['quantity']; ?>

        <br>

        Preço:
        <?= number_format($event['price'], 2); ?> €



    </div>
 
<?php
    endwhile;

endif;

?>


 <hr>
        <h5 class="text-end">
           Total da Encomenda:
        <?= number_format($totalOrder, 2); ?> €
        </h5>


    </div>

</div>

<?php endwhile; ?>

    <?php endif;
    
    ?>

</div>

<footer class="bg-dark text-white text-center p-4 mt-5 border-top">

    <p>&copy; 2026 Coldplay Fanpage. Todos os direitos reservados.</p>

    <div class="footer-social">
        <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
        <a href="#" class="text-white me-3"><i class="fab fa-youtube"></i></a>
        <a href="#" class="text-white me-3"><i class="fab fa-tiktok"></i></a>
        <a href="#" class="text-white me-3"><i class="fab fa-spotify"></i></a>
        <a href="#" class="text-white me-3"><i class="fab fa-apple"></i></a>
        <a href="#" class="text-white"><i class="fab fa-x-twitter"></i></a>
    </div>

</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>