<?php
// Santi Onieva

// S'inclou el fitxer de configuració i s'estableix el títol de la pàgina a "Login".
require_once '../../config/Config.php';
Config::setTitol('Login');
Config::setArchiusCSS(['forms']);
Config::setArchiusJS(['toggle-password', 'remove-autocomplete', 'auth-popup']);

session_start();

if (isset($_SESSION['usuari'])) {
  header('Location: /');
}

// S'inclou el component del header.
include '../components/header.php';

if (!isset($_SESSION['intentsLogin'])) {
  $_SESSION['intentsLogin'] = 0;
}

// Es comprova si hi ha dades de login emmagatzemades en la sessió.
if (isset($_SESSION['dadesLogin'])) {
  // Si existeixen, es recupera l'email de les dades de login i es neteja la sessió.
  $email = $_SESSION['dadesLogin']['email'];
  unset($_SESSION['dadesLogin']);
} else if (isset($_COOKIE['email'])) {
  // Si no hi ha dades de login a la sessió, es comprova si hi ha una cookie amb l'email.
  $email = $_COOKIE['email'];
} else {
  // Si no hi ha ni dades de sessió ni cookie, es deixa l'email buit.
  $email = '';
}

// Es comprova si hi ha errors de login emmagatzemats en la sessió.
$errors = getMessages('errorsLogin');
$error = getMessages('errorLogin');
$missatge = getMessage('missatgeLogin');

include_once '../components/toasters.php'
?>

<div class="custom-form form-login">
  <h1>Iniciar sessió</h1>

  <?php include '../components/form-errors.php'; ?>

  <form action="auth/login.php" method="POST">
    <!-- Camp per introduir el correu electrònic, s'omple automàticament si hi ha dades disponibles. -->
    <label for="email">Correu electrònic</label>
    <div class="input">
      <input <?php if (!empty($email)) echo 'class="autocompleted"' ?> type="email" name="email" required autocomplete="off" value="<?= $email ?>">
      <i class="fa-solid fa-at"></i>
    </div>

    <!-- Camp per introduir la contrasenya. -->
    <label for="password">Contrasenya</label>
    <div class="input">
      <input <?php if (!empty($password)) echo 'class="autocompleted"' ?> type="password" name="password" required>
      <i class="fa-solid fa-lock" id="toggle-password"></i>
    </div>

    <!-- Checkbox per recordar l'usuari en futurs inicis de sessió. -->
    <div class="recordar">
      <label for="recordar">Recorda'm</label>
      <input type="checkbox" name="recordar">
    </div>

    <!-- Enllaç per recuperar la contrasenya. -->
    <p>Has olvidat la contrasenya? <a href="view/auth/recuperacio.view.php">Recupera-la</a></p>

    <!-- Mostrar reCAPTCHA només si els intents de login superen el límit -->
    <?php if ($_SESSION['intentsLogin'] >= 3): ?>
      <div class="recaptcha">
        <div class="g-recaptcha" data-sitekey="6Lcw6HIqAAAAAGq0Okq5wzhOsDfiAmGs5b_O09rI"></div>
      </div>
    <?php endif; ?>

    <!-- Botó per enviar el formulari de login. -->
    <button type="submit">Entrar</button>
  </form>
  
  <!-- Enllaç per a aquells usuaris que no tenen un compte i volen registrar-se. -->
  <p>No tens compte? <a href="view/auth/signup.view.php">Registra't</a></p>

  <h4 class="social-auth">També pots iniciar sessio amb</h4>

  <div class="social-auth-container">
    <a href="auth/google.php" class="google-auth">
      <i class="fa-brands fa-google"></i>
    </a>
    <a onclick="authPopup('github')" class="github-auth">
      <i class="fa-brands fa-github"></i>
    </a>
  </div>

</div>