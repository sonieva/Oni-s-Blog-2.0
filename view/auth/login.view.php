<?php
// Santi Onieva

// S'inclou el fitxer de configuració i s'estableix el títol de la pàgina a "Login".
require_once '../../config/Config.php';
Config::setTitol('Login');

// S'inclou el fitxer de funcions utils.php.
require_once '../../config/utils.php';

// S'inclou el component del header.
include '../components/header.php';

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
?>

<div class="form-login">
  <h1>Iniciar sessió</h1>

  <?php if ($errors): ?>
    <div class="missatge-error">
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
    
  <form action="auth/login.php" method="POST">
    <!-- Camp per introduir el correu electrònic, s'omple automàticament si hi ha dades disponibles. -->
    <label for="email">Correu electrònic</label>
    <div class="input">
      <input type="email" name="email" required autocomplete="off" value="<?= $email ?>">
      <i class="fa-solid fa-at"></i>
    </div>

    <!-- Camp per introduir la contrasenya. -->
    <label for="password">Contrasenya</label>
    <div class="input">
      <input type="password" name="password" required>
      <i class="fa-solid fa-lock" id="toggle-password"></i>
    </div>

    <!-- Checkbox per recordar l'usuari en futurs inicis de sessió. -->
    <div class="recordar">
      <label for="recordar">Recorda'm</label>
      <input type="checkbox" name="recordar">
    </div>

    <!-- Enllaç per recuperar la contrasenya. -->
    <p>Has olvidat la contrasenya?</p>
    
    <!-- Botó per enviar el formulari de login. -->
    <button type="submit">Entrar</button>
  </form>

  
  
  <!-- Enllaç per a aquells usuaris que no tenen un compte i volen registrar-se. -->
  <p>No tens compte? <a href="view/auth/register.view.php">Registra't</a></p>
</div>

<!-- Si hi ha un missatge de sessió caducada per inactivitat, es mostra un toaster amb aquest missatge. -->
<?php if (isset($_SESSION['missatgeInactivitat'])): ?>
  <div id="toaster" class="toaster toaster-info"><?= $_SESSION['missatgeInactivitat'] ?></div>
  <?php unset($_SESSION['missatgeInactivitat']); ?>
<?php endif; ?>
