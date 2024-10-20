<?
// Santi Onieva

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['articlesPerPagina'])) {
  $articlesPerPagina = (int)$_POST['articlesPerPagina'];
  setcookie('articlesPerPagina', $articlesPerPagina, time() + (365 * 24 * 60 * 60), '/');

  header("Location: " . $_SERVER["HTTP_REFERER"]);
  exit();
}
?>