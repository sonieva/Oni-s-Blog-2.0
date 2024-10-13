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

  return $diesSetmana[date('N') - 1];
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
  <h1 class="benvinguda"><?= $llistatBenvingudes[array_rand($llistatBenvingudes)] . ', ' . $_SESSION['usuari'] ?></h1>

  <div class="apartats-titol">
    <h3>Afegir article</h3>
    <h3>Vista previa</h3>
  </div>

  <div class="form-afegir">
    <form action="" method="POST">

      <label for="titol">Títol</label>
      <input type="text" name="titol" required>

      <label for="contingut">Contingut</label>
      <textarea name="contingut" rows="10" required></textarea>

      <label for="imatge">Imatge</label>
      <div class="imatge">
        <button type="button" class="btn-imatge" id="btn-imatge">Examinar</button>
        <p id="nom-imatge"></p>
      </div>
      <input type="file" name="imatge" id="imatge-input" required>

      <button type="submit">Afegir</button>
    </form>
  </div>
</div>