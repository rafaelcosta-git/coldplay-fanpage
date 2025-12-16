<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

// Só utilizadores autenticados
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$_SESSION["cart"] ??= [];

$items = [];
$total = 0.0;

// Se o carrinho tiver produtos, buscar info à BD
if (!empty($_SESSION["cart"])) {
    $ids = array_keys($_SESSION["cart"]);
    $placeholders = implode(",", array_fill(0, count($ids), "?"));

    $stmt = $pdo->prepare(
        "SELECT id, name, price, stock 
         FROM products 
         WHERE id IN ($placeholders)"
    );
    $stmt->execute($ids);
    $produtos = $stmt->fetchAll();

    foreach ($produtos as $p) {
        $qty = min($_SESSION["cart"][$p["id"]], $p["stock"]);
        if ($qty <= 0) continue;

        $subtotal = $qty * $p["price"];
        $total += $subtotal;

        $items[] = [
            "id" => $p["id"],
            "name" => $p["name"],
            "price" => $p["price"],
            "qty" => $qty,
            "subtotal" => $subtotal
        ];
    }
}

$success = "";
$error = "";

// Finalizar compra
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($items)) {
        $error = "O carrinho está vazio.";
    } else {
        try {
            $pdo->beginTransaction();

            // Criar encomenda
            $stmt = $pdo->prepare(
                "INSERT INTO orders (user_id, status) VALUES (:uid, 'pending')"
            );
            $stmt->execute([
                "uid" => $_SESSION["user_id"]
            ]);

            $orderId = $pdo->lastInsertId();

            // Preparar queries
            $insertItem = $pdo->prepare(
                "INSERT INTO order_items (order_id, product_id, quantity)
                 VALUES (:oid, :pid, :qty)"
            );

            $updateStock = $pdo->prepare(
                "UPDATE products
                 SET stock = stock - :qty
                 WHERE id = :pid AND stock >= :qty"
            );

            foreach ($items as $item) {
                // Atualizar stock
                $updateStock->execute([
                    "qty" => $item["qty"],
                    "pid" => $item["id"]
                ]);

                if ($updateStock->rowCount() === 0) {
                    throw new Exception("Stock insuficiente para {$item['name']}");
                }

                // Inserir item da encomenda
                $insertItem->execute([
                    "oid" => $orderId,
                    "pid" => $item["id"],
                    "qty" => $item["qty"]
                ]);
            }

            $pdo->commit();

            // Limpar carrinho
            $_SESSION["cart"] = [];
            $success = "Compra finalizada com sucesso! Encomenda nº $orderId";

        } catch (Throwable $e) {
            $pdo->rollBack();
            $error = "Erro ao finalizar a compra: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Checkout | Coldplay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">

<div class="container my-5">
    <h1 class="mb-4">Checkout</h1>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
        <a href="loja.php" class="btn btn-primary">Voltar à loja</a>

    <?php else: ?>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($items)): ?>
            <p class="text-muted">O carrinho está vazio.</p>
            <a href="loja.php" class="btn btn-primary">Ir para a loja</a>

        <?php else: ?>

            <div class="card bg-dark border-secondary mb-4">
                <div class="card-body">
                    <?php foreach ($items as $item): ?>
                        <div class="d-flex justify-content-between">
                            <span>
                                <?= htmlspecialchars($item["name"]) ?> × <?= $item["qty"] ?>
                            </span>
                            <span>
                                <?= number_format($item["subtotal"], 2) ?> €
                            </span>
                        </div>
                    <?php endforeach; ?>

                    <hr class="border-secondary">

                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong><?= number_format($total, 2) ?> €</strong>
                    </div>
                </div>
            </div>

            <form method="post">
                <button class="btn btn-success">Finalizar compra</button>
                <a href="cart.php" class="btn btn-outline-light">Voltar ao carrinho</a>
            </form>

        <?php endif; ?>

    <?php endif; ?>
</div>

</body>
</html>
