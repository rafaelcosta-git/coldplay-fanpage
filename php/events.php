<?php
include __DIR__ . '/db.php';
$result = mysqli_query($conn, "SELECT * FROM events ORDER BY date ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eventos</title>
</head>
<body>

<h1>Eventos Disponíveis</h1>

<?php while ($row = mysqli_fetch_assoc($result)): ?>

    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h3><?php echo $row['name']; ?></h3>
        <p><?php echo $row['description']; ?></p>
        <p><strong>Data:</strong> <?php echo $row['date']; ?></p>
        <p><strong>Local:</strong> <?php echo $row['venue']; ?></p>
        <p><strong>Preço:</strong> <?php echo $row['price']; ?>€</p>

        <a href="event_details.php?id=<?php echo $row['id']; ?>">
            Ver detalhes
        </a>
    </div>

<?php endwhile; ?>

</body>
</html>