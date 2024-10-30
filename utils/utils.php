<?php
// Santi Onieva

if (session_status() == PHP_SESSION_NONE) session_start();

// Funció per obtenir la part del dia en funció de l'hora actual.
function getHoraDelDia(): string {
  // S'obté l'hora actual en format de 24 hores.
  $hora = date('H');

  // Es retorna 'matí' si és entre les 6:00 i les 11:59.
  if ($hora >= 6 && $hora < 12) {
    return 'matí';
  } 
  // Es retorna 'a tarda' si és entre les 12:00 i les 19:59.
  else if ($hora >= 12 && $hora < 20) {
    return 'a tarda';
  } 
  // Es retorna 'a nit' per qualsevol altra hora.
  else {
    return 'a nit';
  }
}

// Funció per obtenir el dia de la setmana en català.
function getDiaSetmana(): string {
  // Es defineix un array amb els dies de la setmana.
  $diesSetmana = [
    'Dilluns',
    'Dimarts',
    'Dimecres',
    'Dijous',
    'Divendres',
    'Dissabte',
    'Diumenge',
  ];

  // Es retorna el dia de la setmana corresponent a l'índex de l'array (1 = Dilluns).
  return $diesSetmana[date('N') - 1];
}

// Funció per generar un missatge de benvinguda aleatori.
function missatgeBenvinguda(): string {
  // Es defineix un array amb diferents missatges de benvinguda.
  $llistatBenvingudes = [
    'Hola', 
    'Bon ' . getHoraDelDia(), 
    'Benvingut/da',
    'Benvingut/da de nou',
    'Feliç ' . getDiaSetmana(), 
    'Hola de nou', 
  ];

  // Es retorna un missatge de benvinguda aleatori de l'array.
  return $llistatBenvingudes[array_rand($llistatBenvingudes)];
}

// Funció per validar la seguretat d'una contrasenya.
function validarContrasenya(string $password): bool {
  // Es comprova que la contrasenya tingui almenys 8 caràcters, una majúscula, una minúscula, un número i un caràcter especial.
  return strlen($password) >= 8 && 
    preg_match('/[A-Z]/', $password) && 
    preg_match('/[a-z]/', $password) && 
    preg_match('/[0-9]/', $password) && 
    preg_match('/[\W]/', $password);
}

// Funció per validar una imatge pujada.
function validarImatge($imatge): void {
  // Es defineixen les extensions permeses per les imatges.
  $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  // S'obté l'extensió de l'arxiu pujat.
  $fileExtension = strtolower(pathinfo($imatge['name'], PATHINFO_EXTENSION));
  
  // Es comprova si no s'ha pujat cap arxiu.
  if (!isset($imatge)) {
    addMessage('errorAdd', 'No s\'ha pujat cap imatge');
  }

  // Es comprova si hi ha hagut algun error durant la pujada de l'arxiu.
  if ($imatge['error'] !== UPLOAD_ERR_OK) {
    addMessage('errorAdd', 'No s\'ha pogut pujar la imatge');
  }
  
  // Es comprova si l'extensió de l'arxiu no és vàlida.
  if (!in_array($fileExtension, $allowedExtensions)) {
    addMessage('errorAdd', 'L\'arxiu no té una extensió vàlida');
  }

  // Es mou l'arxiu pujat a la carpeta 'uploads' i es comprova si l'operació ha estat correcta.
  if (!move_uploaded_file($imatge['tmp_name'], '../uploads/' . basename($imatge['name']))) {
    addMessage('errorAdd', 'No s\'ha pogut pujar la imatge al servidor');
  }
}

function setMessage($key, $message): void {
  $_SESSION[$key] = $message;
}

function addMessage($key, $message): void {
  $_SESSION[$key][] = $message;
}

function getMessage($key): ?string {
  if (isset($_SESSION[$key])) {
      $message = $_SESSION[$key];
      unset($_SESSION[$key]); 
      return $message;
  }
  return null;
}

function getMessages($key): ?array {
  if (isset($_SESSION[$key])) {
      $messages = $_SESSION[$key];
      unset($_SESSION[$key]);
      return $messages;
  }
  return null;
}

function generarTokenRecuperacio(): string {
  return bin2hex(random_bytes(32));
}
?>
