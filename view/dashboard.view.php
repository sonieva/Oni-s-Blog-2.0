<?
// Santi Onieva

require_once '../config/Config.php';
Config::setTitol('Dashboard');

require_once '../config/utils.php';

session_start();

if (!isset($_SESSION['usuari'])) {
  header('Location: ..');
}

include 'components/header.php';

$llistatBenvingudes = [
  'Hola', 
  'Bon' . getHoraDelDia(), 
  'Benvingut/da',
  'Benvingut/da de nou',
  'Feliç ' . getDiaSetmana(), 
  'Hola de nou', 
];

$editMode = ($_SESSION['editMode']) ?? false;
?>

  <? if (isset($_SESSION['missatgeDashboard'])): ?>
    <div id="toaster" class="toaster toaster-success"><?= $_SESSION['missatgeDashboard'] ?></div>
    <? unset($_SESSION['missatgeDashboard']); ?>
  <? endif; ?>

  <? if (isset($_SESSION['errorDashboard'])): ?>
    <div id="toaster" class="toaster toaster-error"><?= $_SESSION['errorDashboard'] ?></div>
    <? unset($_SESSION['errorDashboard']); ?>
  <? endif; ?>

<div class="dashboard">
  <h1 class="benvinguda"><?= $llistatBenvingudes[array_rand($llistatBenvingudes)] . ', ' . ($_SESSION['usuari']->getNomComplet() ?? $_SESSION['usuari']->getAlies()) ?></h1>
  
  <div class="afegir-article <? if ($editMode) echo 'show' ?>" id="afegir-article">
    <hr>

    <h2>
      <? echo ($editMode) ? 'Editar' : 'Afegir'; ?> article
      <? if (!$editMode): ?>
        <button class="btn-cancel" id="btn-cancel">
          <i class="fa-solid fa-times"></i>
          Cancel·lar
        </button>
      <? endif; ?>
    </h2>
  
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
  
        <form action="controller/article.controller.php?action=<?= ($editMode) ? 'update&id='. $_SESSION['articleUpdate']['id'] : 'add&autor='. $_SESSION['usuari']->getId() ?>" method="POST" id="form-afegir" enctype="multipart/form-data">
    
          <label for="titol">Títol</label>
          <input type="text" name="titol" id="titolArticle" required value="<? if (isset($_SESSION['articleUpdate'])) echo $_SESSION['articleUpdate']['titol'] ?>">
    
          <label for="cos">Cos</label>
          <textarea name="cos" rows="10" id="cosArticle" required><? if (isset($_SESSION['articleUpdate'])) echo $_SESSION['articleUpdate']['cos'] ?></textarea>
    
          <label for="imatge">Imatge</label>
          <div class="imatge">
            <button type="button" class="btn-imatge" id="btn-imatge">Examinar</button>
            <p id="nom-imatge"><? if (isset($_SESSION['articleUpdate'])) echo substr($_SESSION['articleUpdate']['imatge'],9) ?></p>
          </div>
          <input type="file" name="imatge" id="imatge-input" <? if (!$editMode) echo 'required' ?>>
    
          <button type="submit"><?= ($editMode) ? 'Modificar' : 'Afegir' ?></button>
        </form>
      </div>
    
      <div class="vista-previa">
        <article>
  
          <figure>
            <img src="<?= ($editMode && isset($_SESSION['articleUpdate'])) ? substr($_SESSION['articleUpdate']['imatge'],1) : BASE_PATH . '/assets/images/placeholder.png' ?>" alt="Imatge no disponible" id="imatge-preview"/>
          </figure>
  
          <div class="article-body" id="article-body">
            <h2 id="titol-preview"><?= ($editMode && isset($_SESSION['articleUpdate'])) ? $_SESSION['articleUpdate']['titol'] : 'Títol de l\'article' ?></h2>
            <p id="cos-preview">
              <?  if ($editMode && isset($_SESSION['articleUpdate'])) {
                    if (strlen($_SESSION['articleUpdate']['cos']) > 100) {
                        substr($_SESSION['articleUpdate']['cos'], 0, 100) . '...';
                    } else {
                      $_SESSION['articleUpdate']['cos'];
                    }
                  } else {
                    'Cos de l\'article';
                  }
              ?>
            </p>
            <? if ($editMode && isset($_SESSION['articleUpdate']) && strlen($_SESSION['articleUpdate']['cos']) > 100): ?>
              <a class="read-more" id="continua-llegint-preview">
                Continua llegint <i class="fa-solid fa-arrow-right"></i>
              </a>
            <? endif; ?>
          </div>
  
        </article>
      </div>
      <? unset($_SESSION['articleUpdate']); ?>
    </div>
  </div>

  <hr>

  <h2>
    Els teus articles
    <button class="btn-add" id="btn-add">
      <i class="fa-solid fa-plus"></i>
      Afegir article
    </button>
  </h2>

  <? include 'components/llista-articles.php' ?>

</div>