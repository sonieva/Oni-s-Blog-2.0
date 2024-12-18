<?php
// Santi Onieva

require_once '../../config/Config.php';
Config::setTitol('Canviar contrasenya');
Config::setArchiusCSS(['forms']);
Config::setArchiusJS(['toggle-password']);

require_once '../../model/Usuari/Usuari.php';
require_once '../../utils/utils.php';

usuariEstaLogat();

include '../components/header.php';

$errors = getMessages('errorChangePassword');
?>

<div class="custom-form form-change-password">
  <h1>Modificar contrasenya</h1>

  <?php include '../components/form-errors.php'; ?>

  <form action="auth/change-password.php" method="POST">
    <label for="old-password">Contrasenya antiga</label>
    <div class="input">
      <input type="password" name="antigaPassword" required>
      <i class="fa-solid fa-lock" id="toggle-old-password" title="Mostrar contrasenya"></i>
    </div>

    <label for="new-password">Nova contrasenya</label>
    <div class="input">
      <input type="password" name="novaPassword" required>
      <i class="fa-solid fa-lock" id="toggle-password" title="Mostrar contrasenya"></i>
    </div>

    <label for="new-password2">Contrasenya antiga</label>
    <div class="input">
      <input type="password" name="novaPassword2" required>
      <i class="fa-solid fa-lock" id="toggle-password2" title="Mostrar contrasenya"></i>
    </div>

    <button type="submit">Canviar contrasenya</button>
  </form>
</div>