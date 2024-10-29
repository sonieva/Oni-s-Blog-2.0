<?php
// Santi Onieva

// S'inclou el fitxer de configuració i s'estableix el títol de la pàgina a "Registre".
include_once '../../config/Config.php';
Config::setTitol('Registre');

session_start();

if (isset($_SESSION['usuari'])) {
  header('Location: ../..');
}

// S'inclou el component del header.
include '../components/header.php';

// Es comprova si hi ha dades de registre emmagatzemades a la sessió.
if (isset($_SESSION['dadesRegistre'])) {
  // Si existeixen, es recuperen l'àlies i l'email de les dades de registre i es neteja la sessió.
  $alies = $_SESSION['dadesRegistre']['alies'];
  $email = $_SESSION['dadesRegistre']['email'];
  unset($_SESSION['dadesRegistre']);
}

$errors = getMessages('errorsRegister');
?>

<div class="custom-form form-registre">
  <h1>Crear compte</h1>

  <?php include '../components/form-errors.php'; ?>
    
  <form action="auth/register.php" method="POST">
      
    <!-- Camp per introduir el nom d'usuari, es preomple automàticament si hi ha dades disponibles. -->
    <label for="alies">Nom d'usuari</label>
    <div class="input">
      <input type="text" name="alies" required value="<?php if (isset($alies)) echo $alies ?>">
      <i class="fa-solid fa-user"></i>
    </div>

    <!-- Camp per introduir el correu electrònic, es preomple automàticament si hi ha dades disponibles. -->
    <label for="email">Correu electrònic</label>
    <div class="input">
      <input type="email" name="email" required autocomplete="off" value="<?php if (isset($email)) echo $email ?>">
      <i class="fa-solid fa-at"></i>
    </div>

    <!-- Camp per introduir la contrasenya. -->
    <label for="password">Contrasenya</label>
    <div class="input">
      <input type="password" name="password" minlength="8" required>
      <i class="fa-solid fa-lock" id="toggle-password"></i>
    </div>

    <!-- Camp per repetir la contrasenya. -->
    <label for="password2">Repeteix contrasenya</label>
    <div class="input">
      <input type="password" name="password2" required>
      <i class="fa-solid fa-lock" id="toggle-password2"></i>
    </div>

    <!-- Botó per enviar el formulari de registre. -->
    <button type="submit" class="signup">Registrar-se</button>
  </form>

  <!-- Enllaç per a aquells usuaris que ja tenen un compte i volen iniciar sessió. -->
  <p>Ja tens compte? <a href="view/auth/login.view.php">Inicia sessió</a></p>
</div>
