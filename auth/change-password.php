<?php

require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../utils/utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $oldPassword = $_POST['antigaPassword'];
  $newPassword = $_POST['novaPassword'];
  $confirmPassword = $_POST['novaPassword2'];

  usuariEstaLogat();

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

  if(!validarContrasenya($newPassword)) {
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
    setMessage('missatgePerfil', 'Contrasenya canviada correctament');
  } else {
    addMessage('errorChangePassword', 'Error al canviar la contrasenya');
  }

  if (!empty($_SESSION['errorChangePassword'])) {
    header('Location: ../view/auth/change-password.view.php');
    exit();
  }
}

header('Location: /perfil');
exit();