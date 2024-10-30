<?php
// Santi Onieva

require_once '../../config/Config.php';
Config::setTitol('Restablir contrasenya');

session_start();

if (isset($_SESSION['usuari'])) {
  header('Location: ../..');
}

include '../components/header.php';

$errors = getMessages('errorsCorreuRecuperacio');
$error = getMessage('errorCorreu');
$missatge = getMessage('missatgeCorreu');

include_once '../components/toasters.php'
?>

<div class="custom-form form-correu-recuperacio">
  <h1>Recupera la teva contrasenya</h1>

  <?php include '../components/form-errors.php'; ?>
  
  <form action="controller/user.controller.php?action=reset_password_mail" method="post">
    <label for="correuRecuperacio">Correu electrònic</label>
    <div class="input">
      <input type="email" name="correuRecuperacio" required>
      <i class="fa-solid fa-at"></i>
    </div>

    <button type="submit">Enviar coreu de recuperació</button>
  </form>
</div>