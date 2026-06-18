<?php
require_once "session.php";
require_once "db.php";

include "navbar.php";

$events = mysqli_query(
    $conn,
    "SELECT * FROM events ORDER BY date ASC LIMIT 3"
);
?>


<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coldplay | Contactos</title>
  <meta name="description" content="Entre em contacto connosco através do formulário de contacto da fanpage Coldplay.">
  <meta name="keywords" content="Coldplay, contactos, formulário, email, telefone, mensagem">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

  

  <!-- Conteúdo -->
  <main class="container my-5">
    <h1 class="text-center mb-4">Contacte-nos</h1>
    <p class="text-center lead">Tem alguma questão, sugestão ou mensagem para nós? Preencha o formulário abaixo:</p>

    <form id="contactForm" class="p-4 bg-light rounded shadow">
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" id="nome" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="apelido" class="form-label">Apelido</label>
          <input type="text" id="apelido" class="form-control" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="dataNasc" class="form-label">Data de Nascimento</label>
          <input type="date" id="dataNasc" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="telefone" class="form-label">Telefone</label>
          <input type="tel" id="telefone" class="form-control" pattern="[0-9]{9}" placeholder="9 dígitos" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="mensagem" class="form-label">Mensagem</label>
        <textarea id="mensagem" class="form-control" rows="4" required></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

    <!-- Mensagem de feedback -->
    <div id="formMessage" class="mt-3"></div>
  </main>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center p-4 mt-5">
  <p>&copy; 2026 Coldplay Fanpage. Todos os direitos reservados.</p>

  <div class="footer-social">
    <a href="#" class="text-white me-3" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
    <a href="#" class="text-white me-3" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
    <a href="#" class="text-white me-3" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
    <a href="#" class="text-white me-3" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
    <a href="#" class="text-white me-3" aria-label="Spotify"><i class="fab fa-spotify"></i></a>
    <a href="#" class="text-white me-3" aria-label="Apple Music"><i class="fab fa-apple"></i></a>
    <a href="#" class="text-white" aria-label="X (Twitter)"><i class="fab fa-x-twitter"></i></a>
  </div>
</footer>


  <!-- Scripts -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
