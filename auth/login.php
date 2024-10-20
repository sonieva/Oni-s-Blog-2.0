<?
// Santi Onieva

require_once '../model/Connexio.php';
require_once '../model/Usuari/UsuariDAO.php';

$_SESSION['errorsLogin'] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();

  $pdo = Connexio::getInstance()->getConnection();
  $usuariDAO = new UsuariDAO($pdo);

  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email)) {
    $_SESSION['errorsLogin'][] = 'El correu electrònic és obligatori';
  }

  if (empty($password)) {
    $_SESSION['errorsLogin'][] = 'La contrasenya és obligatòria';
  }

  if (!empty($email) && !empty($password)) {
    $usuari = $usuariDAO->getUsuariPerEmail($email);

    if ($usuari === null) {
      $_SESSION['errorsLogin'][] = 'El correu electrònic o la contrasenya són incorrectes';
    } else {
      if (password_verify($password, $usuari->getPassword())) {
        $_SESSION['usuari'] = $usuari;
        if (isset($_POST['recordar'])) setcookie('email', $email, time() + 60 * 60 * 24 * 30, '/');
        
        header('Location: ..');
        exit();
      } else {
        $_SESSION['errorsLogin'][] = 'El correu electrònic o la contrasenya són incorrectes';
      }
    }
  }

  if (!empty($_SESSION['error'])) {
    $_SESSION['dadesLogin'] = [
      'email' => $email,
    ];
  } 
}

header('Location: ../view/auth/login.view.php');
exit();