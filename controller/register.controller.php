<?
require_once '../model/Connexio.php';
require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';

session_start();

$pdo = Connexio::getInstance()->getConnection();

$usuariDAO = new UsuariDTO($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $alies = $_POST['alies'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $nom_complet = $_POST['nom_complet'];

  if (empty($alies) || empty($email) || empty($password) || empty($nom_complet) || empty($_POST['password2'])) {
    $_SESSION['error'] = 'Has d\'omplir tots els camps';
    header('Location: ../view/register.view.php');
    exit();
  }
  
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'El correu no és vàlid';
    header('Location: ../view/register.view.php');
    exit();
  }

  if ($usuariDAO->getUsuariPerEmail($email)) {
  $_SESSION['error'] = 'Aquest correu ja està registrat';
  header('Location: ../view/register.view.php');
  exit();
  }

  if ($password !== $_POST['password2']) {
    $_SESSION['error'] = 'Les contrasenyes no coincideixen';
    header('Location: ../view/register.view.php');
    exit();
  }

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);
  $usuari = new Usuari($alies, $email, $passwordHash, $nom_complet);

  if ($usuariDAO->inserir($usuari)) {
    header('Location: ..');
    exit();
  } else {
    $_SESSION['error'] = 'Error al registrar l\'usuari';
    header('Location: ../view/register.view.php');
    exit();
  }
}

header('Location: ../view/register.view.php');
exit();
