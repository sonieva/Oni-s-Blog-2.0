<?php
// Requerir autoload de Composer y cargar las variables de entorno
require_once '../vendor/autoload.php';
require_once '../utils/utils.php';

use League\OAuth2\Client\Provider\Google;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

session_start();

// Crear la instancia del proveedor de Google OAuth
$provider = new Google([
  'clientId'     => $_ENV['GOOGLE_CLIENT_ID'],
  'clientSecret' => $_ENV['GOOGLE_CLIENT_SECRET'],
  'redirectUri'  => $_ENV['GOOGLE_REDIRECT_URI'],
]);

if (empty($_GET['code'])) {

  // If we don't have an authorization code then get one
  $authUrl = $provider->getAuthorizationUrl();
  $_SESSION['oauth2state'] = $provider->getState();
  header('Location: ' . $authUrl);
  exit;

} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

  // State is invalid, possible CSRF attack in progress
  unset($_SESSION['oauth2state']);
  exit('Invalid state');

} else {

  // Try to get an access token (using the authorization code grant)
  $token = $provider->getAccessToken('authorization_code', [
      'code' => $_GET['code']
  ]);

  // Optional: Now you have a token you can look up a users profile data
  try {

      // We got an access token, let's now get the owner details
      $googleUser = $provider->getResourceOwner($token);

      $googleUserData = $googleUser->toArray();

      // Obtener el correo electrónico y el nombre del usuario
      $email = $googleUserData['email'];
      $alies = generarAliesAleatori();
      $nomComplet = $googleUserData['name'];
      $rutaImatge = $googleUserData['picture']; 

      // Conexión a la base de datos
    require_once '../model/Usuari/Usuari.php';
    require_once '../model/Usuari/UsuariDAO.php';

    $usuariDAO = new UsuariDAO();
    $usuari = $usuariDAO->getUsuariPerEmail($email);

    if (!$usuari) {
        // Registrar un nuevo usuario
        $nouUsuari = new Usuari($alies, $email, 'SocialAuth', $nomComplet, null, null, null, $rutaImatge, false);
        $usuariDAO->inserir($nouUsuari);
        $_SESSION['usuari'] = $nouUsuari; // Inicia la sessió automàticament
    } else {
        // Iniciar sesión con el usuario existente
        $_SESSION['usuari'] = $usuari;
    }

    // Redirigir al perfil del usuario o a la página principal
    header('Location: /');
    exit();

  } catch (Exception $e) {

      // Failed to get user details
      exit('Something went wrong: ' . $e->getMessage());

  }
}
