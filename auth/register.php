<?
require_once '../model/Connexio.php';
require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';

function validarContrasenya(string $password) {
  return strlen($password) >= 8 && preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/[0-9]/', $password) && preg_match('/[\W]/', $password);
}

$_SESSION['error'] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();

  $pdo = Connexio::getInstance()->getConnection();
  $usuariDAO = new UsuariDAO($pdo);
  
  $alies = $_POST['alies'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];

  if (empty($alies) || empty($email) || empty($password) || empty($password2)) {
    $_SESSION['error'][] = 'Has d\'omplir tots els camps';
  }
  
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'][] = 'El correu no és vàlid';
  }

  if ($usuariDAO->getUsuariPerEmail($email)) {
    $_SESSION['error'][] = 'Aquest correu ja està registrat';
  }

  if ($password !== $password2) {
    $_SESSION['error'][] = 'Les contrasenyes no coincideixen';
  }

  if (!validarContrasenya($password)) {
    $_SESSION['error'][] = 'La contrasenya ha de tenir com a mínim 8 caràcters, una majúscula, una minúscula, un número i un caràcter especial';
  }
  
  if (!empty($_SESSION['error'])) {
    $_SESSION['dadesRegistre'] = [
      'alies' => $alies,
      'email' => $email,
    ];
    
    header('Location: ../view/register.view.php');
    exit();
  }  
  else {
    unset($_SESSION['error']);
    
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $usuari = new Usuari($alies, $email, $passwordHash);

    if ($usuariDAO->inserir($usuari)) {
      header('Location: ..');
      exit();
    } else {
      $_SESSION['error'] = 'Error al registrar l\'usuari';
    }
  }
}

header('Location: ../view/register.view.php');
exit();
