<?php
define('BASE_PATH', join('/',array_values(array_diff(explode('/',$_SERVER['REQUEST_URI']), ['view', 'register.view.php'])))); 
include 'header.php'; 
?>
<form action="<? echo BASE_PATH ?>/controller/registerController.php" method="POST">
    <div class="mb-3">
        <label for="nickname" class="form-label">Nom d'usuari</label>
        <input type="text" class="form-control" id="nickname" name="nickname" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Crear Cuenta</button>
</form>
