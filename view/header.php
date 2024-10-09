<?
// Santi Onieva

session_start();
// $_SESSION['user_id'] = 1;
$userLogged = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oni's Blog 2.0</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo BASE_PATH ?>/assets/css/styles.css">
</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">

      <a class="navbar-brand row align-items-center" href="#">
        <img src="<?php echo BASE_PATH ?>/assets/images/logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top col-auto">
        <h4 class="col-auto px-0">Oni's Blog 2.0</h4>
      </a>

      <h2 class="vertical-bar">|</h2>

      <h4 class="nom-pagina">Inici</h4>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">

          <li class="nav-item"><a class="nav-link" href=""><i class="bi bi-house-door-fill"></i>Inici</a></li>

          <li class="nav-item dropdown-center">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-fill"></i>No loguejat
            </a>

            <ul class="dropdown-menu">
              <? if ($userLogged): ?>
                <li><a class="dropdown-item" href="#"><i class="bi bi-speedometer2"></i>Dashboard</a></li>
                <li><a class="dropdown-item" href="<?php echo BASE_PATH ?>/auth/logout.php"><i class="bi bi-box-arrow-in-left"></i>Tancar sessió</a></li>
              <? else: ?>
                <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-in-right"></i>Iniciar sessio</a></li>
                <li><a class="dropdown-item" href="<?php echo BASE_PATH ?>/view/register.view.php"><i class="bi bi-person-plus-fill"></i>Crear compte</a></li>
              <? endif; ?>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>