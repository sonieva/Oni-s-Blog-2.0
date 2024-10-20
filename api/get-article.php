<?php
// Santi Onieva

// S'importen les classes necesaries.
require_once '../config/Config.php';
require_once '../model/Article/ArticleDAO.php';

// S'estableix el tipus de contingut de la resposta com a JSON.
header('Content-Type: application/json');

// Es comprova si s'ha proporcionat un ID d'article a través del paràmetre GET.
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Si no s'ha proporcionat l'ID, s'envia un missatge d'error en format JSON i es finalitza l'execució.
    echo json_encode(['error' => 'ID d\'article no proporcionat']);
    exit();
}

// Es crea una instància de la classe ArticleDAO per obtenir l'article cprresponent a l'ID proporcionat.
$articleDAO = new ArticleDAO();
$article = $articleDAO->getArticlePerId($_GET['id']);

// Es comprova si l'article existeix.
if (!$article) {
    // Si l'article no es troba, s'envia un missatge d'error en format JSON i es finalitza l'execució.
    echo json_encode(['error' => 'Article no trobat']);
    exit();
}

// S'envia la informació de l'article en format JSON, desxifrant els textos per mostrar-los correctament.
echo json_encode([
    'titol' => htmlspecialchars_decode($article->getTitol()), // Es desxifra el títol per a mostrar-lo en format HTML.
    'cos' => htmlspecialchars_decode($article->getCos()), // Es desxifra el cos de l'article.
    'imatge' => BASE_PATH . $article->getRutaImatge() // S'afegeix la ruta completa de la imatge.
]);
