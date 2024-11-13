<?php
// Santi Onieva

require '../vendor/autoload.php';
require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$provider = new Hybridauth\Provider\GitHub([
  'callback' => $_ENV['GITHUB_REDIRECT_URI'],
  'keys' => [
    'id' => $_ENV['GITHUB_CLIENT_ID'],
    'secret' => $_ENV['GITHUB_CLIENT_SECRET']
  ]
]);

try {
  $provider->authenticate();

  $userProfile = $provider->getUserProfile();

  $alies = $userProfile->displayName;
  $email = $userProfile->email;
  $nomComplet = ($userProfile->firstName !== null && $userProfile->lastName !== null) ? $userProfile->firstName . ' ' . $userProfile->lastName : null;
  $rutaImatge = $userProfile->photoURL;

  $usuariDAO = new UsuariDAO();
  $usuari = $usuariDAO->getUsuariPerEmail($email);

  if (!$usuari) {
    $nouUsuari = new Usuari($alies, $email, 'SocialAuth', $nomComplet, null, null, null, $rutaImatge);
    $usuariDAO->inserir($nouUsuari);

    $_SESSION['usuari'] = $usuari;
  } else {
    $_SESSION['usuari'] = $usuari;
  }

  $provider->disconnect();

  echo "
  <script>
    if (window.opener.closeAuthWindow) {
      window.opener.location.href = '/';
      window.opener.closeAuthWindow();
    }
  </script>";

} catch (Exception $e) {
  echo 'Error: ' . $e->getMessage();
  exit();
}