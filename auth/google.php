<?php
// Requerir autoload de Composer y cargar las variables de entorno
require_once '../vendor/autoload.php';
require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../utils/utils.php';
require_once '../utils/Logger.php';

use League\OAuth2\Client\Provider\Google;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

session_start();

$provider = new Google([
  'clientId'     => $_ENV['GOOGLE_CLIENT_ID'],
  'clientSecret' => $_ENV['GOOGLE_CLIENT_SECRET'],
  'redirectUri'  => $_ENV['GOOGLE_REDIRECT_URI'],
]);

if (empty($_GET['code'])) {
  $authUrl = $provider->getAuthorizationUrl();
  $_SESSION['oauth2state'] = $provider->getState();
  header('Location: ' . $authUrl);
  exit;

} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
  unset($_SESSION['oauth2state']);
  exit('Invalid state');

} else {
  $token = $provider->getAccessToken('authorization_code', [
      'code' => $_GET['code']
  ]);

  try {
    $googleUser = $provider->getResourceOwner($token);
    $googleUserData = $googleUser->toArray();

    $email = $googleUserData['email'];
    $alies = generarAliesAleatori();
    $nomComplet = $googleUserData['name'];
    $rutaImatge = descarregarImatgePerfil($googleUserData['picture'], $alies);


    $usuariDAO = new UsuariDAO();
    $usuari = $usuariDAO->getUsuariPerEmail($email);

    if (!$usuari) {
      $nouUsuari = new Usuari($alies, $email, 'SocialAuth', $nomComplet, null, null, null, $rutaImatge, false);
      $usuariDAO->inserir($nouUsuari);
      $_SESSION['usuari'] = $nouUsuari;
    } else {
      $_SESSION['usuari'] = $usuari;
    }
    
  } catch (Exception $e) {
    Logger::log('Error al autenticar amb Google: ' . $e->getMessage(), TipusLog::ERROR_LOG, LogLevel::ERROR);
  }

  header('Location: /');
  exit();
}
