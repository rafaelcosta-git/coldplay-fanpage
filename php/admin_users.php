<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db.php";

checkAdmin();

$message = "";

// DELETE
if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    if ($id == $_SESSION['user_id']) {

        $message = "Erro: Não podes apagar a tua própria conta!";

    } else {

        if (mysqli_query($conn, "DELETE FROM users WHERE id = $id")) {

            header("Location: admin_users.php");
            exit;

        } else {

            $message = "Não é possível apagar este utilizador porque possui encomendas/compras associadas.";

        }

    }
}

// PROMOTE
if (isset($_GET['promote'])) {
    $id = (int) $_GET['promote'];

    mysqli_query($conn, "UPDATE users SET role = 'admin' WHERE id = $id");

    header("Location: admin_users.php");
    exit;
}

// LISTAR USERS
$users = [];

$query = "SELECT id, name, email, role FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Erro SQL: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Utilizadores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-dark text-white">

<?php include __DIR__ . "/navbar.php"; ?>

<div class="container mt-5">

    <h1>Gestão de Utilizadores</h1>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>

    <table class="table table-dark mt-4">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Role</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $u): ?>
            <tr>

                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= $u['role'] ?></td>

                <td>
                    <?php if ($u['id'] != $_SESSION['user_id']): ?>

                        <?php if ($u['role'] !== 'admin'): ?>
                            <a href="?promote=<?= $u['id'] ?>" class="btn btn-success btn-sm">Admin</a>
                        <?php endif; ?>

                        <a href="?delete=<?= $u['id'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Tens a certeza?')">
                           Apagar
                        </a>

                    <?php else: ?>
                        <small>Tu</small>
                    <?php endif; ?>
                </td>

            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>