<?php
// Santi Onieva

// Es requereixen els arxius necessaris per treballar amb la classe Usuari i UsuariDAO.
require_once '../model/Usuari/UsuariDAO.php';
require_once '../model/Usuari/Usuari.php';
session_start();

// Es comprova si la petició és de tipus POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['usuari'])) {
  // S'obté el contingut JSON de la petició.
  $data = json_decode(file_get_contents('php://input'), true);
  
  // Es comprova que existeixin les dades necessàries i que hi hagi un usuari en sessió.
  if (isset($data['editant']) && $data['editant'] === 'nom_complet') {
    // Es neteja l'espai en blanc del nom complet.
    $nomComplet = trim($data['nom_complet']);

    // Es crea una instància de UsuariDAO per accedir a la base de dades.
    $usuariDAO = new UsuariDAO();
    // S'obté l'usuari actual mitjançant el seu ID.
    $userOld = $usuariDAO->getUsuariPerId($_SESSION['usuari']->getId());

    // S'actualitza el nom complet de l'usuari.
    if (!$nomComplet) {
      $userOld->setNomComplet(null);
    } else {
      $userOld->setNomComplet($nomComplet);
    }
    // Es guarda la modificació a la base de dades.
    $usuariDAO->modificar($userOld);
    // Es guarda l'usuari actualitzat a la sessió.
    $_SESSION['usuari'] = $userOld;
  }

  if (isset($_FILES['imatge']) && $_FILES['imatge']['error'] === UPLOAD_ERR_OK) {
    $imatge = $_FILES['imatge'];
    
    // Es defineixen les extensions permeses per les imatges.
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    // S'obté l'extensió de l'arxiu pujat.
    $fileExtension = strtolower(pathinfo($imatge['name'], PATHINFO_EXTENSION));

    // Es comprova si l'extensió de l'arxiu no és vàlida.
    if (!in_array($fileExtension, $allowedExtensions)) {
      setMessage('errorPerfil', 'L\'arxiu no té una extensió vàlida');
    }

    $rutaDesti = '../uploads/profiles/' . htmlspecialchars($_SESSION['usuari']->getAlies()) . '.' . $fileExtension;

    // Es mou l'arxiu pujat a la carpeta 'uploads' i es comprova si l'operació ha estat correcta.
    if (!move_uploaded_file($imatge['tmp_name'], $rutaDesti)) {
      setMessage('errorPerfil', 'No s\'ha pogut pujar la imatge al servidor');
    }

    $userOld = $_SESSION['usuari'];

    if ($userOld->getRutaImatge()) {
      unlink('../' . $userOld->getRutaImatge());
    }

    $userOld->setRutaImatge(substr($rutaDesti,3));

    $usuariDAO = new UsuariDAO();
    $usuariDAO->modificar($userOld);
    
    $_SESSION['usuari'] = $userOld;
  }

  if (isset($data['alies'])) {
    // Es neteja l'espai en blanc del nom complet.
    $alies = trim($data['alies']);

    // Es crea una instància de UsuariDAO per accedir a la base de dades.
    $usuariDAO = new UsuariDAO();
    // S'obté l'usuari actual mitjançant el seu ID.
    $userOld = $usuariDAO->getUsuariPerId($_SESSION['usuari']->getId());

    // S'actualitza el nom complet de l'usuari.
    $userOld->setAlies($alies);
    // Es guarda la modificació a la base de dades.
    $usuariDAO->modificar($userOld);
    // Es guarda l'usuari actualitzat a la sessió.
    $_SESSION['usuari'] = $userOld;
  }
}
?>
