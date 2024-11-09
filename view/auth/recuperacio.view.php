<?php
// Santi Onieva

require_once '../../config/Config.php';
Config::setTitol('Restablir contrasenya');
Config::setArchiusCSS(['forms']);

session_start(); // S'inicia la sessió.

if (isset($_SESSION['usuari'])) {
  header('Location: ../..');
}

include '../components/header.php';

$errors = getMessages('errorsRecuperacio');
$error = getMessage('errorCorreu');
$missatge = getMessage('missatgeCorreu');

include_once '../components/toasters.php'
?>

<div class="custom-form form-recuperacio">
  <h1>Recupera la teva contrasenya</h1>

  <?php include '../components/form-errors.php'; ?>

  <form action="controller/user.controller.php?action=reset_password_mail" method="POST">
    <label for="correuRecuperacio">Correu electrònic</label>
    <div class="input">
      <input type="email" name="correuRecuperacio" required>
      <i class="fa-solid fa-at"></i>
    </div>

    <button type="submit">Enviar coreu de recuperació</button>
  </form>

  <!-- <form action="controller/user.controller.php?action=reset_password_sms" method="POST">
    <label for="telefonRecuperacio">Telèfon mòbil</label>
    <div class="input">
      <input type="text" name="telefonRecuperacio" required>
      <i class="fa-solid fa-mobile"></i>
    </div>

    <button type="submit">Enviar SMS de recuperació</button>
  </form> -->
</div>