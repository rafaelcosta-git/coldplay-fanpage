<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Garantir que o carrinho existe
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    // =========================
    // PRODUTOS
    // =========================
    if (isset($_POST["product_id"])) {
        $id = (int) $_POST["product_id"];
        $key = "product_" . $id;

        if ($id > 0) {
            if (isset($_SESSION["cart"][$key])) {
                $_SESSION["cart"][$key]++;
            } else {
                $_SESSION["cart"][$key] = 1;
            }
        }
    }

    // =========================
    // EVENTOS
    // =========================
    if (isset($_POST["event_id"])) {
        $id = (int) $_POST["event_id"];
        $key = "event_" . $id;

        if ($id > 0) {
            if (isset($_SESSION["cart"][$key])) {
                $_SESSION["cart"][$key]++;
            } else {
                $_SESSION["cart"][$key] = 1;
            }
        }
    }
}

// Redirecionar de volta
header("Location: loja.php");
exit;