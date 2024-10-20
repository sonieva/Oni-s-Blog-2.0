<?php
// Santi Onieva

// Inclou la configuració i estableix el títol de la pàgina
require_once '../config/Config.php';
Config::setTitol('Perfil');

// Inclou utilitats i el model de l'usuari
require_once '../config/utils.php';
require_once '../model/Usuari/Usuari.php';

// Inicia la sessió
session_start();

// Comprova si l'usuari està autenticat; en cas contrari, redirigeix a la pàgina principal
if (!isset($_SESSION['usuari'])) {
  header('Location: ..');
}

// Inclou el capçal de la pàgina
include 'components/header.php';
?>

<div class="perfil">
  <!-- Mostra el nom d'usuari com a títol -->
  <h1><?= $_SESSION['usuari']->getAlies() ?></h1>
  
  <hr>

  <div class="info">
    <!-- Mostra el nom complet de l'usuari amb la possibilitat d'editar-lo -->
    <p>
      <strong>Nom complet: </strong>
      <span id="nom-text"><?= $_SESSION['usuari']->getNomComplet() ?? 'No configurat' ?></span>
      <input type="text" class="nom-input" id="nom-input">
      <button class="btn-edit-nom" id="btn-edit-nom">
        <i class="fas fa-pencil"></i>
      </button>
    </p>

    <!-- Mostra altres dades de l'usuari, com l'alies i el correu electrònic -->
    <p><strong>Alies: </strong><?= $_SESSION['usuari']->getAlies() ?></p>
    <p><strong>Correu: </strong><?= $_SESSION['usuari']->getEmail() ?></p>
    <p><strong>Contrasenya: </strong><?= str_repeat('•', 10) ?></p>
  </div>
</div>
