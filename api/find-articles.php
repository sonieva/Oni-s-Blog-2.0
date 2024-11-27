<?php
// Santi Onieva

require_once '../model/Article/ArticleDAO.php';
require_once '../model/Usuari/Usuari.php';
require_once '../utils/Logger.php';

session_start();

$query = isset($_GET['q']) ? $_GET['q'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$articlesPerPage = isset($_GET['articlesPerPagina']) ? (int)$_GET['articlesPerPagina'] : 6;
$ordenaPer = isset($_GET['ordenaPer']) ? $_GET['ordenaPer'] : 'creat-asc';

// Verificar si estamos en el dashboard del usuario
$isDashboard = isset($_GET['isDashboard']) && $_GET['isDashboard'] === 'true' ? true : false;
$userId = $isDashboard ? $_SESSION['usuari']->getId() : null;

$articleDAO = new ArticleDAO();

try {
  $offset = ($page - 1) * $articlesPerPage;
  $articles = $articleDAO->buscarArticles($query, $offset, $articlesPerPage, $ordenaPer, $userId);
  $totalArticles = $articleDAO->countArticles($userId, $query);
  $totalPagines = ceil($totalArticles / $articlesPerPage);

  $resultats = [
    'articles' => [],
    'totalPagines' => $totalPagines,
    'numArticlesUsuari' => ($userId) ? $articleDAO->countArticles($userId, '') : null,
  ];

  foreach ($articles as $article) {
    $resultats['articles'][] = [
      'id' => $article->getId(),
      'titol' => $article->getTitol(),
      'cos' => $article->getCos(),
      'creat' => $article->getDataCreacio()->format('j/m/o'),
      'modificat' => $article->getDataModificacio() ? $article->getDataModificacio()->format('j/m/o') : null,
      'ruta_imatge' => $article->getRutaImatge(),
      'autor' => $article->getAutor()->getAlies(),
    ];
  }

  header('Content-Type: application/json');
  echo json_encode($resultats);

} catch (Exception $e) {
  Logger::log('Error en la cerca: ' . $e->getMessage());
  header('Content-Type: application/json');
  echo json_encode(['error' => 'Error en la cerca: ' . $e->getMessage()]);
}
