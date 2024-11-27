<?php
// Santi Onieva

use chillerlan\QRCode\{QRCode, QROptions};

require_once '../vendor/autoload.php';
require_once '../utils/Logger.php';
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

try{
  $qrcode = (new QRCode)->render('https://oni.cat/article-viewer?id=' . $_GET['id']);
  
  echo json_encode([
    'qr' => $qrcode,
  ]);
} catch (Exception $e) {
  Logger::log('Error al generar el QR: ' . $e->getMessage());
  echo json_encode(['error' => $e->getMessage()]);
  exit();
}
// S'envia la informació de l'article en format JSON, desxifrant els textos per mostrar-los correctament.