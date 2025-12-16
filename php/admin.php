<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

// Proteção: apenas admins
if (
    !isset($_SESSION["user_id"]) ||
    ($_SESSION["role"] ?? "") !== "admin"
) {
    $_SESSION["redirect_after_login"] =
        "/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/admin.php";

    header("Location: /fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/login.php");
    exit;
}

// BUSCAR DADOS
$users = $pdo->query("
    SELECT id, username, email, role
    FROM users
")->fetchAll();

$products = $pdo->query("
    SELECT id, name, price, stock
    FROM products
")->fetchAll();

$orders = $pdo->query("
    SELECT o.id, u.username, o.status
    FROM orders o
    JOIN users u ON o.user_id = u.id
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Admin | Coldplay</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">

<div class="container my-5">

  <h1 class="mb-4">Área de Administração</h1>

  <!-- UTILIZADORES -->
  <h3>Utilizadores</h3>
  <table class="table table-dark table-striped mb-5">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?= $u["id"] ?></td>
          <td><?= htmlspecialchars($u["username"]) ?></td>
          <td><?= htmlspecialchars($u["email"]) ?></td>
          <td><?= $u["role"] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- PRODUTOS -->
  <h3>Produtos</h3>
  <table class="table table-dark table-striped mb-5">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Preço</th>
        <th>Stock</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): ?>
        <tr>
          <td><?= $p["id"] ?></td>
          <td><?= htmlspecialchars($p["name"]) ?></td>
          <td><?= number_format($p["price"], 2) ?> €</td>
          <td><?= $p["stock"] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- ENCOMENDAS -->
  <h3>Encomendas</h3>
  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Utilizador</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $o): ?>
        <tr>
          <td><?= $o["id"] ?></td>
          <td><?= htmlspecialchars($o["username"]) ?></td>
          <td><?= htmlspecialchars($o["status"]) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <a href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/profile.php"
     class="btn btn-outline-light mt-4">
     Voltar ao perfil
  </a>

</div>

</body>
</html>
