<?php
include __DIR__ . '/db.php';

// VERIFICAR ID
if (!isset($_GET['id'])) {
    echo "Evento não encontrado";
    exit;
}

$id = $_GET['id'];

// BUSCAR EVENTO
$result = mysqli_query($conn, "SELECT * FROM events WHERE id = $id");
$event = mysqli_fetch_assoc($result);

if (!$event) {
    echo "Evento não existe";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $event['name']; ?></title>
</head>
<body>

<h1><?php echo $event['name']; ?></h1>

<p><?php echo $event['description']; ?></p>

<p><strong>Data:</strong> <?php echo $event['date']; ?></p>
<p><strong>Hora:</strong> <?php echo $event['time']; ?></p>
<p><strong>Local:</strong> <?php echo $event['venue']; ?></p>
<p><strong>Preço:</strong> <?php echo $event['price']; ?>€</p>

<hr>

<!-- BOTÃO COMPRAR -->
<form action="add_to_cart.php" method="POST">
    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
    <input type="hidden" name="price" value="<?php echo $event['price']; ?>">

    <button type="submit">Comprar Bilhete</button>
</form>

</body>
</html>