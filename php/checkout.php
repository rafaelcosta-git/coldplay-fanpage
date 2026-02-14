<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

// 1. Proteção: Só utilizadores logados. Redirecionamento relativo.
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$_SESSION["cart"] ??= [];
$items = [];
$total = 0.0;

// 2. Procurar produtos no carrinho
if (!empty($_SESSION["cart"])) {
    $ids = array_keys($_SESSION["cart"]);
    $placeholders = implode(",", array_fill(0, count($ids), "?"));

    $stmt = $pdo->prepare("SELECT id, name, price, stock FROM products WHERE id IN ($placeholders)");
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

// 3. Processar a compra
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($items)) {
        $error = "O teu carrinho está vazio.";
    } else {
        try {
            $pdo->beginTransaction();

            // Criar a encomenda na tabela 'orders'
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, status) VALUES (:uid, 'pago')");
            $stmt->execute(["uid" => $_SESSION["user_id"]]);
            $orderId = $pdo->lastInsertId();

            // Preparar as queries de itens e stock
            $insertItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (:oid, :pid, :qty)");
            $updateStock = $pdo->prepare("UPDATE products SET stock = stock - :qty WHERE id = :pid AND stock >= :qty");

            foreach ($items as $item) {
                // Atualizar stock
                $updateStock->execute(["qty" => $item["qty"], "pid" => $item["id"]]);
                
                if ($updateStock->rowCount() === 0) {
                    throw new Exception("Infelizmente o produto {$item['name']} ficou sem stock.");
                }

                // Inserir item
                $insertItem->execute([
                    "oid" => $orderId,
                    "pid" => $item["id"],
                    "qty" => $item["qty"]
                ]);
            }

            $pdo->commit();
            $_SESSION["cart"] = []; // Limpa o carrinho após sucesso
            $success = "Compra confirmada com sucesso! Encomenda #$orderId gerada.";

        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Erro ao processar: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Compra | Coldplay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container my-5">
    <h1 class="mb-4">Checkout</h1>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <h4>🎉 <?= htmlspecialchars($success) ?></h4>
            <p>Obrigado por apoiares os Coldplay!</p>
            <a href="loja.php" class="btn btn-primary mt-3">Voltar à Loja</a>
        </div>
    <?php else: ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (empty($items)): ?>
            <p>Não tens itens para finalizar.</p>
            <a href="loja.php" class="btn btn-outline-light">Ir para a Loja</a>
        <?php else: ?>
            <div class="card bg-secondary text-white mb-4">
                <div class="card-body">
                    <h5>Resumo do Pedido</h5>
                    <hr>
                    <?php foreach ($items as $item): ?>
                        <div class="d-flex justify-content-between">
                            <span><?= htmlspecialchars($item["name"]) ?> (x<?= $item["qty"] ?>)</span>
                            <span><?= number_format($item["subtotal"], 2) ?> €</span>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total a Pagar</span>
                        <span><?= number_format($total, 2) ?> €</span>
                    </div>
                </div>
            </div>

            <form method="post">
                <button type="submit" class="btn btn-success btn-lg w-100">Confirmar e Pagar</button>
                <a href="cart.php" class="btn btn-link text-light w-100 mt-2">Corrigir Carrinho</a>
            </form>
        <?php endif; ?>

    <?php endif; ?>
</div>
</body>
</html>