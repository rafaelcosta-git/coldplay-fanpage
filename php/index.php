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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Coldplay Fanpage | Início</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

<main>

    <!-- HERO -->
    <section
        class="hero d-flex align-items-center text-center text-white"
        style="background:url('../imagens/hero.jpg') center/cover no-repeat; height:80vh;"
    >
        <div class="container">

            <h1 class="display-3 fw-bold">
                Coldplay
            </h1>

            <h2 class="h4 mb-3">
                Uma das maiores bandas de rock alternativo do mundo
            </h2>

            <p class="lead">
                Música que inspira milhões de fãs em todo o mundo.
            </p>

            <a
                href="events.php"
                class="btn btn-warning btn-lg mt-3 fw-bold"
            >
                Ver Tour
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>
    </section>

    <!-- EVENTOS -->
    <section class="container py-5">

        <div class="text-center mb-5">

            <h2 class="display-5 fw-bold">
                Próximos Eventos
            </h2>

            <p class="lead">
                Descobre os próximos concertos dos Coldplay.
            </p>

        </div>

        <div class="row g-4">

            <?php while($event = mysqli_fetch_assoc($events)): ?>

                <div class="col-md-6 col-lg-4">

                <div class="card bg-dark text-white border border-secondary h-100 shadow">

                    <img
                     src="../<?= htmlspecialchars($event['image']) ?>"
                     class="card-img-top"
                     style="height:220px; object-fit:cover;"
                     alt="<?= htmlspecialchars($event['name']) ?>"
                     >
                        <div class="card-body">

                            <h4 class="card-title">
                                <?php echo htmlspecialchars($event['name']); ?>
                            </h4>

                            <p>
                                <?php echo htmlspecialchars($event['description']); ?>
                            </p>

                            <hr>

                            <p>
                                <i class="fas fa-calendar-alt text-warning"></i>
                                <strong>Data:</strong>
                                <?php echo $event['date']; ?>
                            </p>

                            <p>
                                <i class="fas fa-map-marker-alt text-warning"></i>
                                <strong>Local:</strong>
                                <?php echo htmlspecialchars($event['venue']); ?>
                            </p>

                            <p>
                                <i class="fas fa-ticket-alt text-warning"></i>
                                <strong>Preço:</strong>
                                <?php echo number_format($event['price'], 2); ?>€
                            </p>

                        </div>

                        <div class="card-footer bg-transparent border-0">

                            <a
                                href="event_details.php?id=<?php echo $event['id']; ?>"
                                class="btn btn-warning w-100 fw-bold"
                            >
                                Ver Detalhes
                            </a>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

        <div class="text-center mt-5 mb-5">

           <a href="events.php"
            class="btn btn-outline-warning btn-lg">
            Ver Tour Completa
           </a>
        </div>
    </section>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>