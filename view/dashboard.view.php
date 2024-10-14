<?
require_once '../config/Config.php';
Config::setTitol('Dashboard');

require_once '../model/Article/Article.php';
require_once '../model/Article/ArticleDAO.php';

include 'components/header.php';

function getHoraDelDia() {
  $hora = date('H');

  if ($hora >= 6 && $hora < 12) {
    return 'matí';
  } else if ($hora >= 12 && $hora < 20) {
    return 'a tarda';
  } else {
    return 'a nit';
  }
}

function getDiaSetmana() {
  $diesSetmana = [
    'Dilluns',
    'Dimarts',
    'Dimecres',
    'Dijous',
    'Divendres',
    'Dissabte',
    'Diumenge',
  ];

  return $diesSetmana[date('N')];
}

$llistatBenvingudes = [
  'Hola', 
  'Bon' . getHoraDelDia(), 
  'Benvingut/da',
  'Benvingut/da de nou',
  'Feliç ' . getDiaSetmana(), 
  'Hola de nou', 
];

?>

<div class="dashboard">
  <h1 class="benvinguda"><?= $llistatBenvingudes[array_rand($llistatBenvingudes)] . ', ' . $_SESSION['usuari']->getNomComplet() ??  $_SESSION['usuari']->getAlies() ?></h1>

  <hr>

  <h2>Afegir article</h2>

  <div class="apartats-titol">
    <h3>Editar article</h3>
    <h3>Vista previa</h3>
  </div>


  <div class="apartats">
    <div class="form-afegir">
      <form action="" method="POST" id="form-afegir">
  
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
</div>