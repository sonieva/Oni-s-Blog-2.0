<?php
include_once '../config/Config.php';
Config::setTitol('Registre');
include 'header.php';
?>

<div class="container card form-registre">
  <h1 class="text-center p-3">Registra't</h1>
    
  <form action="controller/register.controller.php" method="POST" class="m-2">
    
    <div class="row mb-3">
      <label for="nom_complet" class="col-4 col-form-label">Nom complet</label>
      <div class="input">
        <input type="text" class="form-control" id="nom_complet" name="nom_complet" required>
      </div>
    </div>
      
    <div class="row mb-3">
      <label for="alies" class="col-4 col-form-label">Nom d'usuari</label>
      <div class="input">
        <input type="text" class="form-control" id="alies" name="alies" required>
      </div>
    </div>

    <div class="row mb-3">
      <label for="email" class="col-4 col-form-label">Correu electronic</label>
      <div class="input">
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
    </div>

    <div class="row mb-3">
      <label for="password" class="col-4 col-form-label">Contraseña</label>
      <div class="input">
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
    </div>

    <div class="row mb-3">
      <label for="password2" class="col-4 col-form-label">Confirmar contraseña</label>
      <div class="input">
        <input type="password" class="form-control" id="password2" name="password2" required>
      </div>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger" role="alert">
        <?= $_SESSION['error'] ?>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary mb-2">Registar-se</button>
  </form>
</div>
