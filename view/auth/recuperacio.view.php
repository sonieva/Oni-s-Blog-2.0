<?php
// Santi Onieva

require_once '../../config/Config.php';
Config::setTitol('Enviar correu recuperació');
Config::setArchiusCSS(['forms']);

require_once '../../utils/utils.php';

usuariNoEstaLogat();

include '../components/header.php';

$errors = getMessages('errorsRecuperacio');
$error = getMessage('errorRecuperacio');
$missatge = getMessage('missatgeRecuperacio');

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
</div>