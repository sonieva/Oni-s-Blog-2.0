<?php
// Santi Onieva

// Inclou el model per accedir als articles.
require_once  $_SERVER['DOCUMENT_ROOT'] . '/model/Article/ArticleDAO.php';

// Es determina si l'usuari està a la pàgina del dashboard per mostrar els articles de l'usuari o tots.
$isDashboard = str_contains($_SERVER['REQUEST_URI'], 'dashboard');

// Es determina la quantitat d'articles per pàgina a partir de la cookie, si existeix; si no, es fixa per defecte en 6.
$articlesPerPagina = isset($_COOKIE['articlesPerPagina']) ? (int)$_COOKIE['articlesPerPagina'] : 6;

$ordenaPer = isset($_COOKIE['ordenaPer']) ? $_COOKIE['ordenaPer'] : 'creat-desc';

// Es crea una instància de l'ArticleDAO per gestionar la interacció amb la base de dades.
$articleDAO = new ArticleDAO();
// Es calcula el total d'articles, filtrant per l'usuari si es tracta del dashboard.
$totalArticles = $articleDAO->countArticles($isDashboard ? $_SESSION['usuari']->getId() : null);

// Es calcula el nombre total de pàgines segons la quantitat d'articles per pàgina.
$totalPagines = ceil($totalArticles / $articlesPerPagina);

// Es defineix la pàgina actual. Si no es proporciona o és fora de rang, es fixa a la primera.
if (!isset($_GET['pagina']) || $_GET['pagina'] < 1 || $_GET['pagina'] > $totalPagines) {
  $paginaActual = 1;
} else {
  $paginaActual = $_GET['pagina'];
}

// Es calcula l'offset per a la consulta SQL.
$offset = ($paginaActual - 1) * $articlesPerPagina;

// Es recuperen els articles corresponents a la pàgina actual, filtrats per l'usuari si es tracta del dashboard.
$articles = $articleDAO->getArticles($isDashboard ? $_SESSION['usuari']->getId() : null, $offset, $articlesPerPagina, $ordenaPer);
?>

<?php include 'pagination-control.php'; ?>

<!-- Llista dels articles. -->
<div class="llistat-articles">
  <?php if ($isDashboard && empty($articles)): ?>
    <!-- Si l'usuari està al dashboard i no té articles, es mostra un missatge. -->
    <h2 class="no-articles">Encara no has publicat cap article</h2>
  <?php endif; ?>

  <?php foreach ($articles as $article): ?>
    <article>
      <figure>
        <!-- Es mostra la imatge de l'article. -->
        <img src="<?= BASE_PATH . $article->getRutaImatge() ?>" alt="<?= $article->getTitol() ?>">

        <!-- Si l'usuari està al dashboard, es mostren botons per eliminar i editar l'article. -->
        <?php if ($isDashboard): ?>
          <a class="btn-delete" onclick="deleteArticle(<?= $article->getId() ?>)">
            <i class="fa-solid fa-trash-alt"></i>
          </a>
          <a class="btn-edit" href="controller/article.controller.php?action=update&id=<?= $article->getId() ?>">
            <i class="fa-solid fa-edit"></i>
          </a>
        <?php endif; ?>
      </figure>

      <div class="article-info">
        <!-- Es mostren les dates de publicació i modificació de l'article. -->
        <small class="article-date">Publicat <?= $article->getDataCreacio()->format('j/m/o') ?></small>
        <?php if ($article->getDataModificacio()): ?>
          <small class="article-date">Modificat <?= $article->getDataModificacio()->format('j/m/o') ?></small>
        <?php endif; ?>

        <!-- Si l'usuari no està al dashboard, es mostra l'autor de l'article. -->
        <?php if (!$isDashboard): ?>
          <small class="article-author">Per <strong><?= $article->getAutor()->getAlies() ?></strong></small>
        <?php endif; ?>
      </div>

      <div class="article-body">
        <!-- Es mostra el títol i un fragment del cos de l'article (màxim 100 caràcters). -->
        <h2><?= $article->getTitol() ?></h2>

        <p>
          <?= strlen($article->getCos()) > 100 ? rtrim(substr(htmlspecialchars_decode($article->getCos()), 0, 100)) . '...' : $article->getCos() ?>
        </p>

        <!-- Si el cos és més llarg de 100 caràcters, es mostra un enllaç per a llegir l'article complet. -->
        <?php if (strlen($article->getCos()) > 100): ?>
          <a class="read-more" id="continua-llegint" onclick="loadArticle(<?= $article->getId() ?>)">Continua llegint <i class="fa-solid fa-arrow-right"></i></a>
        <?php endif; ?>
      </div>
    </article>
  <?php endforeach; ?>
</div>

<!-- Es tornen a incloure els botons de paginació per tenir-los també a la part inferior de la pàgina. -->
<?php include 'pagination-control.php'; ?>

<!-- Modal per a mostrar el contingut complet de l'article. S'inicialitza ocult. -->
<div id="articleModal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2 class="modal-title" id="modal-title"></h2>
    <img class="modal-image" id="modal-image" src="" alt="">
    <p id="modal-body"></p>
  </div>
</div>