<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/session.php";
require_once __DIR__ . "/db.php";

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome_input = $_POST["nome_utilizador"] ?? "";
    $password = $_POST["password"] ?? "";

    // 🔥 MYSQLI (não PDO)
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE name = ?");
    mysqli_stmt_bind_param($stmt, "s", $nome_input);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // VERIFICAR PASSWORD
    if ($user && password_verify($password, $user["password"])) {

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        $_SESSION["user_role"] = $user["role"];

        header("Location: profile.php");
        exit;

    } else {
        $erro = "Nome de utilizador ou password incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login | Coldplay Fanpage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-dark text-white">

<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-4 card bg-secondary bg-opacity-25 p-4 border-0 rounded-4 shadow">

            <h2 class="text-center mb-4">Entrar</h2>

            <?php if ($erro): ?>
                <div class="alert alert-danger text-center"><?= $erro ?></div>
            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome_utilizador" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold text-dark">
                    Entrar
                </button>

            </form>

            <div class="text-center mt-3">
                <a href="register.php" class="text-info">Criar conta</a><br>
                <a href="../index.php" class="text-light">← Voltar</a>
            </div>

        </div>

    </div>
</div>

</body>
</html>