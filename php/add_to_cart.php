<?php

require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

$_SESSION["cart"] ??= [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // PRODUTOS
    if (isset($_POST["product_id"])) {

        $id = (int) $_POST["product_id"];
        $key = "product_" . $id;

        $_SESSION["cart"][$key] =
            ($_SESSION["cart"][$key] ?? 0) + 1;
    }

    // EVENTOS
    if (isset($_POST["event_id"])) {

        $id = (int) $_POST["event_id"];
        $key = "event_" . $id;

        $_SESSION["cart"][$key] =
            ($_SESSION["cart"][$key] ?? 0) + 1;
    }
}

header("Location: cart.php");
exit;