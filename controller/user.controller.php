<?php
// Santi Onieva

require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../utils/utils.php';
require_once '../config/Config.php';

if (isset($_GET['action'])) {
  // S'utilitza un switch per determinar l'acció a executar.
  switch ($_GET['action']) {
    case 'change_password':
      canviarPassword($_POST['antigaPassword'], $_POST['novaPassword'], $_POST['novaPassword2']);
      break;
    case 'reset_password_mail':
      enviarCorreuRecuperacio($_POST['correuRecuperacio']);
      break;
    case 'reset_password':
      resetPassword($_POST['token'], $_POST['novaPassword'], $_POST['novaPassword2']);
      break;
    default:
      setMessage('errorInici', 'Acció no vàlida');
      header('Location: ../view/inici.view.php');
      exit();
  }
} else {
  header('Location: ../view/perfil.view.php');
  exit();
}

function canviarPassword($oldPassword, $newPassword, $confirmPassword): void {
  // Es comprova que l'usuari està identificat.
  if (!isset($_SESSION['usuari'])) {
    setMessage('errorLogin', 'No estàs identificat');
    header('Location: ../view/auth/login.view.php');
  }

  if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
    addMessage('errorChangePassword', 'Has d\'omplir tots els camps');
  }

  // Es comprova que la contrasenya antiga sigui correcta.
  $oldUserPassword = $_SESSION['usuari']->getPassword();
  if (!password_verify($oldPassword, $oldUserPassword)) {
    addMessage('errorChangePassword', 'La contrasenya antiga no és correcta');
  }

  // Es comprova que les contrasenyes noves siguin iguals.
  if ($newPassword !== $confirmPassword) {
    addMessage('errorChangePassword', 'Les contrasenyes noves no coincideixen');
  }

  if(!validarContrasenya($newPassword) || !validarContrasenya($confirmPassword)) {
    addMessage('errorChangePassword', 'La nova contrasenya ha de tenir almenys 8 caràcters, una majúscula, una minúscula i un número');
  }

  if ($newPassword === $oldPassword) {
    addMessage('errorChangePassword', 'La contrasenya nova no pot ser igual a la contrasenya antiga');
  }

  // Si hi ha errors, es redirigeix de nou al perfil.
  if (!empty($_SESSION['errorChangePassword'])) {
    header('Location: ../view/auth/change-password.view.php');
    exit();
  }

  // Es canvia la contrasenya de l'usuari.
  $_SESSION['usuari']->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));

  $usuariDAO = new UsuariDAO();

  if ($usuariDAO->modificar($_SESSION['usuari'])) {
    setMessage('misssatgePerfil', 'Contrasenya canviada correctament');
  } else {
    addMessage('errorChangePassword', 'Error al canviar la contrasenya');
  }

  if (!empty($_SESSION['errorChangePassword'])) {
    header('Location: ../view/auth/change-password.view.php');
    exit();
  }

  header('Location: ../view/perfil.view.php');
  exit();
}

function enviarCorreuRecuperacio($correuRecuperacio): void {
  
  if (isset($_SESSION['usuari'])) {
    setMessage('errorInici', 'Has d\'estar deslogat per poder restablir la contrasenya');
    header('Location: ../view/inici.view.php');
  }

  if (empty($correuRecuperacio)) {
    addMessage('errorsCorreuRecuperacio', 'Has d\'omplir el camp correu electrònic');
  }

  if (!filter_var($correuRecuperacio, FILTER_VALIDATE_EMAIL)) {
    addMessage('errorsCorreuRecuperacio', 'El correu electrònic no és vàlid');
  }

  $usuariDAO = new UsuariDAO();
  $usuari = $usuariDAO->getUsuariPerEmail($correuRecuperacio);

  if (!$usuari) {
    addMessage('errorsCorreuRecuperacio', 'No existeix cap usuari amb aquest correu electrònic');
  }

  if (!empty($_SESSION['errorsCorreuRecuperacio'])) {
    header('Location: ../view/auth/correu-recuperacio.view.php');
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

  header('Location: ../view/auth/correu-recuperacio.view.php');
  exit();
}

function resetPassword($token, $newPassword, $confirmPassword): void {
  if (empty($newPassword) || empty($confirmPassword)) {
    addMessage('errorsResetPassword', 'Has d\'omplir tots els camps');
  }

  if ($newPassword !== $confirmPassword) {
    addMessage('errorsResetPassword', 'Les contrasenyes noves no coincideixen');
  }

  if(!validarContrasenya($newPassword) || !validarContrasenya($confirmPassword)) {
    addMessage('errorsResetPassword', 'La nova contrasenya ha de tenir almenys 8 caràcters, una majúscula, una minúscula i un número');
  }

  if (!empty($_SESSION['errorsResetPassword'])) {
    header('Location: ../view/auth/reset-password.view.php');
    exit();
  }

  $usuariDAO = new UsuariDAO();
  $usuari = $usuariDAO->getUsuariPerToken($token);

  if (!$usuari) {
    addMessage('errorsResetPassword', 'No s\'ha trobat cap usuari amb aquest token');
  }

  if ($usuari->getPassword() === password_hash($newPassword, PASSWORD_DEFAULT)) {
    addMessage('errorsResetPassword', 'La contrasenya nova no pot ser igual a la contrasenya antiga');
  }

  if ($usuari->getTokenRecuperacio() !== $token) {
    addMessage('errorsResetPassword', 'El token no és vàlid');
  }

  if (!empty($_SESSION['errorsResetPassword'])) {
    header('Location: ../view/auth/reset-password.view.php');
    exit();
  }

  if ($usuari->getExpiracioToken() < new DateTime('now')) {
    unset($_SESSION['errorsResetPassword']);
    addMessage('errorsCorreuRecuperacio', 'El token ha expirat, torna a sol·licitar el correu de recuperació');
    header('Location: ../view/auth/correu-recuperacio.view.php');
    exit();
  }

  $usuari->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));
  $usuari->setTokenRecuperacio(null);
  $usuari->setExpiracioToken(null);

  if ($usuariDAO->modificar($usuari)) {
    setMessage('missatgeLogin', 'Contrasenya restablerta correctament');
  } else {
    addMessage('errorsResetPassword', 'Error al restablir la contrasenya');
  }

  if (!empty($_SESSION['errorsResetPassword'])) {
    header('Location: ../view/auth/reset-password.view.php');
    exit();
  }

  header('Location: ../view/auth/login.view.php');
  exit();
}

?>