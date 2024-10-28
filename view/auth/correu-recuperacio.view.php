<?php
// Santi Onieva

require_once '../../config/Config.php';
Config::setTitol('Restablir contrasenya');

include '../components/header.php';

$errors = getMessages('errorsResetPassword');
$error = getMessage('errorCorreu');
$missatge = getMessage('missatgeCorreu');
?>

<?php if ($missatge): ?>
  <div id="toaster" class="toaster toaster-success"><?= $missatge ?></div>
<?php endif; ?>

<?php if ($error): ?>
  <div id="toaster" class="toaster toaster-error"><?= $error ?></div>
<?php endif; ?>

<div class="custom-form form-correu-recuperacio">
  <h1>Recupera la contrasenya</h1>

  <?php if ($errors): ?>
    <div class="missatge-error">
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
  
  <form action="controller/user.controller.php?action=reset_password_mail" method="post">
    
    
    <label for="correuRecuperacio">Correu electrònic</label>
    <div class="input">
      <input type="email" name="correuRecuperacio" required>
      <i class="fa-solid fa-at"></i>
    </div>

    <button type="submit">Enviar coreu de recuperació</button>
  </form>
</div>