<?php
// Santi Onieva

require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../config/utils.php';

session_start();

if (isset($_GET['action'])) {
  // S'utilitza un switch per determinar l'acció a executar.
  switch ($_GET['action']) {
      case 'change_password':
        canviarPassword($_POST['antigaPassword'], $_POST['novaPassword'], $_POST['novaPassword2']);
        break;
      case 'update':
        
        break;
      case 'delete':
        
        break;
  }
} else {
  header('Location: ../view/perfil.view.php');
  exit();
}

function canviarPassword($oldPassword, $newPassword, $confirmPassword): void {
  // Es crea un array per emmagatzemar els possibles errors.
  $_SESSION['errorChangePassword'] = [];

  // Es comprova que l'usuari està identificat.
  if (!isset($_SESSION['usuari'])) {
    setMessage('errorInici', 'No estàs identificat');
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
    setMessage('successChangePassword', 'Contrasenya canviada correctament');
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

?>