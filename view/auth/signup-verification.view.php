<?php
// Santi Onieva

require_once '../../config/Config.php';
Config::setTitol('Verifica el teu correu');
Config::setArchiusCSS(['forms']);

require_once '../../utils/utils.php';

usuariNoEstaLogat();

include '../components/header.php';

$errors = getMessages('errorsVerificacioCorreu');
$error = getMessage('errorVerificacioCorreu');
$missatge = getMessage('missatgeVerificacioCorreu');

include_once '../components/toasters.php'
?>

<div class="custom-form form-verificacio-email">
  <h1>Verifica el teu compte</h1>
  <h5>Per completar el registre, verifica el teu correu electrònic introduint el codi que t'hem enviat</h5>

  <?php include '../components/form-errors.php'; ?>

  <form action="auth/signup.php" method="POST">
    <div class="input">
      <input type="text" name="codiVerificacio" required>
      <i class="fa-solid fa-envelope-circle-check"></i>
    </div>

    <button type="submit">Verifica</button>
  </form>
</div>