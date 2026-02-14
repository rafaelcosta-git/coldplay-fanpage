<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

// Apenas aceita requisições via POST para segurança
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productId = (int)($_POST["product_id"] ?? 0);
    
    // Verifica se o produto existe e se tem stock disponível
    $stmt = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $p = $stmt->fetch();

    if ($p && $p['stock'] > 0) {
        // Se já existir no carrinho, aumenta 1. Se não, começa em 1.
        $_SESSION["cart"][$productId] = ($_SESSION["cart"][$productId] ?? 0) + 1;
    }
}

// Redirecionamento simples e relativo
header("Location: loja.php");
exit;