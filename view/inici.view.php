<? 
// Santi Onieva

include_once '../config/Config.php';
Config::setTitol('Inici');

require_once '../model/Article/Article.php';
require_once '../model/Article/ArticleDAO.php';

include 'components/header.php';

$articleDAO = new ArticleDAO();
$articles = $articleDAO->getArticles();
?>

<div class="articles">
  <h1>Articles publicats</h1>
</div>

<? include 'components/llista-articles.php' ?>