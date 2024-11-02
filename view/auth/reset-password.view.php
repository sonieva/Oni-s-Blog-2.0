<?php
if (isset($_GET['token'])) {
  $token = $_GET['token'];
} else {
  header('Location: ../view/inici.view.php');
  exit();
}

require_once '../../config/Config.php';
Config::setTitol('Restablir contrasenya');
Config::setArchiusCSS(['forms']);
Config::setArchiusJS(['toggle-password']);

include '../components/header.php';

$errors = getMessages('errorsResetPassword');
?>

<div class="custom-form form-reset-password">
  <h1>Restablir contrasenya</h1>

  <?php include '../components/form-errors.php'; ?>

  <form action="controller/user.controller.php?action=reset_password" method="post">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

    <label for="new-password">Nova contrasenya</label>
    <div class="input">
      <input type="password" name="novaPassword" minlength="8" required>
      <i class="fa-solid fa-lock" id="toggle-password"></i>
    </div>

    <label for="new-password2">Confirma nova contrasenya</label>
    <div class="input">
      <input type="password" name="novaPassword2" minlength="8" required>
      <i class="fa-solid fa-lock" id="toggle-password2"></i>
    </div>

    <button type="submit">Restablir contrasenya</button>
  </form>
</div>