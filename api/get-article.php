<?php
// Santi Onieva

require_once '../config/Config.php';
require_once '../model/Article/ArticleDAO.php';

header('Content-Type: application/json');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'ID d\'article no proporcionat']);
    exit();
}

$articleDAO = new ArticleDAO();
$article = $articleDAO->getArticlePerId($_GET['id']);

if (!$article) {
    echo json_encode(['error' => 'Article no trobat']);
    exit();
}

echo json_encode([
    'titol' => htmlspecialchars_decode($article->getTitol()),
    'cos' => htmlspecialchars_decode($article->getCos()),
    'imatge' => BASE_PATH . $article->getRutaImatge()
]);
