<?php
require_once "session.php";
require_once "db.php";

include "navbar.php";

$albuns = [

1 => [
    "name" => "Parachutes",
    "year" => "2000",
    "image" => "../imagens/parachutes.jpeg",
    "description" => "Parachutes foi o álbum de estreia dos Coldplay. Lançado em 2000, ajudou a lançar a banda para o sucesso internacional graças a músicas como Yellow, Trouble e Shiver.",
    "hit" => "Yellow",
    "tracks_count" => 10,
    "awards" => "Grammy de Melhor Álbum Alternativo",
    "tracks" => [
        "Don't Panic",
        "Shiver",
        "Spies",
        "Sparks",
        "Yellow",
        "Trouble",
        "Parachutes",
        "High Speed",
        "We Never Change",
        "Everything's Not Lost"
    ]
],

2 => [
    "name" => "A Rush of Blood to the Head",
    "year" => "2002",
    "image" => "../imagens/arushofbloodtothehead.jpg",
    "description" => "Considerado um dos melhores álbuns da banda. Inclui clássicos como Clocks, The Scientist e In My Place.",
    "hit" => "The Scientist",
    "tracks_count" => 11,
    "awards" => "Grammy de Melhor Álbum Alternativo",
    "tracks" => [
        "Politik",
        "In My Place",
        "God Put a Smile Upon Your Face",
        "The Scientist",
        "Clocks",
        "Daylight",
        "Green Eyes",
        "Warning Sign",
        "A Whisper",
        "A Rush of Blood to the Head",
        "Amsterdam"
    ]
],

3 => [
    "name" => "X&Y",
    "year" => "2005",
    "image" => "../imagens/XYX.jpg",
    "description" => "Um dos álbuns mais vendidos dos Coldplay. Inclui sucessos como Fix You, Speed of Sound e Talk.",
    "hit" => "Fix You",
    "tracks_count" => 13,
    "awards" => "Brit Award Melhor Álbum Britânico",
    "tracks" => [
        "Square One",
        "What If",
        "White Shadows",
        "Fix You",
        "Talk",
        "X&Y",
        "Speed of Sound",
        "A Message",
        "Low",
        "The Hardest Part",
        "Swallowed in the Sea",
        "Twisted Logic",
        "Til Kingdom Come"
    ]
]

];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

if (!isset($albuns[$id])) {
    die("Álbum não encontrado.");
}

$album = $albuns[$id];
?>

<!DOCTYPE html>
<html lang="pt">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= $album['name']; ?> | Coldplay Fanpage</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css">

</head>

<body class="bg-dark text-white">

<div class="container my-5">

    <div class="row g-5">

        <div class="col-md-4">

            <img
                src="<?= $album['image']; ?>"
                alt="<?= $album['name']; ?>"
                class="img-fluid rounded shadow"
            >

        </div>

        <div class="col-md-8">

            <h1 class="display-4 fw-bold">
                <?= $album['name']; ?>
            </h1>

            <p class="text-warning fs-5">
                Lançamento: <?= $album['year']; ?>
            </p>

            <p class="lead">
                <?= $album['description']; ?>
            </p>

            <hr>

            <div class="row">

                <div class="col-md-4">
                    <div class="card bg-secondary text-white mb-3">
                        <div class="card-body text-center">
                            <h5>Música Mais Famosa</h5>
                            <p><?= $album['hit']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-secondary text-white mb-3">
                        <div class="card-body text-center">
                            <h5>Faixas</h5>
                            <p><?= $album['tracks_count']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-secondary text-white mb-3">
                        <div class="card-body text-center">
                            <h5>Prémio</h5>
                            <p><?= $album['awards']; ?></p>
                        </div>
                    </div>
                </div>

            </div>

            <h3 class="mt-4 mb-3">
                Lista de Faixas
            </h3>

            <ul class="list-group">

                <?php foreach ($album['tracks'] as $track): ?>

                    <li class="list-group-item">
                        <?= $track; ?>
                    </li>

                <?php endforeach; ?>

            </ul>

            <div class="mt-4">

                <a href="albuns.php" class="btn btn-warning">
                    <i class="fas fa-arrow-left"></i>
                    Voltar à Discografia
                </a>

            </div>

        </div>

    </div>

</div>

<footer class="bg-dark text-white text-center p-4 mt-5 border-top">

    <p>&copy; 2026 Coldplay Fanpage. Todos os direitos reservados.</p>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>