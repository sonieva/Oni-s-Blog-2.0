<?
// Santi Onieva

require_once '../config/Config.php';
Config::setTitol('Perfil');

require_once '../config/utils.php';
require_once '../model/Usuari/Usuari.php';

session_start();

if (!isset($_SESSION['usuari'])) {
  header('Location: ..');
}

include 'components/header.php';
?>

<div class="perfil">
  <h1><?= $_SESSION['usuari']->getAlies() ?></h1>
  
  <hr>

  <div class="info">
    <p>
      <strong>Nom complet: </strong><span id="nom-text"><?= $_SESSION['usuari']->getNomComplet() ?? 'No configurat' ?></span>
      <input type="text" class="nom-input" id="nom-input">
      <button class="btn-edit-nom" id="btn-edit-nom">
        <i class="fas fa-pencil"></i>
      </button>
    </p>

    <p><strong>Alies: </strong><?= $_SESSION['usuari']->getAlies() ?></p>
    <p><strong>Correu: </strong><?= $_SESSION['usuari']->getEmail() ?></p>
    <p><strong>Contrasenya: </strong><?= str_repeat('•', 10) ?></p>
  </div>
</div>