<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        $error = "Preenche todos os campos.";
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = :username");
        $stmt->execute(["username" => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];

            // Redirecionamento Relativo: Funciona em qualquer computador!
            $redirect = $_SESSION["redirect_after_login"] ?? "profile.php";
            unset($_SESSION["redirect_after_login"]);

            header("Location: $redirect");
            exit;
        } else {
            $error = "Credenciais inválidas.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login | Coldplay Fanpage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="mb-4 text-center">Login</h1>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Nome de utilizador</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">Entrar</button>
            </form>
            <p class="mt-3 text-center small">Não tens conta? <a href="register.php">Regista-te aqui</a></p>
        </div>
    </div>
</div>
</body>
</html>