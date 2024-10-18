<? 
// Santi Onieva

require_once '../model/Article/ArticleDAO.php';

$isDashboard = str_contains($_SERVER['REQUEST_URI'], 'dashboard');

$articleDAO = new ArticleDAO();
$articles = $articleDAO->getArticles($isDashboard ? $_SESSION['usuari']->getId() : null);

// TODO: mostrar data de publicació, darrera modificació i alies de l'autor
?>

<div class="llistat-articles">
  <? if ($isDashboard && empty($articles)): ?>
    <h2 class="no-articles">Encara no has publicat cap article</h2>
  <? endif; ?>

  <?php foreach ($articles as $article): ?>
    <article>
      <figure>
        <img src="<?= BASE_PATH . $article->getRutaImatge() ?>" alt="<?= $article->getTitol() ?>">
        <? if ($isDashboard): ?>
          <a class="btn-delete" href="controller/article.controller.php?action=delete&id=<? echo $article->getId() ?>">
            <i class="fa-solid fa-trash-alt"></i>
          </a>
          <a class="btn-edit" href="controller/article.controller.php?action=update&id=<? echo $article->getId() ?>">
            <i class="fa-solid fa-edit"></i>
          </a>
        <? endif; ?>
      </figure>

      <div class="article-info">
        <small class="article-date">Publicat el <?= $article->getDataCreacio()->format('j/m/o') ?></small>
        <small class="article-author">Per <strong><?= $article->getAutor()->getAlies() ?></strong></small>
      </div>
      
      <div class="article-body">
        <h2><?= $article->getTitol() ?></h2>
        
        <p>
          <?php
          $cos = $article->getCos();
          
          if (strlen($cos) > 100) {
            echo substr($cos, 0, 100) . '...';
          } else {
            echo $cos;
          }
          ?>
        </p>

        <? if (strlen($cos) > 100): ?> 
          <a class="read-more" id="continua-llegint">Continua llegint <i class="fa-solid fa-arrow-right"></i></a>
        <? endif; ?>
      </div>
    </article>
  <?php endforeach; ?>
</div>