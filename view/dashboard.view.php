<?
// Santi Onieva

require_once '../config/Config.php';
Config::setTitol('Dashboard');

require_once '../config/utils.php';

require_once '../model/Article/Article.php';
require_once '../model/Article/ArticleDAO.php';

include 'components/header.php';

$llistatBenvingudes = [
  'Hola', 
  'Bon' . getHoraDelDia(), 
  'Benvingut/da',
  'Benvingut/da de nou',
  'Feliç ' . getDiaSetmana(), 
  'Hola de nou', 
];

$articleDAO = new ArticleDAO();
$articles = $articleDAO->getArticlePerAutor($_SESSION['usuari']->getId());

?>

<div class="dashboard">
  <h1 class="benvinguda"><?= $llistatBenvingudes[array_rand($llistatBenvingudes)] . ', ' . ($_SESSION['usuari']->getNomComplet() ?? $_SESSION['usuari']->getAlies()) ?></h1>

  <hr>

  <h2>Afegir article</h2>

  <div class="apartats-titol">
    <h3>Camps</h3>
    <h3>Vista previa</h3>
  </div>

  <div class="apartats">
    <div class="form-afegir">

      <?php if (isset($_SESSION['errorAdd']) && !empty($_SESSION['errorAdd'])): ?>
        <div class="missatge-error">
          <ul>
            <?php foreach ($_SESSION['errorAdd'] as $error): ?>
              <li><?php echo $error ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php unset($_SESSION['errorAdd']); ?>
      <?php endif; ?>

      <form action="controller/article.controller.php?action=add&autor=<?= $_SESSION['usuari']->getId() ?>" method="POST" id="form-afegir" enctype="multipart/form-data">
  
        <label for="titol">Títol</label>
        <input type="text" name="titol" id="titolArticle" required>
  
        <label for="cos">Cos</label>
        <textarea name="cos" rows="10" id="cosArticle" required></textarea>
  
        <label for="imatge">Imatge</label>
        <div class="imatge">
          <button type="button" class="btn-imatge" id="btn-imatge">Examinar</button>
          <p id="nom-imatge"></p>
        </div>
        <input type="file" name="imatge" id="imatge-input" required>
  
        <button type="submit">Afegir</button>
      </form>
    </div>
  
    <div class="vista-previa">
      <article>

        <figure>
          <img src="<?= BASE_PATH ?>/assets/images/placeholder.png" alt="Imatge no disponible" id="imatge-preview"/>
        </figure>

        <div class="article-body" id="article-body">
          <h2 id="titol-preview">Títol de l'article</h2>
          <p id="cos-preview">Cos de l'article</p>
        </div>

      </article>
    </div>
  </div>

  <hr>

  <h2>Articles publicats per mi</h2>

  <div class="llistat-articles">
    <?php foreach ($articles as $article): ?>
      <article>
        <figure>
          <img src="<?= BASE_PATH . $article->getRutaImatge() ?>" alt="<?= $article->getTitol() ?>">
        </figure>

        <div class="article-body">
          <h2><?= $article->getTitol() ?></h2>
          <p><?= $article->getCos() ?></p>
        </div>
      </article>
    <?php endforeach; ?>
</div>