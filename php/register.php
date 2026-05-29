<?php
session_start();
require __DIR__ . "/db.php";

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // Validações básicas
    if ($username === "" || $email === "" || $password === "") {
        $errors[] = "Todos os campos são obrigatórios.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido.";
    }

    if (strlen($password) < 6) {
        $errors[] = "A password deve ter pelo menos 6 caracteres.";
    }

    // Verificar se utilizador ou email já existem
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "SELECT id FROM users WHERE username = :username OR email = :email"
        );
        $stmt->execute([
            "username" => $username,
            "email" => $email
        ]);

        if ($stmt->fetch()) {
            $errors[] = "Nome de utilizador ou email já existentes.";
        }
    }

    // Inserir utilizador
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "INSERT INTO users (username, email, password) 
             VALUES (:username, :email, :password)"
        );

        $stmt->execute([
            "username" => $username,
            "email" => $email,
            "password" => $hashedPassword
        ]);

        $success = "Registo efetuado com sucesso!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Registo | Coldplay Fanpage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h1 class="mb-4 text-center">Criar Conta</h1>

            <?php if ($errors): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success text-center p-4">
                    <h4><?= htmlspecialchars($success) ?> 🎉</h4>
                    <p>Agora já podes aceder à tua área de fã e aproveitar a loja.</p>
                    <hr>
                    <a href="login.php" class="btn btn-success btn-lg w-100 fw-bold">Ir fazer o Login</a>
                </div>
            <?php else: ?>
                <form method="post" novalidate class="card bg-secondary bg-opacity-10 p-4 border-0 rounded-3">
                    <div class="mb-3">
                        <label class="form-label">Nome de utilizador</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        Registar
                    </button>
                    
                    <p class="mt-3 text-center small text-white-50">
                        Já tens conta? <a href="login.php" class="text-info">Faz login aqui</a>
                    </p>
                </form>
            <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>