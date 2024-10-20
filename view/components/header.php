<?
// Santi Onieva

require_once $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/model/Usuari/Usuari.php';

if (session_status() == PHP_SESSION_NONE) session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/auth/session-lifetime.php';

$userLogged = isset($_SESSION['usuari']);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="<?= BASE_PATH . '/' ?>">
  <title>Oni's Blog 2.0 | <?= Config::getTitol() ?></title>
  <link rel="icon" href="assets/images/logo.png" type="image/x-icon">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <link rel="stylesheet" href="assets/css/toaster.css">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="assets/css/article.css">
  <link rel="stylesheet" href="assets/css/forms.css">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="assets/css/llista-articles.css">
  <link rel="stylesheet" href="assets/css/dashboard.css">
  <link rel="stylesheet" href="assets/css/modal.css">
  <link rel="stylesheet" href="assets/css/styles.css">

  <script defer src="assets/js/toaster.js"></script>
  <script defer src="assets/js/navbar-dropdown.js"></script>
  <script defer src="assets/js/btn-imatge.js"></script>
  <script defer src="assets/js/article-preview.js"></script>
  <script defer src="assets/js/show-add-article.js"></script>
  <script defer src="assets/js/modal.js"></script>
  <script defer src="assets/js/delete-article.js"></script>
  <script defer src="assets/js/toggle-password.js"></script>
</head>
<body>
  <nav class="navbar">

    <div class="logo">
      <a class="logo" href="<?= BASE_PATH ?>">
        <img src="assets/images/logo.png" alt="Logo" width="40" height="40" class="logo-img">
        <h4 class="logo-name">Oni's Blog 2.0</h4>
      </a>

      <h2 class="vertical-bar">|</h2>

      <h4 class="nom-pantalla"><?= Config::getTitol() ?></h4>
    </div>

    <div class="nav-items">
      <a class="nav-item" href="<?= BASE_PATH ?>">
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
            <a class="dropdown-item" href="view/auth/login.view.php">
              <i class="fa-solid fa-right-to-bracket"></i> Iniciar sessio
            </a>
            <a class="dropdown-item" href="view/auth/register.view.php">
              <i class="fa-solid fa-user-plus"></i> Crear compte
            </a>
          <? endif; ?>
        </div>
      </div>

    </div>
  </nav>