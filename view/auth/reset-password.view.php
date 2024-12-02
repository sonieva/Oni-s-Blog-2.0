<?php
// Santi Onieva

if (isset($_GET['token'])) {
  $token = $_GET['token'];
  
  require_once '../../model/Usuari/UsuariDAO.php';
  $usuariDAO = new UsuariDAO();
  $usuari = $usuariDAO->getUsuariPerTokenRecuperacio($token);
  
  if (!$usuari) {
    header('Location: /');
    exit();
  }
} else {
  header('Location: /');
  exit();
}

require_once '../../config/Config.php';
Config::setTitol('Restablir contrasenya');
Config::setArchiusCSS(['forms']);
Config::setArchiusJS(['toggle-password']);

require_once '../../utils/utils.php';

usuariNoEstaLogat();

include '../components/header.php';

$errors = getMessages('errorsResetPassword');
?>

<div class="custom-form form-reset-password">
  <h1>Restablir contrasenya</h1>

  <?php include '../components/form-errors.php'; ?>

  <form action="auth/reset-password.php" method="post">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

    <label for="new-password">Nova contrasenya</label>
    <div class="input">
      <input type="password" name="novaPassword" minlength="8" required>
      <i class="fa-solid fa-lock" id="toggle-password" title="Mostrar contrasenya"></i>
    </div>

    <label for="new-password2">Confirma nova contrasenya</label>
    <div class="input">
      <input type="password" name="novaPassword2" minlength="8" required>
      <i class="fa-solid fa-lock" id="toggle-password2" title="Mostrar contrasenya"></i>
    </div>

    <button type="submit">Restablir contrasenya</button>
  </form>
</div>