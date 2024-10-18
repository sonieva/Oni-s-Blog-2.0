<?
// Santi Onieva

require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../config/utils.php';

$_SESSION['errorRegister'] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();

  $usuariDAO = new UsuariDAO();
  
  $alies = $_POST['alies'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];

  if (empty($alies) || empty($email) || empty($password) || empty($password2)) {
    $_SESSION['errorRegister'][] = 'Has d\'omplir tots els camps';
  }
  
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['errorRegister'][] = 'El correu no és vàlid';
  }

  if ($usuariDAO->getUsuariPerEmail($email)) {
    $_SESSION['errorRegister'][] = 'Aquest correu ja està registrat';
  }

  if ($password !== $password2) {
    $_SESSION['errorRegister'][] = 'Les contrasenyes no coincideixen';
  }

  if (!validarContrasenya($password)) {
    $_SESSION['errorRegister'][] = 'La contrasenya ha de tenir com a mínim 8 caràcters, una majúscula, una minúscula, un número i un caràcter especial';
  }
  
  if (!empty($_SESSION['errorRegister'])) {
    $_SESSION['dadesRegistre'] = [
      'alies' => $alies,
      'email' => $email,
    ];
    
    header('Location: ../view/auth/register.view.php');
    exit();
  }  
  else {
    unset($_SESSION['errorRegister']);
    
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $usuari = new Usuari($alies, $email, $passwordHash);

    if ($usuariDAO->inserir($usuari)) {
      $usuari = $usuariDAO->getUsuariPerEmail($email);
      $_SESSION['usuari'] = $usuari;
      header('Location: ..');
      exit();
    } else {
      $_SESSION['errorRegister'] = 'Error al registrar l\'usuari';
    }
  }
}

header('Location: ../view/auth/register.view.php');
exit();
