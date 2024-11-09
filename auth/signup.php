<?php


require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../utils/utils.php';

// Si el mètode de la petició és POST, es recullen les dades enviades.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $alies = $_POST['alies'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password2 = $_POST['password2']; 

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
  if ($usuariDAO->getUsuariPerEmail($email)) {
    addMessage('errorsRegister', 'Aquest correu ja està registrat');
  }

  // Si hi ha errors de registre, es guarden les dades introduïdes a la sessió i es redirigeix al formulari de registre.
  if (!empty($_SESSION['errorsRegister'])) {
    $_SESSION['dadesRegistre'] = [
      'alies' => $alies,
      'email' => $email,
    ];
    
    header('Location: ../view/auth/signup.view.php');
    exit();
  }  
  else {
    // Es crea un hash de la contrasenya per emmagatzemar-la de manera segura.
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
    // Es crea un nou objecte Usuari amb les dades introduïdes.
    $usuari = new Usuari($alies, $email, $passwordHash);
    
    // S'intenta inserir el nou usuari a la base de dades.
    if ($usuariDAO->inserir($usuari)) {
      // Si la inserció és exitosa, es recupera l'usuari registrat i es guarda a la sessió.
      $usuari = $usuariDAO->getUsuariPerEmail($email);
      $_SESSION['usuari'] = $usuari;
      
      // Es redirigeix l'usuari a la pàgina principal.
      header('Location: /');
      exit();
    } else {
      // Si hi ha un error en la inserció, es guarda el missatge d'error.
      addMessage('errorsRegister', 'Error al registrar l\'usuari');
    }
  }
}

header('Location: ../view/auth/signup.view.php');
exit();