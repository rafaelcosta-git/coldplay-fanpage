<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/index.php">Coldplay</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/index.php">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/sobre.php">Sobre</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/albuns.php">Álbuns</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/events.php">Tour</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/contactos.php">Contactos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/loja.php">Loja</a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item dropdown ms-lg-3">
            <a class="nav-link dropdown-toggle text-warning" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
              Olá, <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Fã') ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
              <li><a class="dropdown-item" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/profile.php">Meu Perfil</a></li>

            <li>
             <a class="dropdown-item" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/my_orders.php">
              Histórico de Compras
            </a>
           </li>
              
              <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <li><a class="dropdown-item text-warning fw-bold" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/admin.php">Painel Admin</a></li>
              <?php endif; ?>
              
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/logout.php">Sair</a></li>
            </ul>
          </li>
          
          <li class="nav-item ms-lg-2">
            <a class="nav-link text-white" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/cart.php">
              <i class="fa-solid fa-cart-shopping"></i>
              <span class="badge bg-warning text-dark">
                <?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>
              </span>
            </a>
          </li>

        <?php else: ?>
          <li class="nav-item ms-lg-3">
            <a class="btn btn-outline-light btn-sm px-3" href="/fullstackdev/Aulas-HTMLCSS/coldplay-fanpage/php/login.php">Entrar</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>