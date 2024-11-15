<?php
// Santi Onieva

require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../utils/utils.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Es recullen les dades enviades per POST
  $email = $_POST['email'];
  $password = $_POST['password'];
  $recordar = isset($_POST['recordar']);
  $recaptchaResponse = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : null;

  // Es comprova si l'email està buit i s'afegeix un error si cal
  if (empty($email)) {
    addMessage('errorsLogin', 'El correu electrònic és obligatori');
  }

  // Es comprova si la contrasenya està buida i s'afegeix un error si cal
  if (empty($password)) {
    addMessage('errorsLogin', 'La contrasenya és obligatòria');
  }

  if ($_SESSION['intentsLogin'] >= 3) {
    $recaptchaSecret = $_ENV['RECAPTCHA_SECRET_KEY'];
    
    // Realiza la petición a la API de reCAPTCHA
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
      addMessage('errorsLogin', "La verificació de reCAPTCHA ha fallat. Si us plau, intenta-ho de nou");
    }
  }

  // Si tant l'email com la contrasenya no estan buits, es continua amb la validació
  if (empty($_SESSION['errorsLogin'])) {
    $usuariDAO = new UsuariDAO();
    $usuari = $usuariDAO->getUsuariPerEmail($email);

    // Si no es troba cap usuari amb aquest email, es mostra un missatge d'error
    if ($usuari && password_verify($password, $usuari->getPassword())) {
      // Si la contrasenya és correcta, es guarda l'usuari a la sessió
      $_SESSION['usuari'] = $usuari;

      // Si s'ha seleccionat "recordar", es guarda una cookie amb l'email durant 30 dies
      if ($recordar) {
        setcookie('email', $email, time() + 60 * 60 * 24 * 30, '/');
      }

      unset($_SESSION['intentsLogin']);
      
      // Es redirigeix a la pàgina principal
      header('Location: ..');
      exit();
    } else {
      // Si la contrasenya és incorrecta, es mostra un missatge d'error
      addMessage('errorsLogin', 'El correu electrònic o la contrasenya són incorrectes');
    }
  }

  // Si hi ha errors, es guarden les dades introduïdes a la sessió per a poder reutilitzar-les
  if (!empty($_SESSION['errorsLogin'])) {
    $_SESSION['dadesLogin'] = [
      'email' => $email,
    ];
    $_SESSION['intentsLogin'] += 1;
  }
}

header('Location: ../view/auth/login.view.php');
exit();