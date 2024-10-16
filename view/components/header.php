<?
// Santi Onieva

require_once $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/model/Usuari/Usuari.php';

session_start();
// $_SESSION['user_id'] = 1;
$userLogged = isset($_SESSION['usuari']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="<?php echo BASE_PATH . '/' ?>">
  <title>Oni's Blog 2.0 | <?php echo Config::getTitol() ?></title>
  <link rel="icon" href="assets/images/logo.png" type="image/x-icon">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="assets/css/styles.css">

  <script defer src="assets/js/navbar-dropdown.js"></script>
  <script defer src="assets/js/btn-imatge.js"></script>
  <script defer src="assets/js/article-preview.js"></script>
  <script defer src="assets/js/show-add-article.js"></script>

</head>
<body>
  <nav class="navbar">

    <div class="logo">
      <a class="logo" href="<?php echo BASE_PATH ?>">
        <img src="assets/images/logo.png" alt="Logo" width="40" height="40" class="logo-img">
        <h4 class="logo-name">Oni's Blog 2.0</h4>
      </a>

      <h2 class="vertical-bar">|</h2>

      <h4 class="nom-pantalla"><?php echo Config::getTitol() ?></h4>
    </div>

    <div class="nav-items">
      <a class="nav-item" href="<?php echo BASE_PATH ?>">
        <i class="fa-solid fa-house"></i> Inici
      </a>

      <div class="nav-item">
        <button id="dropdown-toggle">
            <i class="fa-solid fa-user"></i> <? echo $userLogged ? $_SESSION['usuari']->getNomComplet() ??  $_SESSION['usuari']->getAlies() : 'Identifica\'t'?> <i id="caret" class="fa-solid fa-caret-left"></i>
        </button>

        <div id="dropdown" class="dropdown-content">
          <? if ($userLogged): ?>
            <a class="dropdown-item" href="view/dashboard.view.php">
              <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a class="dropdown-item" href="auth/logout.php">
              <i class="fa-solid fa-right-from-bracket"></i> Sortir
            </a>
          <? else: ?>
            <a class="dropdown-item" href="view/login.view.php">
              <i class="fa-solid fa-right-to-bracket"></i> Iniciar sessio
            </a>
            <a class="dropdown-item" href="view/register.view.php">
              <i class="fa-solid fa-user-plus"></i> Crear compte
            </a>
          <? endif; ?>
        </div>
      </div>

    </div>
  </nav>