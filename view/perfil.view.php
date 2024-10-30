<?php
// Santi Onieva

// Inclou la configuració i estableix el títol de la pàgina
require_once '../config/Config.php';
Config::setTitol('Perfil');

// Inclou el model de l'usuari
require_once '../model/Usuari/Usuari.php';

// Inicia la sessió
session_start();

// Comprova si l'usuari està autenticat; en cas contrari, redirigeix a la pàgina principal
if (!isset($_SESSION['usuari'])) {
  header('Location: ..');
}

// Inclou el capçal de la pàgina
include 'components/header.php';

$missatge = getMessage('missatgePerfil');
$error = getMessage('errorPerfil');

include_once 'components/toasters.php'
?>

<div class="perfil">
  <div class="info-header">
    <!-- Mostra el nom d'usuari com a títol -->
    <h1><?= $_SESSION['usuari']->getAlies() ?></h1>

    <div class="container-foto-perfil">
      <img src="<?= ($_SESSION['usuari']->getRutaImatge()) ?? 'assets/images/placeholder-usuari.png' ?>" alt="Foto de perfil" class="foto-perfil" id="foto-perfil">
      <input type="file" id="input-foto-perfil" class="input-foto-perfil" accept="image/*">
      <button class="edit-icon" id="edit-icon">
        <i class="fas fa-pencil-alt"></i>
      </button>
    </div>
  </div>
  
  <hr>

  <div class="info-body">
    <!-- Mostra el nom complet de l'usuari amb la possibilitat d'editar-lo -->
    <p>
      <strong>Nom complet: </strong>
      <span id="nom-text"><?= $_SESSION['usuari']->getNomComplet() ?? 'No configurat' ?></span>
      <input type="text" class="nom-input" id="nom-input">
      <button class="btn-edit-perfil" id="btn-edit-perfil">
        <i class="fas fa-pencil"></i>
      </button>
    </p>

    <!-- Mostra altres dades de l'usuari, com l'alies i el correu electrònic -->
    <p><strong>Alies: </strong><?= $_SESSION['usuari']->getAlies() ?></p>
    <p><strong>Correu: </strong><?= $_SESSION['usuari']->getEmail() ?></p>
    <p>
      <strong>Contrasenya: </strong><?= str_repeat('•', 10) ?>
      <a href="view/auth/change-password.view.php" class="btn-edit-perfil">
        <i class="fas fa-pencil"></i>
      </a>
    </p>
  </div>
</div>
