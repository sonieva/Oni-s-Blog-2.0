<?
// Santi Onieva

session_start();

if (isset($_GET['action'])) {
  switch ($_GET['action']) {
      case 'add':
        crearArticulo($_POST['titol'], $_POST['cos'], $_FILES['imatge']);
        break;
      case 'update':
        // Lógica para modificar un artículo
        modificarArticulo();
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

  if (!isset($_FILES['imatge'])) {
    $_SESSION['errorAdd'][] = 'No s\'ha pujat cap imatge';
  }

  if ($_FILES['imatge']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['errorAdd'][] = 'No s\'ha pogut pujar la imatge';
  }

  $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  $fileExtension = strtolower(pathinfo($_FILES['imatge']['name'], PATHINFO_EXTENSION));

  if (!in_array($fileExtension, $allowedExtensions)) {
    $_SESSION['errorAdd'][] = 'L\'arxiu no té una extensió vàlida';
  }

  if (!move_uploaded_file($_FILES['imatge']['tmp_name'], '../uploads/' . basename($_FILES['imatge']['name']))) {
    $_SESSION['errorAdd'][] = 'No s\'ha pogut pujar la imatge al servidor';
  }

  if (!empty($_SESSION['errorAdd'])) {
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  require_once '../model/Usuari/Usuari.php';
  require_once '../model/Article/Article.php';
  require_once '../model/Article/ArticleDAO.php';

  $article = new Article($titol, $cos, $_GET['autor'], '/uploads/' . $_FILES['imatge']['name']);
  
  $articleDAO = new ArticleDAO();

  if ($articleDAO->inserir($article)) {
    $_SESSION['missatgeAdd'] = 'Article afegit correctament';
  } else {
    $_SESSION['errorAdd'] = 'No s\'ha pogut afegir l\'article';
  }

  header('Location: ../view/dashboard.view.php');
  exit();
}

function modificarArticulo() {
  // Código para modificar un artículo
}

function eliminarArticulo($id) {
  if (!isset($id) || empty($id) || !is_numeric($id)) {
    $_SESSION['errorDelete'] = 'No s\'ha trobat l\'article a eliminar';
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  require_once '../model/Article/ArticleDAO.php';

  $articleDAO = new ArticleDAO();

  if ($articleDAO->eliminar($id)) {
    $_SESSION['missatgeDelete'] = 'Article eliminat correctament';
  } else {
    $_SESSION['errorDelete'] = 'No s\'ha pogut eliminar l\'article';
  }

  header('Location: ../view/dashboard.view.php');
  exit();
}
?>