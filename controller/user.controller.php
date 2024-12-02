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
    case 'delete':
      eliminarUsuari($_GET['id']);
      break;
    case 'make_admin':
      ferAdmin($_GET['id']);
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
    header('Location: /recuperacio');
    exit();
  }

  $token = generarTokenRecuperacio();
  $expiry = (new DateTime('now'))->add(new DateInterval('PT15M'));

  $usuari->setTokenRecuperacio($token);
  $usuari->setExpiracioToken($expiry);
  $usuariDAO->modificar($usuari);

  require_once '../utils/MailUtils.php';

  MailUtils::enviarCorreuRecuperacio($correuRecuperacio, $token);

  if (empty($_SESSION['errorRecuperacio'])) setMessage('missatgeCorreu', 'Correu de recuperació enviat correctament');

  header('Location: /recuperacio');
  exit();
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
    header('Location: /admin');
    exit();
  }

  if ($usuari->getId() === $_SESSION['usuari']->getId()) {
    setMessage('errorAdmin', 'No pots eliminar el teu propi usuari');
    header('Location: /admin');
    exit();
  }

  if ($usuari->esAdmin()) {
    setMessage('errorAdmin', 'No pots eliminar un usuari administrador');
    header('Location: /admin');
    exit();
  }

  if ($usuariDAO->eliminar($usuari->getId())) {
    setMessage('missatgeAdmin', 'Usuari eliminat correctament');
  } else {
    setMessage('errorAdmin', 'Error al eliminar l\'usuari');
  }

  header('Location: /admin');
  exit();
}

function ferAdmin($id) {
  if (!isset($_SESSION['usuari'])) {
    setMessage('errorLogin', 'No estàs identificat');
    header('Location: ../login');
    exit();
  }

  if (!$_SESSION['usuari']->esAdmin()) {
    setMessage('errorInici', 'No tens permisos per fer administradors');
    header('Location: ..');
    exit();
  }

  $usuariDAO = new UsuariDAO();
  $usuari = $usuariDAO->getUsuariPerId($id);

  if (!$usuari) {
    setMessage('errorAdmin', 'No s\'ha trobat cap usuari amb aquest ID');
    header('Location: /admin');
    exit();
  }

  if ($usuari->esAdmin()) {
    setMessage('errorAdmin', 'Aquest usuari ja és administrador');
    header('Location: /admin');
    exit();
  }

  $usuari->setEsAdmin(true);

  if ($usuariDAO->modificar($usuari)) {
    setMessage('missatgeAdmin', 'Usuari fet administrador correctament');
  } else {
    setMessage('errorAdmin', 'Error al fer administrador');
  }

  header('Location: /admin');
  exit();
}

?>