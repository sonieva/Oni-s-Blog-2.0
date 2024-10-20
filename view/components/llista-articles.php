<?php
// Santi Onieva

// Inclou el model per accedir als articles.
require_once '../model/Article/ArticleDAO.php';

// Es determina si l'usuari està a la pàgina del dashboard per mostrar els articles de l'usuari o tots.
$isDashboard = str_contains($_SERVER['REQUEST_URI'], 'dashboard');

// Es determina la quantitat d'articles per pàgina a partir de la cookie, si existeix; si no, es fixa per defecte en 6.
$articlesPerPagina = isset($_COOKIE['articlesPerPagina']) ? (int)$_COOKIE['articlesPerPagina'] : 6;

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
$articles = $articleDAO->getArticles($isDashboard ? $_SESSION['usuari']->getId() : null, $offset, $articlesPerPagina);
?>

<!-- Control de la paginació amb un formulari per a seleccionar la quantitat d'articles per pàgina. -->
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

<!-- Llista dels articles. -->
<div class="llistat-articles">
  <? if ($isDashboard && empty($articles)): ?>
    <!-- Si l'usuari està al dashboard i no té articles, es mostra un missatge. -->
    <h2 class="no-articles">Encara no has publicat cap article</h2>
  <? endif; ?>

  <?php foreach ($articles as $article): ?>
    <article>
      <figure>
        <!-- Es mostra la imatge de l'article. -->
        <img src="<?= BASE_PATH . $article->getRutaImatge() ?>" alt="<?= $article->getTitol() ?>">
        
        <!-- Si l'usuari està al dashboard, es mostren botons per eliminar i editar l'article. -->
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
        <!-- Es mostren les dates de publicació i modificació de l'article. -->
        <small class="article-date">Publicat <?= $article->getDataCreacio()->format('j/m/o') ?></small>
        <? if ($article->getDataModificacio()): ?>
          <small class="article-date">Modificat <?= $article->getDataModificacio()->format('j/m/o') ?></small>
        <? endif; ?>
        
        <!-- Si l'usuari no està al dashboard, es mostra l'autor de l'article. -->
        <? if (!$isDashboard): ?>
          <small class="article-author">Per <strong><?= $article->getAutor()->getAlies() ?></strong></small>
        <? endif; ?>
      </div>
      
      <div class="article-body">
        <!-- Es mostra el títol i un fragment del cos de l'article (màxim 100 caràcters). -->
        <h2><?= $article->getTitol() ?></h2>
        
        <p>
          <?= strlen($article->getCos()) > 100 ? rtrim(substr($article->getCos(), 0, 100)) . '...' : $article->getCos() ?>
        </p>

        <!-- Si el cos és més llarg de 100 caràcters, es mostra un enllaç per a llegir l'article complet. -->
        <? if (strlen($article->getCos()) > 100): ?> 
          <a class="read-more" id="continua-llegint" onclick="loadArticle(<?= $article->getId() ?>)">Continua llegint <i class="fa-solid fa-arrow-right"></i></a>
        <? endif; ?>
      </div>
    </article>
  <?php endforeach; ?>
</div>

<!-- Es tornen a incloure els botons de paginació per tenir-los també a la part inferior de la pàgina. -->
<? include 'pagination-buttons.php'; ?>

<!-- Modal per a mostrar el contingut complet de l'article. S'inicialitza ocult. -->
<div id="articleModal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2 class="modal-title" id="modal-title"></h2>
    <img class="modal-image" id="modal-image" src="" alt="">
    <p id="modal-body"></p>
  </div>
</div>
