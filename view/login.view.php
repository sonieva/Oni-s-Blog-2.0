<?php
// Santi Onieva

require_once '../config/Config.php';
Config::setTitol('Login');

include 'components/header.php';

if (isset($_SESSION['dadesLogin'])) {
  $email = $_SESSION['dadesLogin']['email'];
  unset($_SESSION['dadesLogin']);
}
?>

<div class="form-login">
  <h1>Iniciar sessió</h1>

  <?php if (isset($_SESSION['errorsLogin']) && !empty($_SESSION['errorsLogin'])): ?>
    <div class="missatge-error">
      <ul>
        <?php foreach ($_SESSION['errorsLogin'] as $error): ?>
          <li><?php echo $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php unset($_SESSION['errorsLogin']); ?>
  <?php endif; ?>
    
  <form action="auth/login.php" method="POST">

    <label for="email">Correu electronic</label>
    <div class="input">
      <input type="email" name="email" required autocomplete="off" value="<?php if (isset($email)) echo $email ?>">
      <i class="fa-solid fa-at"></i>
    </div>

    <label for="password">Contrasenya</label>
    <div class="input">
      <input type="password" name="password" required>
      <i class="fa-solid fa-lock"></i>
    </div>

    <button type="submit" class="login">Entrar</button>
  </form>
</div>

