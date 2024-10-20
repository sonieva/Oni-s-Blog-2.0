<? 
// Santi Onieva

require_once '../model/Article/ArticleDAO.php';

$isDashboard = str_contains($_SERVER['REQUEST_URI'], 'dashboard');

$articlesPerPagina = isset($_COOKIE['articlesPerPagina']) ? (int)$_COOKIE['articlesPerPagina'] : 6;

$articleDAO = new ArticleDAO();
$totalArticles = $articleDAO->countArticles($isDashboard ? $_SESSION['usuari']->getId() : null);

$totalPagines = ceil($totalArticles / $articlesPerPagina);

if (!isset($_GET['pagina']) || $_GET['pagina'] < 1 || $_GET['pagina'] > $totalPagines) {
  $paginaActual = 1;
} else {
  $paginaActual = $_GET['pagina'];
}

$offset = ($paginaActual - 1) * $articlesPerPagina;

$articles = $articleDAO->getArticles($isDashboard ? $_SESSION['usuari']->getId() : null, $offset, $articlesPerPagina);

?>

<div class="pagination-control">
  <? include 'pagination-buttons.php'; ?>

  <div class="pagination-select <? if (!$isDashboard) echo 'shadow' ?>">
    <form action="controller/pagination.controller.php" method="POST" class="pagination-form">
      <label for="articlesPerPagina">Articles per pàgina:</label>
      <select name="articlesPerPagina" onchange="this.form.submit()" class="form-select">
        <?php foreach ([6, 12, 24, 48] as $cantitat): ?>
          <option value="<?= $cantitat ?>" <?= ($cantitat == $articlesPerPagina) ? 'selected' : '' ?>><?= $cantitat ?></option>
        <?php endforeach; ?>
      </select>
    </form>
  </div>
</div>

<div class="llistat-articles">
  <? if ($isDashboard && empty($articles)): ?>
    <h2 class="no-articles">Encara no has publicat cap article</h2>
  <? endif; ?>

  <?php foreach ($articles as $article): ?>
    <article>
      <figure>
        <img src="<?= BASE_PATH . $article->getRutaImatge() ?>" alt="<?= $article->getTitol() ?>">
        <? if ($isDashboard): ?>
          <a class="btn-delete" onclick="deleteArticle(<? echo $article->getId() ?>)">
            <i class="fa-solid fa-trash-alt"></i>
          </a>
          <a class="btn-edit" href="controller/article.controller.php?action=update&id=<? echo $article->getId() ?>">
            <i class="fa-solid fa-edit"></i>
          </a>
        <? endif; ?>
      </figure>

      <div class="article-info">
        <small class="article-date">Publicat <?= $article->getDataCreacio()->format('j/m/o') ?></small>
        <? if ($article->getDataModificacio()): ?>
          <small class="article-date">Modificat <?= $article->getDataModificacio()->format('j/m/o') ?></small>
        <? endif; ?>
        <? if (!$isDashboard): ?>
          <small class="article-author">Per <strong><?= $article->getAutor()->getAlies() ?></strong></small>
        <? endif; ?>
      </div>
      
      <div class="article-body">
        <h2><?= $article->getTitol() ?></h2>
        
        <p>
          <?= strlen($article->getCos()) > 100 ? rtrim(substr($article->getCos(), 0, 100)) . '...' : $article->getCos() ?>
        </p>

        <? if (strlen($article->getCos()) > 100): ?> 
          <a class="read-more" id="continua-llegint" onclick="loadArticle(<?= $article->getId() ?>)">Continua llegint <i class="fa-solid fa-arrow-right"></i></a>
        <? endif; ?>
      </div>
    </article>
  <?php endforeach; ?>
</div>

<? include 'pagination-buttons.php'; ?>

<div id="articleModal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2 class="modal-title" id="modal-title"></h2>
    <img class="modal-image" id="modal-image" src="" alt="">
    <p id="modal-body"></p>
  </div>
</div>
