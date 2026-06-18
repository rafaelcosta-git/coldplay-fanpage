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
    //*teste
    $image = $_POST['image'];


    $query = "INSERT INTO events (name, description, date, time, venue, price)
              VALUES ('$name', '$description', '$date', '$time', '$image','$venue', '$price')";
    
    mysqli_query($conn, $query);

$image = "";

if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){

    $filename = time() . "_" . $_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../imagens/" . $filename
    );

    $image = "imagens/" . $filename;
}

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
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css">
    <title>Admin - Eventos</title>
</head>
<body>

<?php include __DIR__ . "/navbar.php"; ?>


<h2>Gerir Eventos</h2>

<!-- ========================= -->
<!-- FORMULÁRIO -->
<!-- ========================= -->
<form method="POST" enctype="multipart/form-data">    

<input type="file" name="image" class="form-control">

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

<h3 class="mt-5 mb-3">Lista de Eventos</h3>

<div class="table-responsive">

<table class="table table-dark table-striped table-hover align-middle">

    <thead>

        <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Evento</th>
            <th>Data</th>
            <th>Hora</th>
            <th>Local</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>

    </thead>

    <tbody>

    <?php

    $result = mysqli_query($conn, "SELECT * FROM events");

    while ($row = mysqli_fetch_assoc($result)):

    ?>

        <tr>

            <td><?= $row['id']; ?></td>

            <td>

           <img
                src="../<?= $row['image']; ?>"
                width="80"
                height="50"
                style="object-fit:cover; border-radius:8px;"
            >

</td>

            <td><?= htmlspecialchars($row['name']); ?></td>

            <td><?= $row['date']; ?></td>

            <td><?= $row['time']; ?></td>

            <td><?= htmlspecialchars($row['venue']); ?></td>

            <td><?= number_format($row['price'],2); ?>€</td>

            <td>

                <a href="?edit=<?= $row['id']; ?>"
                   class="btn btn-warning btn-sm">
                   <i class="fas fa-edit"></i>
                </a>

                <a href="?delete=<?= $row['id']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Apagar este evento?')">
                   <i class="fas fa-trash"></i>
                </a>

            </td>

        </tr>

    <?php endwhile; ?>

    </tbody>

</table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>