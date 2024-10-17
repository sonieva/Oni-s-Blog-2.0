<?php

function getHoraDelDia() {
  $hora = date('H');

  if ($hora >= 6 && $hora < 12) {
    return 'matí';
  } else if ($hora >= 12 && $hora < 20) {
    return 'a tarda';
  } else {
    return 'a nit';
  }
}

function getDiaSetmana() {
  $diesSetmana = [
    'Dilluns',
    'Dimarts',
    'Dimecres',
    'Dijous',
    'Divendres',
    'Dissabte',
    'Diumenge',
  ];

  return $diesSetmana[date('N') - 1];
}

function validarContrasenya(string $password) {
  return strlen($password) >= 8 && preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/[0-9]/', $password) && preg_match('/[\W]/', $password);
}

function validarImatge($imatge) {
  $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  $fileExtension = strtolower(pathinfo($imatge['name'], PATHINFO_EXTENSION));
  
  if (!isset($_FILES['imatge'])) {
    $_SESSION['errorAdd'][] = 'No s\'ha pujat cap imatge';
  }

  if ($_FILES['imatge']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['errorAdd'][] = 'No s\'ha pogut pujar la imatge';
  }
  

  if (!in_array($fileExtension, $allowedExtensions)) {
    $_SESSION['errorAdd'][] = 'L\'arxiu no té una extensió vàlida';
  }

  if (!move_uploaded_file($imatge['tmp_name'], '../uploads/' . basename($imatge['name']))) {
    $_SESSION['errorAdd'][] = 'No s\'ha pogut pujar la imatge al servidor';
  }
}