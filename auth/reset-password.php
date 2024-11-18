<?php 

require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../utils/utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $newPassword = $_POST['novaPassword'];
  $confirmPassword = $_POST['novaPassword2'];
  $token = $_POST['token'];
  
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
    addMessage('errorsRecuperacio', 'El token ha expirat, torna a sol·licitar el correu de recuperació');
    header('Location: ../view/auth/recuperacio.view.php');
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
}

header('Location: ../login');
exit();