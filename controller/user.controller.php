<?php
// Santi Onieva

require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../utils/utils.php';
require_once '../config/Config.php';

if (isset($_GET['action']) && ($_SERVER['REQUEST_METHOD'] === 'POST' || $_GET['action'] === 'delete')) {
  // S'utilitza un switch per determinar l'acció a executar.
  switch ($_GET['action']) {
    case 'reset_password_mail':
      enviarCorreuRecuperacio($_POST['correuRecuperacio']);
      break;
    case 'reset_password_sms':
      enviarSMSRecuperacio($_POST['telefonRecuperacio']);
      break;
    case 'delete':
      eliminarUsuari($_GET['id']);
      break;
  }
} else {
  http_response_code(403);
  header('Location: ../view/errors/403.html');
  exit();
}

function enviarCorreuRecuperacio($correuRecuperacio): void {
  
  if (isset($_SESSION['usuari'])) {
    setMessage('errorInici', 'Has d\'estar deslogat per poder restablir la contrasenya');
    header('Location: ../view/inici.view.php');
  }

  if (empty($correuRecuperacio)) {
    addMessage('errorsRecuperacio', 'Has d\'omplir el camp correu electrònic');
  }

  if (!filter_var($correuRecuperacio, FILTER_VALIDATE_EMAIL)) {
    addMessage('errorsRecuperacio', 'El correu electrònic no és vàlid');
  }

  $usuariDAO = new UsuariDAO();
  $usuari = $usuariDAO->getUsuariPerEmail($correuRecuperacio);

  if (!$usuari) {
    addMessage('errorsRecuperacio', 'No existeix cap usuari amb aquest correu electrònic');
  }

  if (!empty($_SESSION['errorsRecuperacio'])) {
    header('Location: ../view/auth/recuperacio.view.php');
    exit();
  }

  $token = generarTokenRecuperacio();
  $expiry = (new DateTime('now'))->add(new DateInterval('PT15M'));

  $usuari->setTokenRecuperacio($token);
  $usuari->setExpiracioToken($expiry);
  $usuariDAO->modificar($usuari);

  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? "https" : "http";
  $host = $_SERVER['HTTP_HOST'];
  $resetLink = "$protocol://$host" . BASE_PATH . "/view/auth/reset-password.view.php?token=$token";

  require_once '../utils/MailUtils.php';

  MailUtils::enviarCorreuRecuperacio($correuRecuperacio, $resetLink);

  if (empty($_SESSION['errorCorreu'])) setMessage('missatgeCorreu', 'Correu de recuperació enviat correctament');

  header('Location: ../view/auth/recuperacio.view.php');
  exit();
}

function enviarSMSRecuperacio($telefonRecuperacio): void {
  require_once '../utils/SMSUtils.php';

  // SMSUtils::enviarSMS($telefonRecuperacio, 'Has sol·licitat un canvi de contrasenya. Accedeix al següent enllaç per restablir-la: http://localhost/view/auth/reset-password.view.php');
}

function eliminarUsuari($id) {
  if (!isset($_SESSION['usuari'])) {
    setMessage('errorLogin', 'No estàs identificat');
    header('Location: ../login');
    exit();
  }

  if (!$_SESSION['usuari']->esAdmin()) {
    setMessage('errorInici', 'No tens permisos per eliminar usuaris');
    header('Location: ..');
    exit();
  }

  $usuariDAO = new UsuariDAO();
  $usuari = $usuariDAO->getUsuariPerId($id);

  if (!$usuari) {
    setMessage('errorAdmin', 'No s\'ha trobat cap usuari amb aquest ID');
    header('Location: ../view/admin.view.php');
    exit();
  }

  if ($usuariDAO->eliminar($usuari->getId())) {
    setMessage('missatgeAdmin', 'Usuari eliminat correctament');
  } else {
    setMessage('errorAdmin', 'Error al eliminar l\'usuari');
  }

  header('Location: ../view/admin.view.php');
  exit();
}

?>