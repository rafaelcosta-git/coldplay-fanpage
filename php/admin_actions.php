<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

// Garante que so o admin faz estas acoes
checkAdmin();

// Eliminar Utilizador (impede que o admin se apague a si proprio por engano)
if (isset($_GET['del_user'])) {
    $id = (int)$_GET['del_user'];
    if ($id !== $_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}

// Eliminar Produto
if (isset($_GET['del_prod'])) {
    $id = (int)$_GET['del_prod'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

// Volta para a pagina admin
header("Location: admin.php");
exit;