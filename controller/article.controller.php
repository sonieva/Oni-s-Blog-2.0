<?php
// Santi Onieva

require_once '../model/Usuari/Usuari.php';
require_once '../model/Article/ArticleDAO.php';
require_once '../utils/utils.php';

// Es comprova si s'ha rebut una acció a través de la URL.
if (isset($_GET['action'])) {
  // S'utilitza un switch per determinar l'acció a executar.
  switch ($_GET['action']) {
      case 'add':
        // Es crida a la funció per afegir un nou article.
        afegirArticle($_POST['titol'], $_POST['cos'], $_FILES['imatge']);
        break;
      case 'update':
        // Es crida a la funció per modificar un article existent.
        modificarArticle($_GET['id']);
        break;
      case 'delete':
        // Es crida a la funció per eliminar un article.
        eliminarArticle($_GET['id']);
        break;
  }
} else {
  // Si no es rep cap acció, es redirigeix a la vista del dashboard.
  header('Location: ../view/dashboard.view.php');
  exit();
}

// Funció per afegir un nou article.
function afegirArticle($titol, $cos, $imatge): void {
  // Es crea un array per emmagatzemar els possibles errors.
  $_SESSION['errorAdd'] = [];

  // Es comprova que l'autor existeix i és vàlid.
  if (!isset($_GET['autor']) || empty($_GET['autor'] || !is_numeric($_GET['autor']))) {
    addMessage('errorAdd', 'No s\'ha pogut trobar l\'autor de l\'article');
  }

  // Es comprova que els camps necessaris no estan buits.
  if (empty($titol) || empty($cos) || empty($imatge)) {
    addMessage('errorAdd', 'Falten camps per omplir');
  }

  // Es valida la imatge pujada.
  validarImatge($imatge);

  // Si hi ha errors, es redirigeix de nou al dashboard.
  if (!empty($_SESSION['errorAdd'])) {
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  // Esborra la imatge temporal si existeix.
  unlink('../uploads/tmp/' . $_FILES['imatge']['name']);

  // Es crea un nou objecte Article amb les dades proporcionades.
  $article = new Article(htmlspecialchars(trim($titol)), htmlspecialchars(trim($cos)), $_GET['autor'], '/uploads/' . $_FILES['imatge']['name']);
  $articleDAO = new ArticleDAO();

  // S'intenta inserir l'article i es mostra un missatge en funció del resultat.
  if ($articleDAO->inserir($article)) {
    setMessage('missatgeDashboard', 'Article afegit correctament');
  } else {
    setMessage('errorDashboard', 'No s\'ha pogut afegir l\'article');
  }

  // Es redirigeix de nou al dashboard.
  header('Location: ../view/dashboard.view.php');
  exit();
}

// Funció per modificar un article existent.
function modificarArticle($id): void {
  // Es comprova que l'ID de l'article és vàlid.
  if (!isset($id) || empty($id) || !is_numeric($id)) {
    setMessage('errorDashboard', 'No s\'ha trobat l\'article a modificar');
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  $articleDAO = new ArticleDAO();
  $article = $articleDAO->getArticlePerId($id);

  if ($article->getAutor() !== $_SESSION['usuari']->getId()) {
    setMessage('errorDashboard', 'No tens permisos per modificar aquest article');
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  // Si la petició no és de tipus POST, s'activa el mode edició.
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['editMode'] = true;
    
    $articleDAO = new ArticleDAO();
    $article = $articleDAO->getArticlePerId($id);
    
    // Es guarda la informació de l'article a modificar a la sessió.
    $_SESSION['articleUpdate'] = [
      'id' => $id,
      'titol' => $article->getTitol(),
      'cos' => $article->getCos(),
      'imatge' => $article->getRutaImatge()
    ];
    
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  // Es netegen i es comproven els camps rebuts.
  $titol = htmlspecialchars(trim($_POST['titol'])) ?? '';
  $cos = htmlspecialchars(trim($_POST['cos'])) ?? '';
  $imatge = $_FILES['imatge'] ?? null;

  // Es comprova que el títol i el cos no estiguin buits.
  if (empty($titol) || empty($cos)) {
    addMessage('errorAdd', 'Falten camps per omplir');
  }
  
  // Es valida la imatge si n'hi ha una de pujada.
  if ($imatge && $imatge['error'] !== UPLOAD_ERR_NO_FILE) {
    validarImatge($imatge);
    unlink('../uploads/tmp/' . $imatge['name']);
  }
  
  $articleDAO = new ArticleDAO();
  $articleOld = $articleDAO->getArticlePerId($id);

  // Si hi ha errors, es manté la informació a la sessió i es redirigeix.
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

  // Es crea un objecte Article amb les dades noves.
  $articleNew = $articleOld;
  $articleNew->setTitol($titol);
  $articleNew->setCos($cos);
  $articleNew->setRutaImatge(($imatge && $imatge['error'] !== UPLOAD_ERR_NO_FILE) ? '/uploads/' . $imatge['name'] : $articleOld->getRutaImatge());
  
  // S'intenta modificar l'article i es mostra un missatge en funció del resultat.
  if ($articleDAO->modificar($articleNew)) {
    unset($_SESSION['editMode']);
    setMessage('missatgeDashboard', 'Article modificat correctament');
  } else {
    addMessage('errorDashboard', 'No s\'ha pogut modificar l\'article');
  }

  // Es redirigeix de nou al dashboard.
  header('Location: ../view/dashboard.view.php');
  exit();
}

// Funció per eliminar un article.
function eliminarArticle($id): void {
  // Es comprova que l'ID de l'article és vàlid.
  if (!isset($id) || empty($id) || !is_numeric($id)) {
    setMessage('errorDashboard', 'No s\'ha trobat l\'article a eliminar');
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  $articleDAO = new ArticleDAO();
  $article = $articleDAO->getArticlePerId($id);

  if ($article->getAutor() !== $_SESSION['usuari']->getId()) {
    setMessage('errorDashboard', 'No tens permisos per eliminar aquest article');
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  // S'intenta eliminar l'article i la seva imatge, i es mostra un missatge en funció del resultat.
  if ($articleDAO->eliminar($id)) {
    setMessage('missatgeDashboard', 'Article eliminat correctament');
    unlink('..' . $article->getRutaImatge());
  } else {
    setMessage('errorDashboard', 'No s\'ha pogut eliminar l\'article');
  }

  // Es redirigeix de nou al dashboard.
  header('Location: ../view/dashboard.view.php');
  exit();
}
?>
