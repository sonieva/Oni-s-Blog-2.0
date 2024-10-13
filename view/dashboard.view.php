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

  
</div>