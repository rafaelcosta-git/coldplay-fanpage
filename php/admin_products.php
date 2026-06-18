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

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO products (name, description, price, stock, image)
         VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssdis",
        $name,
        $desc,
        $price,
        $stock,
        $image
    );

    if (mysqli_stmt_execute($stmt)) {
        $message = "Produto adicionado com sucesso!";
    } else {
        $message = "Erro ao adicionar produto.";
    }
}

// =========================
// APAGAR PRODUTO
// =========================
if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM products WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    header("Location: admin_products.php");
    exit;
}

// =========================
// LISTAR PRODUTOS
// =========================
$products = [];

$result = mysqli_query(
    $conn,
    "SELECT * FROM products ORDER BY id DESC"
);

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
        <div class="alert alert-success">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="mb-4">

        <input
            type="text"
            name="name"
            placeholder="Nome"
            required
        >

        <input
            type="number"
            step="0.01"
            name="price"
            placeholder="Preço"
            required
        >

        <input
            type="number"
            name="stock"
            placeholder="Stock"
            required
        >

        <input
            type="text"
            name="image"
            placeholder="Imagem"
        >

        <textarea
            name="description"
            placeholder="Descrição"
        ></textarea>

        <button
            type="submit"
            name="add_product"
        >
            Adicionar
        </button>

    </form>

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

           <td>
              <img
              src="../<?= str_replace('\\', '/', $p['image']); ?>"
              width="80"
             class="rounded"
             >
          </td>
          

            <td><?= htmlspecialchars($p['name']) ?></td>

            <td><?= $p['price'] ?>€</td>

            <td><?= $p['stock'] ?></td>

            <td>
                <a
                    href="?delete=<?= $p['id'] ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Tem a certeza que pretende apagar este produto?')"
                >
                    Apagar
                </a>
            </td>

        </tr>

        <?php endforeach; ?>

    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>