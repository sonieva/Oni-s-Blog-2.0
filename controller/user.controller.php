<?php
// Santi Onieva

require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../utils/utils.php';
require_once '../config/Config.php';

if (isset($_GET['action']) && ($_SERVER['REQUEST_METHOD'] === 'POST' || $_GET['action'] === 'logout')) {
  // S'utilitza un switch per determinar l'acció a executar.
  switch ($_GET['action']) {
    case 'login':
      login($_POST['email'], $_POST['password'], isset($_POST['recordar']));
      break;
    case 'logout':
      logout();
      break;
    case 'register':
      register($_POST['alies'], $_POST['email'], $_POST['password'], $_POST['password2']);
      break;
    case 'change_password':
      canviarPassword($_POST['antigaPassword'], $_POST['novaPassword'], $_POST['novaPassword2']);
      break;
    case 'reset_password_mail':
      enviarCorreuRecuperacio($_POST['correuRecuperacio']);
      break;
    case 'reset_password':
      resetPassword($_POST['token'], $_POST['novaPassword'], $_POST['novaPassword2']);
      break;
  }
} else {
  // TODO: Redirigir a error 401
  header('Location: ../view/perfil.view.php');
  exit();
}

function login($email, $password, $recordar) {
  // Es comprova si l'email està buit i s'afegeix un error si cal
  if (empty($email)) {
    addMessage('errorsLogin', 'El correu electrònic és obligatori');
  }
  
  // Es comprova si la contrasenya està buida i s'afegeix un error si cal
  if (empty($password)) {
    addMessage('errorsLogin', 'La contrasenya és obligatòria');
  }
  
  // Si tant l'email com la contrasenya no estan buits, es continua amb la validació
  if (!empty($email) && !empty($password)) {
    $usuariDAO = new UsuariDAO();
    $usuari = $usuariDAO->getUsuariPerEmail($email);

    // Si no es troba cap usuari amb aquest email, es mostra un missatge d'error
    if ($usuari === null) {
      addMessage('errorsLogin', 'El correu electrònic o la contrasenya són incorrectes');
    } else {
      // Es verifica la contrasenya introduïda amb la contrasenya emmagatzemada
      if (password_verify($password, $usuari->getPassword())) {
        // Si la contrasenya és correcta, es guarda l'usuari a la sessió
        $_SESSION['usuari'] = $usuari;

        // Si s'ha seleccionat "recordar", es guarda una cookie amb l'email durant 30 dies
        if ($recordar) {
          setcookie('email', $email, time() + 60 * 60 * 24 * 30, '/');
          setcookie('password', $password, time() + 60 * 60 * 24 * 30, '/');
        }
        
        // Es redirigeix a la pàgina principal
        header('Location: ..');
        exit();
      } else {
        // Si la contrasenya és incorrecta, es mostra un missatge d'error
        addMessage('errorsLogin', 'El correu electrònic o la contrasenya són incorrectes');
      }
    }
  }

  // Si hi ha errors, es guarden les dades introduïdes a la sessió per a poder reutilitzar-les
  if (!empty($_SESSION['errorsLogin'])) {
    $_SESSION['dadesLogin'] = [
      'email' => $email,
    ];
  }

  header('Location: ../view/auth/login.view.php');
  exit();
}

function logout() {
  // S'eliminen totes les variables de sessió.
  session_unset();

  // Es destrueix la sessió actual, eliminant totes les dades de sessió.
  session_destroy();

  // Es redirigeix l'usuari a la pàgina principal després de tancar la sessió.
  header('Location: ..');
  exit();
}

function register($alies, $email, $password, $password2) {
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
    
    header('Location: ../view/auth/register.view.php');
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
      header('Location: ..');
      exit();
    } else {
      // Si hi ha un error en la inserció, es guarda el missatge d'error.
      addMessage('errorsRegister', 'Error al registrar l\'usuari');
    }
  }

  header('Location: ../view/auth/register.view.php');
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