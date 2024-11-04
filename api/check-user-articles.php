<?php
// Santi Onieva

// S'importen les classes necesaries.
require_once '../model/Article/ArticleDAO.php';
require_once '../model/Usuari/UsuariDAO.php';

// S'estableix el tipus de contingut de la resposta com a JSON.
header('Content-Type: application/json');

// Es comprova si s'ha proporcionat un ID d'usuari a través del paràmetre GET.
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Si no s'ha proporcionat l'ID, s'envia un missatge d'error en format JSON i es finalitza l'execució.
    echo json_encode(['error' => 'ID d\'usuari no proporcionat']);
    exit();
}

// Es crea una instància de la classe ArticleDAO per obtenir els articles de l'usuari corresponent a l'ID proporcionat.
$usuariDAO = new UsuariDAO();

if ($usuariDAO->getUsuariPerId($_GET['id']) === null) {
  echo json_encode(['error' => 'ID d\'usuari no vàlid']);
  exit();
}

$articleDAO = new ArticleDAO();
$articles = $articleDAO->getAllArticles($_GET['id']);

if (count($articles) === 0) {
  echo json_encode(['teArticles' => 0]);
  exit();
} else {
  echo json_encode(['teArticles' => 1]);
  exit();
}
?>

