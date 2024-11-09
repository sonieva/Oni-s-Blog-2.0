<?php
// Santi Onieva

// Es requereix el fitxer de la classe Usuari.
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/Usuari/Usuari.php';

// Si la sessió no està iniciada, s'inicia.
if (session_status() == PHP_SESSION_NONE) session_start();

// S'inclou el fitxer de funcions utils.php.
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/utils.php';

// Es requereix el fitxer per controlar la durada de la sessió.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/session-lifetime.php';

// Es defineix si l'usuari està identificat a partir de la sessió.
$userLogged = isset($_SESSION['usuari']);
$isAdmin = $userLogged && $_SESSION['usuari']->esAdmin();
?>

<!DOCTYPE html>
<html lang="ca">

<head>
  <!-- Metadades bàsiques i configuració de la vista. -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="/">

  <!-- Títol de la pàgina dinàmic, depenent del valor que es passa a Config. -->
  <title>Oni's Blog 2.0 | <?= Config::getTitol() ?></title>

  <!-- Icona de la pàgina. -->
  <link rel="icon" href="assets/images/logo.png" type="image/x-icon">

  <!-- Enllaços als estils i fonts utilitzats. -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" type="text/css" />

  <?php foreach (Config::getArchiusCSS() as $arxiu): ?>
    <link rel="stylesheet" href="assets/css/<?= $arxiu ?>.css" type="text/css">
  <?php endforeach; ?>

  <link rel="stylesheet" href="assets/css/toaster.css" type="text/css">
  <link rel="stylesheet" href="assets/css/header.css" type="text/css">
  <link rel="stylesheet" href="assets/css/styles.css" type="text/css">

  <?php foreach (Config::getArchiusJS() as $arxiu): ?>
    <script defer src="assets/js/<?= $arxiu ?>.js" type="application/javascript"></script>
  <?php endforeach; ?>

  <script defer src="assets/js/toaster.js"></script>
  <script defer src="assets/js/navbar-dropdown.js"></script>

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
          <?php if ($userLogged): ?>
            <img src="<?= $_SESSION['usuari']->getRutaImatge() ?: 'assets/images/placeholder-usuari.png' ?>" alt="Imatge de perfil" class="foto-perfil-header" id="foto-perfil-header">
          <?php else: ?>
            <i class="fa-regular fa-user"></i>
          <?php endif; ?>
          <span id="header-nom"><?= $userLogged ? ($_SESSION['usuari']->getNomComplet() ?: $_SESSION['usuari']->getAlies()) : 'Identifica\'t' ?></span>
          <i id="caret" class="fa-solid fa-caret-left"></i>
        </button>

        <!-- Contingut del menú desplegable amb opcions segons si l'usuari està identificat o no. -->
        <div id="dropdown" class="dropdown-content">
          <?php if ($userLogged): ?>
            <!-- Si l'usuari està identificat, es mostren enllaços al perfil, al dashboard i per sortir de la sessió. -->
            <a href="view/perfil.view.php">
              <i class="fa-solid fa-user-gear"></i>Perfil
            </a>
            <a href="view/dashboard.view.php">
              <i class="fa-solid fa-gauge-high"></i>Dashboard
            </a>
            <?php if ($isAdmin): ?>
              <a href="view/admin.view.php" class="admin-link">
                <i class="fa-solid fa-users-gear"></i>Gestió d'usuaris
              </a>
            <?php endif; ?>
            <a href="auth/logout.php">
              <i class="fa-solid fa-right-from-bracket"></i>Sortir
            </a>
          <?php else: ?>
            <!-- Si l'usuari no està identificat, es mostren opcions per iniciar sessió o crear un compte. -->
            <a href="view/auth/login.view.php">
              <i class="fa-solid fa-right-to-bracket"></i>Iniciar sessio
            </a>
            <a href="view/auth/signup.view.php">
              <i class="fa-solid fa-user-plus"></i>Crear compte
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>