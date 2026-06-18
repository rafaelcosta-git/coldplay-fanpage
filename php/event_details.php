<?php
include __DIR__ . '/db.php';

if (!isset($_GET['id'])) {
    die("Evento não encontrado.");
}

$id = (int) $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM events WHERE id = $id");
$event = mysqli_fetch_assoc($result);

if (!$event) {
    die("Evento não existe.");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $event['name']; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-dark text-white">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top border-bottom">
    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            Coldplay
        </a>

        <div class="ms-auto">
            <a href="events.php" class="btn btn-outline-warning">
                Voltar aos Eventos
            </a>
        </div>

    </div>
</nav>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card event-card text-white shadow">

            <img
                src="../<?php echo htmlspecialchars($event['image']); ?>"
                class="img-fluid rounded-top"
                alt="<?php echo htmlspecialchars($event['name']); ?>"
                style="width:100%; max-height:450px; object-fit:cover;"
                >

                <div class="card-body p-4">

                    <h1 class="mb-3">
                        <?php echo $event['name']; ?>
                    </h1>

                    <p class="lead">
                        <?php echo $event['description']; ?>
                    </p>

                    <hr>

                    <p>
                        <i class="fas fa-calendar-alt text-warning"></i>
                        <strong>Data:</strong>
                        <?php echo $event['date']; ?>
                    </p>

                    <p>
                        <i class="fas fa-clock text-warning"></i>
                        <strong>Hora:</strong>
                        <?php echo $event['time']; ?>
                    </p>

                    <p>
                        <i class="fas fa-map-marker-alt text-warning"></i>
                        <strong>Local:</strong>
                        <?php echo $event['venue']; ?>
                    </p>
                         
                    <p>
                        <i class="fas fa-users text-warning"></i>
                        <strong>Capacidade:</strong>
                        <?php echo number_format($event['capacity']); ?> pessoas
                   </p>

                    
                       
                    <div class="alert alert-warning text-dark fw-bold fs-4">
                        <i class="fas fa-ticket-alt"></i>
                        <?php echo number_format($event['price'], 2); ?>€
                    </div>
                     
                    <div class="alert alert-success fw-bold">
                        <i class="fas fa-check-circle"></i>
                          Bilhetes disponíveis
                    </div>

                    <div class="mt-4">

                        <form action="add_to_cart.php" method="POST">

                            <input
                                type="hidden"
                                name="event_id"
                                value="<?php echo $event['id']; ?>"
                            >

                            <input
                                type="hidden"
                                name="price"
                                value="<?php echo $event['price']; ?>"
                            >

                            <hr>

<h4 class="mb-3">
    <i class="fas fa-info-circle text-warning"></i>
    Informações do Evento
</h4>

<div class="list-group mb-4">

    <div class="list-group-item bg-dark text-white border-secondary">
        🚪 Abertura de portas: 18:00
    </div>

    <div class="list-group-item bg-dark text-white border-secondary">
        🎵 Início do concerto: <?php echo $event['time']; ?>
    </div>

    <div class="list-group-item bg-dark text-white border-secondary">
        🎫 Bilhete digital incluído
    </div>

    <div class="list-group-item bg-dark text-white border-secondary">
        👨‍👩‍👧‍👦 Evento para todas as idades
    </div>

    <div class="list-group-item bg-dark text-white border-secondary">
        📱 Apresentação do bilhete obrigatória na entrada
    </div>

</div>

                            <button
                                type="submit"
                                class="btn btn-warning btn-lg fw-bold w-100"
                            >
                                <i class="fas fa-shopping-cart"></i>
                                Comprar Bilhete
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center p-4 mt-5 border-top">

    <p>&copy; 2026 Coldplay Fanpage. Todos os direitos reservados.</p>

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