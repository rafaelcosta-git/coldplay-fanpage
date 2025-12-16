<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

// Só utilizadores autenticados
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$_SESSION["cart"] ??= [];

// Ações do carrinho
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    $id = (int)($_POST["product_id"] ?? 0);

    if ($id > 0) {
        if ($action === "inc") {
            $_SESSION["cart"][$id] = ($_SESSION["cart"][$id] ?? 0) + 1;
        }

        if ($action === "dec") {
            $_SESSION["cart"][$id] = max(0, ($_SESSION["cart"][$id] ?? 0) - 1);
            if ($_SESSION["cart"][$id] === 0) {
                unset($_SESSION["cart"][$id]);
            }
        }

        if ($action === "remove") {
            unset($_SESSION["cart"][$id]);
        }
    }

    if ($action === "clear") {
        $_SESSION["cart"] = [];
    }

    header("Location: cart.php");
    exit;
}

// Buscar produtos do carrinho
$items = [];
$total = 0.0;

if (!empty($_SESSION["cart"])) {
    $ids = array_keys($_SESSION["cart"]);
    $placeholders = implode(",", array_fill(0, count($ids), "?"));

    $stmt = $pdo->prepare(
        "SELECT id, name, price, image 
         FROM products 
         WHERE id IN ($placeholders)"
    );
    $stmt->execute($ids);
    $produtos = $stmt->fetchAll();

    foreach ($produtos as $p) {
        $qty = $_SESSION["cart"][$p["id"]];
        $subtotal = $qty * $p["price"];
        $total += $subtotal;

        $items[] = [
            "id" => $p["id"],
            "name" => $p["name"],
            "price" => $p["price"],
            "image" => $p["image"],
            "qty" => $qty,
            "subtotal" => $subtotal
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Carrinho | Coldplay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">

<div class="container my-5">
    <h1 class="mb-4">Carrinho de Compras</h1>

    <?php if (!$items): ?>
        <p class="text-muted">O carrinho está vazio.</p>
        <a href="loja.php" class="btn btn-primary">Voltar à loja</a>
    <?php else: ?>

        <?php foreach ($items as $item): ?>
            <div class="card bg-dark border-secondary mb-3">
                <div class="card-body d-flex align-items-center">
                    <img src="../<?= htmlspecialchars($item["image"]) ?>"
                         style="width:80px;height:80px;object-fit:cover"
                         class="me-3 rounded">

                    <div class="flex-grow-1">
                        <h5 class="mb-1"><?= htmlspecialchars($item["name"]) ?></h5>
                        <small><?= number_format($item["price"], 2) ?> €</small>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <form method="post">
                            <input type="hidden" name="product_id" value="<?= $item["id"] ?>">
                            <button class="btn btn-outline-light btn-sm" name="action" value="dec">−</button>
                            <span class="mx-2"><?= $item["qty"] ?></span>
                            <button class="btn btn-outline-light btn-sm" name="action" value="inc">+</button>
                        </form>

                        <strong class="ms-3">
                            <?= number_format($item["subtotal"], 2) ?> €
                        </strong>

                        <form method="post" class="ms-2">
                            <input type="hidden" name="product_id" value="<?= $item["id"] ?>">
                            <button class="btn btn-danger btn-sm" name="action" value="remove">
                                Remover
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h4>Total:</h4>
            <h4><?= number_format($total, 2) ?> €</h4>
        </div>

        <div class="d-flex gap-2 mt-3">
            <a href="loja.php" class="btn btn-outline-light">Continuar a comprar</a>

            <form method="post">
                <button class="btn btn-outline-warning" name="action" value="clear">
                    Limpar carrinho
                </button>
            </form>

            <a href="checkout.php" class="btn btn-success ms-auto">
                Finalizar compra
            </a>
        </div>

    <?php endif; ?>
</div>

</body>
</html>
