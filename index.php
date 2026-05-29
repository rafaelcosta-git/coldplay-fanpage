<?php 
require_once "php/session.php"; 
include "php/navbar.php"; 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Coldplay Fanpage | Início</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-dark text-white">

  <main>
    <section class="hero d-flex align-items-center text-center text-white" style="background:url('imagens/hero.jpg') center/cover no-repeat; height:80vh;">
      <div class="container">
        <h1 class="display-3 fw-bold">Coldplay</h1>
        <h2 class="h4 mb-3">Uma das maiores bandas de rock alternativo do mundo</h2>
        <p class="lead">Música que inspira milhões de fãs em todo o mundo.</p>
        <a href="tour.html" class="btn btn-warning btn-lg mt-3 fw-bold">Ver Tour <i class="fas fa-arrow-right"></i></a>
      </div>
    </section>
  </main>

 <footer class="bg-dark text-white text-center p-4 mt-5">
    <p>&copy; 2026 Coldplay Fanpage.</p>

    <div class="footer-social">
      <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
      <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
      <a href="#" class="text-white me-3"><i class="fab fa-youtube"></i></a>
      <a href="#" class="text-white me-3"><i class="fab fa-tiktok"></i></a>
      <a href="#" class="text-white me-3"><i class="fab fa-spotify"></i></a>
      <a href="#" class="text-white me-3"><i class="fab fa-apple"></i></a>
      <a href="#" class="text-white"><i class="fab fa-x-twitter"></i></a>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>