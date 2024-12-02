<?php
// Santi Onieva

require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../utils/utils.php';
require_once '../utils/MailUtils.php';

// Si el mètode de la petició és POST, es recullen les dades enviades.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  if (!isset($_POST['codiVerificacio'])) {
    $alies = (isset($_POST['alies'])) ? $_POST['alies'] : null;
    $email = (isset($_POST['email'])) ? $_POST['email'] : null;
    $password = (isset($_POST['password'])) ? $_POST['password'] : null;
    $password2 = (isset($_POST['password2'])) ? $_POST['password2'] : null;

    // Es comprova si hi ha algun camp buit.
    if (empty($alies) || empty($email) || empty($password) || empty($password2)) {
      addMessage('errorsRegister', 'Has d\'omplir tots els camps');
    }
  
    // Es valida el format del correu electrònic.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      addMessage('errorsRegister', 'El correu no és vàlid');
    }
  
    // Es comprova si les contrasenyes introduïdes coincideixen.
    if ($password !== $password2) {
      addMessage('errorsRegister', 'Les contrasenyes no coincideixen');
    }
  
    // Es valida la seguretat de la contrasenya.
    if (!validarContrasenya($password)) {
      addMessage('errorsRegister', 'La contrasenya ha de tenir com a mínim 8 caràcters, una majúscula, una minúscula, un número i un caràcter especial');
    }

    $usuariDAO = new UsuariDAO();
  
    // Es comprova si ja existeix un usuari amb aquest correu.
    if ($usuariDAO->getUsuariPerAliesOEmail($email)) {
      addMessage('errorsRegister', 'Aquest correu ja està registrat');
    }

    if ($usuariDAO->getUsuariPerAliesOEmail($alies)) {
      addMessage('errorsRegister', 'Aquest nom d\'usuari ja està en ús');
    }

    // Si hi ha errors de registre, es guarden les dades introduïdes a la sessió i es redirigeix al formulari de registre.
    if (!empty($_SESSION['errorsRegister'])) {
      $_SESSION['dadesRegistre'] = [
        'alies' => $alies,
        'email' => $email,
      ];
      
      header('Location: /signup');
      exit();
    } 
    else {
      $_SESSION['usuariPerValidar'] = new Usuari($alies, $email, password_hash($password, PASSWORD_DEFAULT));
      $_SESSION['codiVerificacio'] = random_int(100000, 999999);

      MailUtils::enviarCorreuVerificacio($email, $_SESSION['codiVerificacio']);

      header('Location: /signup-verification');
      exit();
    }
  } 
  else {
    // Si s'ha introduït el codi de verificació, es comprova si coincideix amb el generat.
    if ($_POST['codiVerificacio'] != $_SESSION['codiVerificacio']) {
      addMessage('errorsVerificacioCorreu', 'El codi de verificació no és correcte');
      header('Location: /signup-verification');
      exit();
    }

    unset($_SESSION['codiVerificacio']);

    $usuari = $_SESSION['usuariPerValidar'];
    unset($_SESSION['usuariPerValidar']);
    
    $usuariDAO = new UsuariDAO();
    // S'intenta inserir el nou usuari a la base de dades.
    if ($usuariDAO->inserir($usuari)) {
      $_SESSION['usuari'] = $usuari;
      
      // Es redirigeix l'usuari a la pàgina principal.
      header('Location: /');
      exit();
    } else {
      // Si hi ha un error en la inserció, es guarda el missatge d'error.
      addMessage('errorsVerificacioCorreu', 'Error al registrar l\'usuari');
    }
  }
}

header('Location: ../signup');
exit();