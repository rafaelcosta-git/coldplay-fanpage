<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

// LOGIN
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$_SESSION["cart"] ??= [];

// =========================
// AÇÕES DO CARRINHO
// =========================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $action = $_POST["action"] ?? "";
    $key = $_POST["key"] ?? "";

    if ($key !== "") {

        if ($action === "inc") {
            $_SESSION["cart"][$key] = ($_SESSION["cart"][$key] ?? 0) + 1;
        }

        if ($action === "dec") {
            $_SESSION["cart"][$key] = max(0, ($_SESSION["cart"][$key] ?? 0) - 1);
            if ($_SESSION["cart"][$key] === 0) {
                unset($_SESSION["cart"][$key]);
            }
        }

        if ($action === "remove") {
            unset($_SESSION["cart"][$key]);
        }
    }

    if ($action === "clear") {
        $_SESSION["cart"] = [];
    }

    header("Location: cart.php");
    exit;
}

// =========================
// BUSCAR ITENS
// =========================
$items = [];
$total = 0.0;

// ---------- PRODUTOS ----------
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
        $result = mysqli_query($conn, "SELECT id, name, price, image FROM products WHERE id IN ($ids)");

        while ($p = mysqli_fetch_assoc($result)) {

            $key = "product_" . $p["id"];
            $qty = $_SESSION["cart"][$key] ?? 0;

            if ($qty <= 0) continue;

            $subtotal = $qty * $p["price"];
            $total += $subtotal;

            $items[] = [
                "key" => $key,
                "name" => $p["name"],
                "price" => $p["price"],
                "image" => $p["image"],
                "qty" => $qty,
                "subtotal" => $subtotal
            ];
        }
    }
}

// ---------- EVENTOS ----------
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
            $qty = $_SESSION["cart"][$key] ?? 0;

            if ($qty <= 0) continue;

            $subtotal = $qty * $e["price"];
            $total += $subtotal;

            $items[] = [
                "key" => $key,
                "name" => $e["name"],
                "price" => $e["price"],
                "image" => null,
                "qty" => $qty,
                "subtotal" => $subtotal
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container my-5">
    <h1>Carrinho</h1>

    <?php if (empty($items)): ?>
        <p>Carrinho vazio</p>
        <a href="loja.php" class="btn btn-primary">Voltar</a>
    <?php else: ?>

        <?php foreach ($items as $item): ?>
            <div class="border p-3 mb-2">

                <strong><?= htmlspecialchars($item["name"]) ?></strong><br>

                <?php if (!empty($item["image"])): ?>
                    <img src="<?= htmlspecialchars($item["image"]) ?>" width="80"><br>
                <?php endif; ?>

                <?= number_format($item["price"], 2) ?> € x <?= $item["qty"] ?> = 
                <strong><?= number_format($item["subtotal"], 2) ?> €</strong>

                <form method="post" class="mt-2">
                    <input type="hidden" name="key" value="<?= $item["key"] ?>">
                    <button name="action" value="dec">-</button>
                    <button name="action" value="inc">+</button>
                    <button name="action" value="remove">Remover</button>
                </form>

            </div>
        <?php endforeach; ?>

        <h3>Total: <?= number_format($total, 2) ?> €</h3>

        <form method="post">
            <button name="action" value="clear">Limpar carrinho</button>
        </form>

        <a href="checkout.php" class="btn btn-success mt-3">Finalizar compra</a>

    <?php endif; ?>
</div>

</body>
</html>