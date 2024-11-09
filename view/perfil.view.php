<?php
// Santi Onieva

// Inclou la configuració i estableix el títol de la pàgina
require_once '../config/Config.php';
Config::setTitol('Perfil');
Config::setArchiusCSS(['perfil']);
Config::setArchiusJS(['edit-alies', 'edit-nom', 'edit-foto-perfil']);

// Inclou el model de l'usuari
require_once '../model/Usuari/Usuari.php';
require_once '../utils/utils.php';

usuariLogat();

// Inclou el capçal de la pàgina
include 'components/header.php';

$usuari = $_SESSION['usuari'];

$missatge = getMessage('missatgePerfil');
$error = getMessage('errorPerfil');

include_once 'components/toasters.php'
?>

<div class="perfil">
  <div class="info-header">
    <!-- Mostra el nom d'usuari com a títol -->
    <h1 id="alies-titol"><?= $usuari->getAlies() ?></h1>

    <div class="container-foto-perfil">
      <img src="<?= ($usuari->getRutaImatge()) ?? 'assets/images/placeholder-usuari.png' ?>" alt="Foto de perfil" class="foto-perfil" id="foto-perfil">
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
      <span id="nom-text"><?= $usuari->getNomComplet() ?? 'No configurat' ?></span>
      <input type="text" class="perfil-input" id="nom-input">
      <button class="btn-edit-perfil" id="btn-edit-nom-perfil">
        <i class="fas fa-pencil"></i>
      </button>
    </p>

    <!-- Mostra altres dades de l'usuari, com l'alies i el correu electrònic -->
    <p>
      <strong>Alies: </strong>
      <span id="alies-text"><?= $usuari->getAlies() ?></span>
      <input type="text" class="perfil-input" id="alies-input">
      <button class="btn-edit-perfil" id="btn-edit-alies-perfil">
        <i class="fas fa-pencil"></i>
      </button>
      <span id="alies-status" class="alies-status-icon"></span> <!-- Contenedor del icono -->
      <span id="alias-status-msg" class="alias-status-msg"></span> <!-- Mensaje de estado -->
    </p>
    <p><strong>Correu: </strong><?= $usuari->getEmail() ?></p>
    <p>
      <strong>Contrasenya: </strong>
      <?php if ($usuari->getPassword() != 'SocialAuth'): ?>
        <?=  str_repeat('•', 10) ?>
        <a href="view/auth/change-password.view.php" class="btn-edit-perfil">
          <i class="fas fa-pencil"></i>
        </a>
      <?php else: ?>
        <span>Sessio iniciada amb Social Authentication</span>
      <?php endif; ?>
    </p>
  </div>
</div>