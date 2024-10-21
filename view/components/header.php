<?php
// Santi Onieva

// Es requereix el fitxer de la classe Usuari.
require_once $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/model/Usuari/Usuari.php';

// Si la sessió no està iniciada, s'inicia.
if (session_status() == PHP_SESSION_NONE) session_start();

// Es requereix el fitxer per controlar la durada de la sessió.
require_once $_SERVER['DOCUMENT_ROOT'] . BASE_PATH . '/config/session-lifetime.php';

// Es defineix si l'usuari està identificat a partir de la sessió.
$userLogged = isset($_SESSION['usuari']);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
  <!-- Metadades bàsiques i configuració de la vista. -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Es defineix la ruta base per a tots els enllaços relatius. -->
  <base href="<?= BASE_PATH . '/' ?>">

  <!-- Títol de la pàgina dinàmic, depenent del valor que es passa a Config. -->
  <title>Oni's Blog 2.0 | <?= Config::getTitol() ?></title>
  
  <!-- Icona de la pàgina. -->
  <link rel="icon" href="assets/images/logo.png" type="image/x-icon">

  <!-- Enllaços als estils i fonts utilitzats. -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <!-- Enllaços als arxius CSS propis. -->
  <link rel="stylesheet" href="assets/css/toaster.css">
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="assets/css/article.css">
  <link rel="stylesheet" href="assets/css/forms.css">
  <link rel="stylesheet" href="assets/css/llista-articles.css">
  <link rel="stylesheet" href="assets/css/dashboard.css">
  <link rel="stylesheet" href="assets/css/modal.css">
  <link rel="stylesheet" href="assets/css/perfil.css">
  <link rel="stylesheet" href="assets/css/styles.css">

  <!-- Enllaços als scripts JavaScript propis amb la propietat "defer" per carregar-los després del contingut HTML. -->
  <script defer src="assets/js/toaster.js"></script>
  <script defer src="assets/js/navbar-dropdown.js"></script>
  <script defer src="assets/js/btn-imatge.js"></script>
  <script defer src="assets/js/article-preview.js"></script>
  <script defer src="assets/js/show-add-article.js"></script>
  <script defer src="assets/js/modal.js"></script>
  <script defer src="assets/js/delete-article.js"></script>
  <script defer src="assets/js/toggle-password.js"></script>
  <script defer src="assets/js/edit-nom.js"></script>
</head>
<body>
  <!-- Navbar amb els elements de navegació de la pàgina. -->
  <nav class="navbar">
    <div class="logo">
      <!-- Logo i nom del blog amb un enllaç a la pàgina principal. -->
      <a class="logo" href="<?= BASE_PATH ?>">
        <img src="assets/images/logo.png" alt="Logo" width="40" height="40" class="logo-img">
        <h4 class="logo-name">Oni's Blog 2.0</h4>
      </a>

      <!-- Barra vertical entre el logo i el nom de la pàgina. -->
      <h2 class="vertical-bar">|</h2>

      <!-- Nom de la pantalla actual, definit a partir del títol establert a la classe Config. -->
      <h4 class="nom-pantalla"><?= Config::getTitol() ?></h4>
    </div>

    <!-- Elements de navegació de l'usuari (links a pàgines com el perfil i el dashboard). -->
    <div class="nav-items">
      <!-- Enllaç a la pàgina d'inici. -->
      <a class="nav-item" href="<?= BASE_PATH ?>">
        <i class="fa-solid fa-house"></i>Inici
      </a>

      <!-- Botó del menú desplegable per a accions de l'usuari. -->
      <div class="nav-item">
        <button id="dropdown-toggle">
          <i class="<?= $userLogged ? 'fa-solid' : 'fa-regular' ?> fa-user"></i>
          <?= $userLogged ? $_SESSION['usuari']->getAlies() : 'Identifica\'t'?> 
          <i id="caret" class="fa-solid fa-caret-left"></i>
        </button>

        <!-- Contingut del menú desplegable amb opcions segons si l'usuari està identificat o no. -->
        <div id="dropdown" class="dropdown-content">
          <? if ($userLogged): ?>
            <!-- Si l'usuari està identificat, es mostren enllaços al perfil, al dashboard i per sortir de la sessió. -->
            <a href="view/perfil.view.php">
              <i class="fa-solid fa-user-gear"></i>Perfil
            </a>
            <a href="view/dashboard.view.php">
              <i class="fa-solid fa-gauge-high"></i>Dashboard
            </a>
            <a href="auth/logout.php">
              <i class="fa-solid fa-right-from-bracket"></i>Sortir
            </a>
          <? else: ?>
            <!-- Si l'usuari no està identificat, es mostren opcions per iniciar sessió o crear un compte. -->
            <a href="view/auth/login.view.php">
              <i class="fa-solid fa-right-to-bracket"></i>Iniciar sessio
            </a>
            <a href="view/auth/register.view.php">
              <i class="fa-solid fa-user-plus"></i>Crear compte
            </a>
          <? endif; ?>
        </div>
      </div>
    </div>
  </nav>
