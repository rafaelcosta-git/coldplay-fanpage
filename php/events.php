<?php
require_once "session.php";
require_once "db.php";

include "navbar.php";

$events = mysqli_query(
    $conn,
    "SELECT * FROM events ORDER BY date ASC LIMIT 3"
);


$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

$sql = "
SELECT *
FROM events
WHERE name LIKE '%$search%'
   OR venue LIKE '%$search%'
   OR description LIKE '%$search%'
ORDER BY date ASC
";

$result = mysqli_query($conn, $sql);

$totalEvents = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos | Coldplay Fanpage</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-dark text-white">

<!-- HEADER -->
<section class="py-5 text-center">
    <div class="container">

        <h1 class="display-4 fw-bold mb-3">
            Tour Coldplay
        </h1>

        <p class="text-warning fw-bold fs-5">
          <?php echo $totalEvents; ?> Concertos Disponíveis
        </p>
          

        <form method="GET" class="mb-5">
        <div class="input-group">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Pesquisar cidade ou evento..."
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
        >

        <button class="btn btn-warning" type="submit">
            <i class="fas fa-search"></i>
            Pesquisar
        </button> 


        <p class="text-center text-light mb-4">
            Foram encontrados
        <strong><?php echo mysqli_num_rows($result); ?></strong>
            evento(s)
        </p>

    </div>
</form>

    </div>
</section>

<!-- EVENTOS -->
<div class="container mb-5">

    <div class="row g-4">

        <?php while ($row = mysqli_fetch_assoc($result)): ?>

            <div class="col-md-6 col-lg-4">

               <div class="card event-card text-white h-100 shadow">       

                 <img src="../<?php echo htmlspecialchars($row['image']); ?>"
                      class="card-img-top"
                      alt="<?php echo htmlspecialchars($row['name']); ?>"
                      style="height:220px; object-fit:cover;"
                      >

                    <div class="card-body">

                        <h4 class="card-title mb-3">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </h4>

                        <p class="card-text">
                            <?php echo htmlspecialchars($row['description']); ?>
                        </p>

                        <hr>

                        <p>
                            <i class="fas fa-calendar-alt text-warning"></i>
                            <strong>Data:</strong>
                            <?php echo $row['date']; ?>
                        </p>

                        <p>
                            <i class="fas fa-clock text-warning"></i>
                            <strong>Hora:</strong>
                            <?php echo $row['time']; ?>
                        </p>

                        <p>
                            <i class="fas fa-map-marker-alt text-warning"></i>
                            <strong>Local:</strong>
                            <?php echo htmlspecialchars($row['venue']); ?>
                        </p>


                        <p>
                        <i class="fas fa-users text-warning"></i>
                        <strong>Capacidade:</strong>
                        <?php echo number_format($row['capacity']); ?> pessoas
                        </p>

                        <p>
                            <i class="fas fa-ticket-alt text-warning"></i>
                            <strong>Preço:</strong>
                            <?php echo number_format($row['price'], 2); ?>€
                        </p>

                    </div>

                    <div class="card-footer bg-transparent border-0">

                        <a
                            href="event_details.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-warning w-100 fw-bold"
                        >
                            Ver Detalhes
                        </a>

                    </div>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</div>

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