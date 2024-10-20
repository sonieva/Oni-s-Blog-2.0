<?php
// Santi Onieva

require_once '../../config/Config.php';
Config::setTitol('Login');

include '../components/header.php';

if (isset($_SESSION['dadesLogin'])) {
  $email = $_SESSION['dadesLogin']['email'];
  unset($_SESSION['dadesLogin']);
} else if (isset($_COOKIE['email'])) {
  $email = $_COOKIE['email'];
} else {
  $email = '';
}

?>

<div class="form-login">
  <h1>Iniciar sessió</h1>

  <?php if (isset($_SESSION['errorsLogin']) && !empty($_SESSION['errorsLogin'])): ?>
    <div class="missatge-error">
      <ul>
        <?php foreach ($_SESSION['errorsLogin'] as $error): ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php unset($_SESSION['errorsLogin']); ?>
  <?php endif; ?>
    
  <form action="auth/login.php" method="POST">

    <label for="email">Correu electronic</label>
    <div class="input">
      <input type="email" name="email" required autocomplete="off" value="<?= $email ?>">
      <i class="fa-solid fa-at"></i>
    </div>

    <label for="password">Contrasenya</label>
    <div class="input">
      <input type="password" name="password" required>
      <i class="fa-solid fa-lock" id="toggle-password"></i>
    </div>

    <div class="recordar">
      <label for="recordar">Recorda'm</label>
      <input type="checkbox" name="recordar">
    </div>
    
    <button type="submit" class="login">Entrar</button>
  </form>
  <p>No tens compte? <a href="view/auth/register.view.php">Registra't</a></p>
</div>

<? if (isset($_SESSION['missatgeInactivitat'])): ?>
  <div id="toaster" class="toaster toaster-info"><?= $_SESSION['missatgeInactivitat'] ?></div>
  <? unset($_SESSION['missatgeInactivitat']); ?>
<? endif; ?>
