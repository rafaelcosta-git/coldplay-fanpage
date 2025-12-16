<?php
session_start();
require __DIR__ . "/db.php";

// Buscar produtos da base de dados
$stmt = $pdo->query("SELECT id, name, category, description, price, image FROM products WHERE stock > 0");
$produtos = $stmt->fetchAll();

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
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../index.html">Coldplay</a>

    <div class="ms-auto">
      <a class="nav-link text-white" href="cart.php">
        Loja
        <span class="badge bg-warning text-dark ms-1"><?= $cartCount ?></span>
        <i class="fa-solid fa-cart-shopping ms-1"></i>
      </a>
    </div>
  </div>
</nav>

<main class="container my-5">
  <h1 class="text-center mb-4">Loja Oficial Coldplay</h1>
  <p class="text-center text-white mb-5">Escolhe o teu merchandising favorito.</p>

  <div class="row g-4">

    <!-- PRODUTOS -->
    <section class="col-lg-8">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4">Produtos</h2>
        <small class="text-light"><?= count($produtos) ?> produto(s)</small>
      </div>

      <!-- FILTRO -->
      <div class="mb-3">
        <label class="form-label text-white">Filtrar por categoria:</label>
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
          <div class="col-md-6 produto-card" data-categoria="<?= htmlspecialchars($p["category"]) ?>">
            <div class="card h-100 shadow-sm">
              <img src="../<?= htmlspecialchars($p["image"]) ?>" class="card-img-top" alt="<?= htmlspecialchars($p["name"]) ?>">

              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($p["name"]) ?></h5>
                <p class="card-text small text-muted"><?= htmlspecialchars($p["description"]) ?></p>
                <p class="fw-bold mb-2"><?= number_format($p["price"], 2) ?> €</p>

                <form method="post" action="add_to_cart.php" class="mt-auto">
                  <input type="hidden" name="product_id" value="<?= (int)$p["id"] ?>">
                  <button class="btn btn-primary w-100">
                    <i class="fa-solid fa-cart-plus me-1"></i> Adicionar
                  </button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>

    </section>

    <!-- CARRINHO -->
    <aside class="col-lg-4">
      <div class="card bg-dark text-light shadow">
        <div class="card-body">
          <h2 class="h4 mb-3">
            <i class="fa-solid fa-cart-shopping me-2"></i> Carrinho
          </h2>

          <p class="text-muted">O carrinho agora é gerido em PHP (sessões).</p>

          <a href="cart.php" class="btn btn-success w-100 mb-2">Ver carrinho</a>
          <a href="checkout.php" class="btn btn-outline-light w-100 btn-sm">Finalizar compra</a>
        </div>
      </div>
    </aside>

  </div>
</main>

<footer class="bg-dark text-white text-center p-4 mt-5">
  <p>&copy; 2025 Coldplay Fanpage.</p>
</footer>

<script>
// filtro por categoria (mantido)
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

</body>
</html>
