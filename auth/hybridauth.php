<?php
// Santi Onieva

require '../vendor/autoload.php';
require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../utils/utils.php';
require_once '../utils/Logger.php';

if (!isset($_GET['provider']) && !isset($_GET['code']) && !isset($_GET['state'])) {
  header('Location: ../login');
  exit();
}

session_start();

if (isset($_GET['provider'])) {
  $provider = $_GET['provider'];
  $_SESSION['provider'] = $_GET['provider'];
} else {
  $provider = $_SESSION['provider'];
  unset($_SESSION['provider']);
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$hybridauth = new Hybridauth\Hybridauth([
  'callback' => $_ENV['HYBRIDAUTH_CALLBACK_URL'],
  'providers' => [
    'GitHub' => [
      'enabled' => true,
      'keys' => [
        'id' => $_ENV['GITHUB_CLIENT_ID'],
        'secret' => $_ENV['GITHUB_CLIENT_SECRET']
      ]
    ],
    'Reddit' => [
      'enabled' => true,
      'keys' => [
        'id' => $_ENV['REDDIT_CLIENT_ID'],
        'secret' => $_ENV['REDDIT_CLIENT_SECRET']
      ]
    ],
    'Discord' => [
      'enabled' => true,
      'keys' => [
        'id' => $_ENV['DISCORD_CLIENT_ID'],
        'secret' => $_ENV['DISCORD_CLIENT_SECRET']
      ]
    ]
  ]
]);

try {
  $adapter = $hybridauth->authenticate($provider);

  $userProfile = $adapter->getUserProfile();

  $alies = generarAliesAleatori();
  $email = $userProfile->email ?? 'No proporcionat';
  $nomComplet = ($userProfile->firstName !== null && $userProfile->lastName !== null) ? $userProfile->firstName . ' ' . $userProfile->lastName : null;
  $rutaImatge = descarregarImatgePerfil($userProfile->photoURL, $alies);

  $usuariDAO = new UsuariDAO();
  $usuari = $usuariDAO->getUsuariPerEmail($email);

  if (!$usuari) {
    $nouUsuari = new Usuari($alies, $email, 'SocialAuth', $nomComplet, null, null, null, $rutaImatge);
    $usuariDAO->inserir($nouUsuari);

    $_SESSION['usuari'] = $nouUsuari;
  } else {
    $_SESSION['usuari'] = $usuari;
  }

  $adapter->disconnect();
} catch (Exception $e) {
  Logger::log('Error al autenticar amb ' . $provider . ': ' . $e->getMessage(), TipusLog::ERROR_LOG, LogLevel::ERROR);
}

echo "
<script>
  if (window.opener.closeAuthWindow) {
    window.opener.location.href = '/';
    window.opener.closeAuthWindow();
  }
</script>";