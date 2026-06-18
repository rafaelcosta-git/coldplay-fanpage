<?php
require __DIR__ . "/session.php";
require __DIR__ . "/db.php";

// Buscar produtos da base de dados (Apenas produtos com stock)
$result = mysqli_query($conn,"SELECT id, name, category, description, price, image FROM products WHERE stock > 0");

$produtos = [];

while ($row = mysqli_fetch_assoc($result)) {
    $produtos[] = $row;
}

// Contador do carrinho
$cartCount = 0;
if (!empty($_SESSION["cart"])) {
  foreach ($_SESSION["cart"] as $qtd) {
    $cartCount += $qtd;
  }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coldplay | Loja Oficial</title>

  <meta name="description" content="Loja de merchandising Coldplay: t-shirts, hoodies, vinis, posters e mais.">
  <meta name="keywords" content="Coldplay, loja, merchandising">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-light">

<?php 
require "session.php"; // Aqui não precisas do "php/" porque já estás lá dentro
include "navbar.php";  // Chama a barra de navegação
?>

<main class="container my-5">
  <h1 class="text-center mb-4">Loja Oficial Coldplay</h1>
  <p class="text-center text-muted mb-5">Escolhe o teu merchandising favorito.</p>

  <div class="row g-4">

    <section class="col-lg-8">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4">Produtos</h2>
        <small class="text-light"><?= count($produtos) ?> produto(s)</small>
      </div>

      <div class="mb-4 bg-secondary p-3 rounded">
        <label class="form-label text-white fw-bold">Filtrar por categoria:</label>
        <select id="categoria-select" class="form-select w-50">
          <option value="todos">Todas as categorias</option>
          <option value="tshirt">T-shirts</option>
          <option value="hoodie">Hoodies</option>
          <option value="vinil">Vinis</option>
          <option value="poster">Posters</option>
          <option value="acessorio">Acessórios</option>
          <option value="colecionaveis">Colecionáveis</option>
        </select>
      </div>

      <div class="row g-4" id="produtos-container">

        <?php foreach ($produtos as $p): ?>
          <div class="col-md-6 produto-card" data-categoria="<?= htmlspecialchars(strtolower($p["category"])) ?>">
            <div class="card h-100 bg-dark border-secondary shadow-sm">
              
              <?php 
                // Truque para ajustar o caminho da imagem
                $imagePath = $p["image"];
                if (strpos($imagePath, '../') !== 0 && strpos($imagePath, '/') !== 0) {
                    $imagePath = '../' . $imagePath; 
                }
              ?>
              <img src="<?= htmlspecialchars($imagePath) ?>" class="card-img-top" alt="<?= htmlspecialchars($p["name"]) ?>" style="height: 280px; object-fit: cover;">

              <div class="card-body d-flex flex-column text-light">
                <h5 class="card-title text-warning"><?= htmlspecialchars($p["name"]) ?></h5>
                <p class="card-text small text-muted"><?= htmlspecialchars($p["description"]) ?></p>
                <p class="fw-bold fs-5 mb-3"><?= number_format($p["price"], 2) ?> €</p>

                <form method="post" action="add_to_cart.php" class="mt-auto">
                  <input type="hidden" name="product_id" value="<?= (int)$p["id"] ?>">
                  <button type="submit" class="btn btn-warning w-100 fw-bold">
                    <i class="fa-solid fa-cart-plus me-1"></i> Adicionar
                  </button>
                </form>

              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>

    </section>

    <aside class="col-lg-4">
      <div class="card bg-dark border-warning text-light shadow sticky-top" style="top: 80px;">
        <div class="card-body">
          <h2 class="h4 mb-3 text-warning">
            <i class="fa-solid fa-cart-shopping me-2"></i> O Teu Carrinho
          </h2>

          <p class="text-muted small mb-4">A tua seleção segura de merchandising.</p>

          <a href="cart.php" class="btn btn-warning w-100 mb-2 fw-bold text-dark">Ver carrinho completo</a>
          <a href="checkout.php" class="btn btn-outline-light w-100">Finalizar compra</a>
        </div>
      </div>
    </aside>

  </div>
</main>

<footer class="bg-dark border-top border-secondary text-white text-center p-4 mt-5">
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

<script>
// Filtro por categoria (JS mantido e ajustado)
const FILTER_KEY = "coldplay_filtro";
const select = document.getElementById("categoria-select");

function aplicarFiltro(cat) {
  document.querySelectorAll(".produto-card").forEach(card => {
    card.style.display =
      cat === "todos" || card.dataset.categoria === cat ? "block" : "none";
  });
}

const guardado = localStorage.getItem(FILTER_KEY) || "todos";
select.value = guardado;
aplicarFiltro(guardado);

select.addEventListener("change", () => {
  localStorage.setItem(FILTER_KEY, select.value);
  aplicarFiltro(select.value);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>