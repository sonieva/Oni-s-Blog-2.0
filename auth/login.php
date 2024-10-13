<?
require_once '../model/Connexio.php';
require_once '../model/Usuari/UsuariDAO.php';

$_SESSION['error'] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();

  $pdo = Connexio::getInstance()->getConnection();
  $usuariDAO = new UsuariDAO($pdo);

  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email)) {
    $_SESSION['error'][] = 'El correu electrònic és obligatori';
  }

  if (empty($password)) {
    $_SESSION['error'][] = 'La contrasenya és obligatòria';
  }

  if (!empty($email) && !empty($password)) {
    $usuari = $usuariDAO->getUsuariPerEmail($email);

    if ($usuari === null) {
      $_SESSION['error'][] = 'El correu electrònic o la contrasenya són incorrectes';
    } else {
      if (password_verify($password, $usuari->getPassword())) {
        $_SESSION['usuari'] = $usuari->getNomComplet() ?? $usuari->getAlies();
        header('Location: ..');
        exit;
      } else {
        $_SESSION['error'][] = 'El correu electrònic o la contrasenya són incorrectes';
      }
    }
  }

  if (!empty($_SESSION['error'])) {
    $_SESSION['dadesLogin'] = [
      'email' => $email,
    ];
  } 
}

header('Location: ../view/login.view.php');
exit();