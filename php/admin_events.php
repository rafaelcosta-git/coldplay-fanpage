<?php
include __DIR__ . '/db.php';

// =========================
// ADICIONAR EVENTO
// =========================
if (isset($_POST['add_event'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];
    $price = $_POST['price'];

    $query = "INSERT INTO events (name, description, date, time, venue, price)
              VALUES ('$name', '$description', '$date', '$time', '$venue', '$price')";
    
    mysqli_query($conn, $query);
}

// =========================
// APAGAR EVENTO
// =========================
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM events WHERE id = $id");

    // REDIRECIONAR (IMPORTANTE)
    header("Location: admin_events.php");
    exit();
}

// =========================
// EDIT MODE
// =========================
$edit_mode = false;

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = $_GET['edit'];

    $result = mysqli_query($conn, "SELECT * FROM events WHERE id = $id");
    $event = mysqli_fetch_assoc($result);
}

// =========================
// ATUALIZAR EVENTO
// =========================
if (isset($_POST['update_event'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];
    $price = $_POST['price'];

    $query = "UPDATE events SET 
        name='$name',
        description='$description',
        date='$date',
        time='$time',
        venue='$venue',
        price='$price'
        WHERE id=$id";

    mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Eventos</title>
</head>
<body>

<h2>Gerir Eventos</h2>

<!-- ========================= -->
<!-- FORMULÁRIO -->
<!-- ========================= -->
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $edit_mode ? $event['id'] : ''; ?>">

    <input type="text" name="name" placeholder="Nome"
        value="<?php echo $edit_mode ? $event['name'] : ''; ?>" required>

    <input type="text" name="description" placeholder="Descrição"
        value="<?php echo $edit_mode ? $event['description'] : ''; ?>" required>

    <input type="date" name="date"
        value="<?php echo $edit_mode ? $event['date'] : ''; ?>" required>

    <input type="time" name="time"
        value="<?php echo $edit_mode ? $event['time'] : ''; ?>" required>

    <input type="text" name="venue" placeholder="Local"
        value="<?php echo $edit_mode ? $event['venue'] : ''; ?>" required>

    <input type="number" step="0.01" name="price" placeholder="Preço"
        value="<?php echo $edit_mode ? $event['price'] : ''; ?>" required>

    <?php if ($edit_mode): ?>
        <button type="submit" name="update_event">Atualizar Evento</button>
    <?php else: ?>
        <button type="submit" name="add_event">Adicionar Evento</button>
    <?php endif; ?>
</form>

<hr>

<h3>Lista de Eventos</h3>

<?php
$result = mysqli_query($conn, "SELECT * FROM events");

while ($row = mysqli_fetch_assoc($result)) {
    echo "
        <div style='margin-bottom:10px;'>
            <strong>{$row['name']}</strong> 
            - {$row['date']} 
            - {$row['price']}€
            <br>
            <a href='?edit={$row['id']}'>Editar</a> | 
           <a href='?delete={$row['id']}'>Apagar</a> 
        </div>
    ";
}
?>

</body>
</html>