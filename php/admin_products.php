<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db.php";

checkAdmin();

$message = "";

// =========================
// ADICIONAR PRODUTO
// =========================
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_POST['image'];

    $stmt = mysqli_prepare($conn, "INSERT INTO products (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssdiss", $name, $desc, $price, $stock, $image);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Produto adicionado com sucesso!";
    }
}

// =========================
// DELETE PRODUTO
// =========================
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    mysqli_query($conn, "DELETE FROM products WHERE id = $id");

    header("Location: admin_products.php");
    exit;
}

// =========================
// LISTAR PRODUTOS
// =========================
$products = [];

$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");

while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Produtos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-dark text-white">

<?php include __DIR__ . "/navbar.php"; ?>

<div class="container mt-5">

    <h1>Gestão de Produtos</h1>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <!-- FORM -->
    <form method="POST" class="mb-4">
        <input type="text" name="name" placeholder="Nome" required>
        <input type="number" step="0.01" name="price" placeholder="Preço" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <input type="text" name="image" placeholder="Imagem">
        <textarea name="description" placeholder="Descrição"></textarea>

        <button type="submit" name="add_product">Adicionar</button>
    </form>

    <!-- LISTA -->
    <table class="table table-dark">
        <tr>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Stock</th>
            <th>Ações</th>
        </tr>

        <?php foreach ($products as $p): ?>
        <tr>
            <td><img src="<?= htmlspecialchars($p['image']) ?>" width="50"></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= $p['price'] ?>€</td>
            <td><?= $p['stock'] ?></td>
            <td>
                <a href="?delete=<?= $p['id'] ?>" class="btn btn-danger btn-sm">Apagar</a>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>

</body>
</html>