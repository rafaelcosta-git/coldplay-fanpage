<?php
require_once "php/session.php";
require_once "php/db.php";

include "php/navbar.php";

$events = mysqli_query(
    $conn,
    "SELECT * FROM events ORDER BY date ASC LIMIT 3"
);
?>


<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Coldplay | Cálculos</title>

  <!-- SEO -->
  <meta name="description" content="Descubra tudo sobre Coldplay: história, álbuns de sucesso, concertos e formulário de contacto nesta fanpage dedicada.">
  <meta name="keywords" content="Coldplay, banda, música, rock alternativo, concertos, álbuns, Chris Martin, fanpage">
  <meta name="author" content="Nome do aluno">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS personalizado -->
  <link rel="stylesheet" href="css/style.css">

  <style>
    body {
      background-color: #111;
      color: white;
    }
    .card {
      background-color: #1b1b1b;
    }


  body {
    background-color: #111;
    color: white;
  }

  .card {
    background-color: #1b1b1b;
  }

  /* 🔥 Corrigir labels que estão pretos */
  .card .form-label {
    color: #fff !important;
  }

  /* 🔥 Corrigir texto dentro do select */
  #produto-select {
    color: #000; /* o menu fica branco, mas as opções ficam legíveis */
  }


  </style>
</head>

<body>



  <main class="container my-5">

  <h1 class="text-center mb-4">Cálculo de Valor Total</h1>

  <p class="text-center mb-4 text-light">
    Seleciona um produto e insere a quantidade desejada.
  </p>

  <div class="row justify-content-center">
    <div class="col-md-6">

      <div class="card p-4 shadow">

        <!-- ============================== -->
        <!-- FORMULARIO CORRETO DO PDF -->
        <!-- ============================== -->

        <div class="mb-3">
          <label class="form-label">Produto</label>
          <select id="produto-select" class="form-select">
            <option value="">-- Seleciona um produto --</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Quantidade</label>
          <input type="number" id="quantidade" class="form-control" placeholder="Ex: 2">
        </div>

        <button class="btn btn-primary w-100" onclick="calcularTotal()">
          Calcular Total
        </button>

        <div id="resultado" class="alert alert-info text-dark d-none mt-3"></div>

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

  <script src="calculadora.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
