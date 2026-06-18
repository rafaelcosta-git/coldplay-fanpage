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
  <title>Coldplay | Álbuns</title>
  <meta name="description" content="Descubra a discografia completa da banda Coldplay com capas e anos de lançamento.">
  <meta name="keywords" content="Coldplay, álbuns, discografia, música, discografia completa">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>


  <!-- Conteúdo -->
  <main class="container my-5">
    <h1 class="text-center mb-5">Discografia</h1>

    <div class="row g-4 align-items-stretch">
      <!-- Álbum 1 -->
      <div class="col-md-4 col-12">
        <div class="card album-card">
          <img src="../imagens/parachutes.jpeg" class="card-img-top" alt="Capa do álbum Parachutes">
          <div class="card-body text-center">
            <h5 class="card-title">Parachutes</h5>
            <p class="card-text">2000</p>
             <a href="albuns_details.php?id=1" class="btn btn-warning mt-2">
              Ver Detalhes
            </a>
          </div>
        </div>
      </div>

      <!-- Álbum 2 -->
      <div class="col-md-4 col-12">
        <div class="card album-card">
          <img src="../imagens/arushofbloodtothehead.jpg" class="card-img-top" alt="Capa do álbum A Rush of Blood to the Head">
          <div class="card-body text-center">
            <h5 class="card-title">A Rush of Blood to the Head</h5>
            <p class="card-text">2002</p>
            <a href="albuns_details.php?id=2" class="btn btn-warning mt-2">
            Ver Detalhes
            </a>
          </div>
      </div>
      </div>
    


    <!-- Álbum 3 -->
      <div class="col-md-4 col-12">
        <div class="card album-card">
          <img src="../imagens/XYX.jpg" class="card-img-top" alt="Capa do álbum X&Y">
          <div class="card-body text-center">
            <h5 class="card-title">X&Y</h5>
            <p class="card-text">2005</p>
            <a href="albuns_details.php?id=3" class="btn btn-warning mt-2">
            Ver Detalhes
            </a>
          </div>
        </div>
      </div>
    </div>
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
