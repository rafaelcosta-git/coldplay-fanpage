<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

// Só admins
checkAdmin();

// ── ELIMINAR UTILIZADOR ──────────────────────────
if (isset($_GET['del_user'])) {
    $id = (int)$_GET['del_user'];
    if ($id !== (int)$_SESSION['user_id']) {
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
    }
    header("Location: admin.php"); exit;
}

// ── EDITAR UTILIZADOR ────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_user') {
    $id       = (int)$_POST['id'];
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $role     = in_array($_POST['role'], ['user','admin']) ? $_POST['role'] : 'user';

    $pdo->prepare("UPDATE users SET username=?, email=?, role=? WHERE id=?")
        ->execute([$username, $email, $role, $id]);
    header("Location: admin.php"); exit;
}

// ── ELIMINAR PRODUTO ─────────────────────────────
if (isset($_GET['del_prod'])) {
    $id = (int)$_GET['del_prod'];
    $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
    header("Location: admin.php"); exit;
}

// ── ADICIONAR PRODUTO ────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_prod') {
    $name     = trim($_POST['name']);
    $category = trim($_POST['category']); // NOVA VARIÁVEL [cite: 63-65]
    $desc     = trim($_POST['description']);
    $price    = (float)$_POST['price'];
    $stock    = (int)$_POST['stock'];
    $image    = trim($_POST['image']);

    // ATUALIZADO PARA INSERIR A CATEGORIA
    $pdo->prepare("INSERT INTO products (name, category, description, price, stock, image) VALUES (?,?,?,?,?,?)")
        ->execute([$name, $category, $desc, $price, $stock, $image]);
    header("Location: admin.php"); exit;
}

// ── EDITAR PRODUTO ───────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_prod') {
    $id       = (int)$_POST['id'];
    $name     = trim($_POST['name']);
    $category = trim($_POST['category']); // NOVA VARIÁVEL [cite: 63-65]
    $desc     = trim($_POST['description']);
    $price    = (float)$_POST['price'];
    $stock    = (int)$_POST['stock'];
    $image    = trim($_POST['image']);

    // ATUALIZADO PARA ATUALIZAR A CATEGORIA
    $pdo->prepare("UPDATE products SET name=?, category=?, description=?, price=?, stock=?, image=? WHERE id=?")
        ->execute([$name, $category, $desc, $price, $stock, $image, $id]);
    header("Location: admin.php"); exit;
}

// ── MARCAR ENCOMENDA COMO PROCESSADA ────────────
if (isset($_GET['complete_order'])) {
    $id = (int)$_GET['complete_order'];
    $pdo->prepare("UPDATE orders SET status='completed' WHERE id=?")
        ->execute([$id]);
    header("Location: admin.php"); exit;
}

// fallback
header("Location: admin.php");
exit;