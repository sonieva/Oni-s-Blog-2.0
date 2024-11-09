<?php
// Santi Onieva

// Configura la zona horària i el local de la pàgina per a la zona horària de Madrid i el català
ini_set('date.timezone', 'Europe/Madrid');
date_default_timezone_set('Europe/Madrid');
setlocale(LC_ALL, 'ca_ES.UTF-8');

// Inclou la configuració i estableix el títol de la pàgina
include_once 'config/Config.php';
Config::setTitol('Inici');
Config::setArchiusCSS(['llista-articles', 'article', 'modal']);
Config::setArchiusJS(['modal']);

// Inclou el capçal de la pàgina
include 'view/components/header.php';

$error = getMessage('errorInici');
$missatge = getMessage('missatgeInici');

include_once 'view/components/toasters.php';
?>

<div class="titol-inici">
  <h1>Articles publicats</h1>
</div>

<!-- Inclou el component que llista els articles publicats -->
<?php include 'view/components/llista-articles.php'; ?>

<!-- // Redirigeix l'usuari a la vista d'inici
header("Location: view/inici.view.php"); -->
