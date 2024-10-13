<?php
include_once '../config/Config.php';
Config::setTitol('Registre');

include 'components/header.php';

if (isset($_SESSION['dadesRegistre'])) {
  $alies = $_SESSION['dadesRegistre']['alies'];
  $email = $_SESSION['dadesRegistre']['email'];
  unset($_SESSION['dadesRegistre']);
}

?>

<div class="form-registre">
  <h1>Crear compte</h1>

  <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
    <div class="missatge-error">
      <ul>
        <?php foreach ($_SESSION['error'] as $error): ?>
          <li><?php echo $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>
    
  <form action="auth/register.php" method="POST">
      
    <label for="alies">Nom d'usuari</label>
    <div class="input">
      <input type="text" name="alies" required value="<?php if (isset($alies)) echo $alies ?>">
      <i class="fa-solid fa-user"></i>
    </div>

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

    <label for="password2">Repeteix contrasenya</label>
    <div class="input">
      <input type="password" name="password2" required>
      <i class="fa-solid fa-lock"></i>
    </div>

    <button type="submit" class="signup">Registar-se</button>
  </form>
</div>
