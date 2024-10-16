<? 
// Santi Onieva

$isDashboard = str_contains($_SERVER['REQUEST_URI'], 'dashboard') 
?>

<div class="llistat-articles">
  <?php foreach ($articles as $article): ?>
    <article>
      <figure>
        <img src="<?= BASE_PATH . $article->getRutaImatge() ?>" alt="<?= $article->getTitol() ?>">
        <? if ($isDashboard): ?>
          <a class="btn-delete" href="controller/article.controller.php?action=delete&id=<? echo $article->getId() ?>">
            <i class="fa-solid fa-trash-alt"></i>
          </a>
        <? endif; ?>
      </figure>
      
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