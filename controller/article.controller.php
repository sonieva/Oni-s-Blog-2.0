<?
// Santi Onieva

session_start();

require_once '../model/Article/ArticleDAO.php';
require_once '../config/utils.php';

if (isset($_GET['action'])) {
  switch ($_GET['action']) {
      case 'add':
        crearArticulo($_POST['titol'], $_POST['cos'], $_FILES['imatge']);
        break;
      case 'update':
        // Lógica para modificar un artículo
        modificarArticulo($_GET['id']);
        break;
      case 'delete':
        // Lógica para eliminar un artículo
        eliminarArticulo($_GET['id']);
        break;
  }
} else {
  header('Location: ../view/dashboard.view.php');
  exit();
}

function crearArticulo($titol, $cos, $imatge) {
  $_SESSION['errorAdd'] = [];

  if (!isset($_GET['autor']) || empty($_GET['autor'] || !is_numeric($_GET['autor']))) {
    $_SESSION['errorAdd'][] = 'No s\'ha pogut trobar l\'autor de l\'article';
  }

  if (empty($titol) || empty($cos) || empty($imatge)) {
    $_SESSION['errorAdd'][] = 'Falten camps per omplir';
  }

  validarImatge($imatge);

  if (!empty($_SESSION['errorAdd'])) {
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  unlink('../uploads/tmp/' . $_FILES['imatge']['name']);

  $article = new Article(trim($titol), trim($cos), $_GET['autor'], '/uploads/' . $_FILES['imatge']['name']);
  $articleDAO = new ArticleDAO();

  if ($articleDAO->inserir($article)) {
    $_SESSION['missatgeAdd'] = 'Article afegit correctament';
  } else {
    $_SESSION['errorAdd'] = 'No s\'ha pogut afegir l\'article';
  }

  header('Location: ../view/dashboard.view.php');
  exit();
}

function modificarArticulo($id) {
  if (!isset($id) || empty($id) || !is_numeric($id)) {
    $_SESSION['errorDashboard'] = 'No s\'ha trobat l\'article a modificar';
    header('Location: ../view/dashboard.view.php');
    exit();
  }
  
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['editMode'] = true;
    
    $articleDAO = new ArticleDAO();
    $article = $articleDAO->getArticlePerId($id);
    
    $_SESSION['articleUpdate'] = [
      'id' => $id,
      'titol' => $article->getTitol(),
      'cos' => $article->getCos(),
      'imatge' => $article->getRutaImatge()
    ];
    
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  $_SESSION['errorAdd'] = [];

  $titol = trim($_POST['titol'] ?? '');
  $cos = trim($_POST['cos'] ?? '');
  $imatge = $_FILES['imatge'] ?? null;

  if (empty($titol) || empty($cos)) {
    $_SESSION['errorAdd'][] = 'Falten camps per omplir';
  }
  
  if ($imatge && $imatge['error'] !== UPLOAD_ERR_NO_FILE) {
    validarImatge($imatge);
    unlink('../uploads/tmp/' . $imatge['name']);
  }
  
  $articleDAO = new ArticleDAO();
  $articleOld = $articleDAO->getArticlePerId($id);

  if (!empty($_SESSION['errorAdd'])) {
    $_SESSION['articleUpdate'] = [
      'id' => $id,
      'titol' => $_POST['titol'],
      'cos' => $_POST['cos'],
      'imatge' => $articleOld->getRutaImatge()
    ];
    header('Location: ../view/dashboard.view.php');
    exit();
  }


  $articleNew = $articleOld;

  $articleNew->setTitol($titol);
  $articleNew->setCos($cos);
  $articleNew->setRutaImatge(($imatge && $imatge['error'] !== UPLOAD_ERR_NO_FILE) ? '/uploads/' . $imatge['name'] : $articleOld->getRutaImatge());
  
  if ($articleDAO->modificar($articleNew)) {
    unset($_SESSION['editMode']);
    $_SESSION['missatgeDashboard'] = 'Article modificat correctament';
  } else {
    $_SESSION['errorDashboard'] = 'No s\'ha pogut modificar l\'article';
  }

  header('Location: ../view/dashboard.view.php');
  exit();
}

function eliminarArticulo($id) {
  if (!isset($id) || empty($id) || !is_numeric($id)) {
    $_SESSION['errorDashboard'] = 'No s\'ha trobat l\'article a eliminar';
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  $articleDAO = new ArticleDAO();
  $article = $articleDAO->getArticlePerId($id);

  if ($articleDAO->eliminar($id)) {
    $_SESSION['missatgeDashboard'] = 'Article eliminat correctament';
    unlink('..' . $article->getRutaImatge());
  } else {
    $_SESSION['errorDashboard'] = 'No s\'ha pogut eliminar l\'article';
  }

  header('Location: ../view/dashboard.view.php');
  exit();
}
?>