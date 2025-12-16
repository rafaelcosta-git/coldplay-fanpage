<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

// Segurança básica: só aceitar POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: loja.php");
    exit;
}

// Ler o ID do produto
$productId = (int)($_POST["product_id"] ?? 0);
if ($productId <= 0) {
    header("Location: loja.php");
    exit;
}

// Confirmar que o produto existe e tem stock
$stmt = $pdo->prepare("SELECT stock FROM products WHERE id = :id");
$stmt->execute(["id" => $productId]);
$produto = $stmt->fetch();

if (!$produto || $produto["stock"] <= 0) {
    header("Location: loja.php");
    exit;
}

// Inicializar carrinho se não existir
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Quantidade atual no carrinho
$qtdAtual = $_SESSION["cart"][$productId] ?? 0;

// Evitar ultrapassar o stock
if ($qtdAtual < $produto["stock"]) {
    $_SESSION["cart"][$productId] = $qtdAtual + 1;
}

// Voltar à loja
header("Location: loja.php");
exit;
