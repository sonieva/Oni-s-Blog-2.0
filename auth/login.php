<?php
// Santi Onieva

// S'inclou la classe UsuariDAO per a gestionar les operacions amb usuaris
require_once '../model/Usuari/Usuari.php';
require_once '../model/Usuari/UsuariDAO.php';
require_once '../utils/utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  
  // S'obté l'email i la contrasenya del formulari
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  // Es comprova si l'email està buit i s'afegeix un error si cal
  if (empty($email)) {
    addMessage('errorsLogin', 'El correu electrònic és obligatori');
  }
  
  // Es comprova si la contrasenya està buida i s'afegeix un error si cal
  if (empty($password)) {
    addMessage('errorsLogin', 'La contrasenya és obligatòria');
  }
  
  // Si tant l'email com la contrasenya no estan buits, es continua amb la validació
  if (!empty($email) && !empty($password)) {
    $usuariDAO = new UsuariDAO();
    $usuari = $usuariDAO->getUsuariPerEmail($email);

    // Si no es troba cap usuari amb aquest email, es mostra un missatge d'error
    if ($usuari === null) {
      addMessage('errorsLogin', 'El correu electrònic o la contrasenya són incorrectes');
    } else {
      // Es verifica la contrasenya introduïda amb la contrasenya emmagatzemada
      if (password_verify($password, $usuari->getPassword())) {
        // Si la contrasenya és correcta, es guarda l'usuari a la sessió
        $_SESSION['usuari'] = $usuari;

        // Si s'ha seleccionat "recordar", es guarda una cookie amb l'email durant 30 dies
        if (isset($_POST['recordar'])) {
          setcookie('email', $email, time() + 60 * 60 * 24 * 30, '/');
          setcookie('password', $password, time() + 60 * 60 * 24 * 30, '/');
        }
        
        // Es redirigeix a la pàgina principal
        header('Location: ..');
        exit();
      } else {
        // Si la contrasenya és incorrecta, es mostra un missatge d'error
        addMessage('errorsLogin', 'El correu electrònic o la contrasenya són incorrectes');
      }
    }
  }

  // Si hi ha errors, es guarden les dades introduïdes a la sessió per a poder reutilitzar-les
  if (!empty($_SESSION['error'])) {
    $_SESSION['dadesLogin'] = [
      'email' => $email,
    ];
  } 
}

// Es redirigeix a la vista de login en cas d'error o si no es compleixen les condicions
header('Location: ../view/auth/login.view.php');
exit();
?>
