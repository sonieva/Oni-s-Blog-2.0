<?php
// Santi Onieva

// Es requereixen els arxius necessaris per treballar amb la classe Usuari i UsuariDAO.
require_once '../model/Usuari/UsuariDAO.php';
require_once '../model/Usuari/Usuari.php';

// S'inicia la sessió per accedir a les variables de sessió.
session_start();

// Es comprova si la petició és de tipus POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // S'obté el contingut JSON de la petició.
  $data = json_decode(file_get_contents('php://input'), true);
  
  // Es comprova que existeixin les dades necessàries i que hi hagi un usuari en sessió.
  if (isset($data['nom_complet']) && isset($_SESSION['usuari'])) {
    // Es neteja l'espai en blanc del nom complet.
    $nomComplet = trim($data['nom_complet']);

    // Es crea una instància de UsuariDAO per accedir a la base de dades.
    $usuariDAO = new UsuariDAO();
    // S'obté l'usuari actual mitjançant el seu ID.
    $userOld = $usuariDAO->getUsuariPerId($_SESSION['usuari']->getId());

    // S'actualitza el nom complet de l'usuari.
    $userOld->setNomComplet($nomComplet);
    // Es guarda la modificació a la base de dades.
    $success = $usuariDAO->modificar($userOld);
    // Es guarda l'usuari actualitzat a la sessió.
    $_SESSION['usuari'] = $userOld;
  }
}
?>
