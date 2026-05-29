<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

// PROTEÇÃO LOGIN
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$_SESSION["cart"] ??= [];

$items = [];
$total = 0.0;

// =========================
// PROCESSAR PRODUTOS
// =========================
$product_ids = [];

foreach ($_SESSION["cart"] as $key => $qty) {
    if (strpos($key, "product_") === 0) {
        $id = (int) str_replace("product_", "", $key);
        $product_ids[] = $id;
    }
}

if (!empty($product_ids)) {

    $ids = implode(",", $product_ids);

    if (!empty($ids)) {
        $result = mysqli_query($conn, "SELECT id, name, price, stock FROM products WHERE id IN ($ids)");

        while ($p = mysqli_fetch_assoc($result)) {

            $key = "product_" . $p["id"];
            $qty = min($_SESSION["cart"][$key], $p["stock"]);

            if ($qty <= 0) continue;

            $subtotal = $qty * $p["price"];
            $total += $subtotal;

            $items[] = [
                "type" => "product",
                "id" => $p["id"],
                "name" => $p["name"],
                "price" => $p["price"],
                "qty" => $qty,
                "subtotal" => $subtotal
            ];
        }
    }
}

// =========================
// PROCESSAR EVENTOS
// =========================
$event_ids = [];

foreach ($_SESSION["cart"] as $key => $qty) {
    if (strpos($key, "event_") === 0) {
        $id = (int) str_replace("event_", "", $key);
        $event_ids[] = $id;
    }
}

if (!empty($event_ids)) {

    $ids = implode(",", $event_ids);

    if (!empty($ids)) {
        $result = mysqli_query($conn, "SELECT id, name, price FROM events WHERE id IN ($ids)");

        while ($e = mysqli_fetch_assoc($result)) {

            $key = "event_" . $e["id"];
            $qty = $_SESSION["cart"][$key];

            $subtotal = $qty * $e["price"];
            $total += $subtotal;

            $items[] = [
                "type" => "event",
                "id" => $e["id"],
                "name" => $e["name"],
                "price" => $e["price"],
                "qty" => $qty,
                "subtotal" => $subtotal
            ];
        }
    }
}

$success = "";
$error = "";

// =========================
// PROCESSAR COMPRA
// =========================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($items)) {
        $error = "O teu carrinho está vazio.";
    } else {

        $user_id = $_SESSION["user_id"];

        // Criar encomenda
        mysqli_query($conn, "INSERT INTO orders (user_id, status) VALUES ('$user_id', 'pago')");
        $orderId = mysqli_insert_id($conn);

        foreach ($items as $item) {

            if ($item["type"] === "product") {

                $id = $item["id"];
                $qty = $item["qty"];

                // Atualizar stock
                $update = mysqli_query($conn, "UPDATE products SET stock = stock - $qty WHERE id = $id AND stock >= $qty");

                if (mysqli_affected_rows($conn) == 0) {
                    $error = "Produto sem stock: " . $item["name"];
                    break;
                }

                // Inserir item
                mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('$orderId', '$id', '$qty')");
            }

            if ($item["type"] === "event") {

                $id = $item["id"];
                $qty = $item["qty"];

                // Inserir tickets
                mysqli_query($conn, "INSERT INTO tickets (user_id, event_id, quantity) VALUES ('$user_id', '$id', '$qty')");
            }
        }

        if (!$error) {
            $_SESSION["cart"] = [];
            $success = "Compra concluída com sucesso! Pedido #$orderId";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container my-5">
    <h1>Checkout</h1>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <a href="loja.php" class="btn btn-primary">Voltar à loja</a>
    <?php else: ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if (empty($items)): ?>
            <p>Carrinho vazio</p>
        <?php else: ?>

            <?php foreach ($items as $item): ?>
                <div class="d-flex justify-content-between">
                    <span><?= $item["name"] ?> (x<?= $item["qty"] ?>)</span>
                    <span><?= number_format($item["subtotal"], 2) ?> €</span>
                </div>
            <?php endforeach; ?>

            <hr>
            <h3>Total: <?= number_format($total, 2) ?> €</h3>

            <form method="post">
                <button class="btn btn-success w-100">Confirmar Compra</button>
            </form>

        <?php endif; ?>

    <?php endif; ?>
</div>

</body>
</html>