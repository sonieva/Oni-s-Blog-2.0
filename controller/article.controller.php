<?
// Santi Onieva

session_start();

$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
          eliminarArticulo();
          break;
    }
  }
}

function crearArticulo($titol, $cos, $imatge) {
  global $allowedExtensions;

  $_SESSION['errorAdd'] = [];

  if (empty($titol) || empty($cos) || empty($imatge)) {
    $_SESSION['errorAdd'][] = 'Falten camps per omplir';
  }

  if (!isset($_FILES['imatge'])) {
    $_SESSION['errorAdd'][] = 'No s\'ha pujat cap imatge';
  }

  if ($_FILES['imatge']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['errorAdd'][] = 'No s\'ha pogut pujar la imatge';
  }

  $fileType = mime_content_type($_FILES['imatge']['tmp_name']);
  $fileExtension = strtolower(pathinfo($_FILES['imatge']['name'], PATHINFO_EXTENSION));
  $imageData = getimagesize($_FILES['imatge']['tmp_name']);

  if (strpos($fileType, 'image/') !== 0 && !in_array($fileExtension, $allowedExtensions) && $imageData == false) {
    $_SESSION['errorAdd'][] = 'L\'arxiu no és una imatge vàlida o no té una extensió vàlida';
  }

  $uploadDirectory = '../uploads/'; // Carpeta de destino en tu servidor
  $filename = basename($_FILES['imatge']['name']); // Obtiene el nombre del archivo original
  $destination = $uploadDirectory . $filename;

  if (!move_uploaded_file($_FILES['imatge']['tmp_name'], $destination)) {
    $_SESSION['errorAdd'][] = 'No s\'ha pogut pujar la imatge al servidor';
  }

  if (!empty($_SESSION['errorAdd'])) {
    header('Location: ../view/dashboard.view.php');
    exit();
  }

  require_once '../model/Article.php';
  require_once '../model/ArticleDAO.php';

  $article = new Article($titol, $cos, $_SESSION['usuari']->getId(), $_FILES['imatge']['name']);
  
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

function eliminarArticulo() {
  // Código para eliminar un artículo
}
?>