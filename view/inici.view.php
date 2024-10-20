<?php
// Santi Onieva

// Inclou la configuració i estableix el títol de la pàgina
include_once '../config/Config.php';
Config::setTitol('Inici');

// Inclou el capçal de la pàgina
include 'components/header.php';
?>

<div class="titol-inici">
  <h1>Articles publicats</h1>
</div>

<!-- Inclou el component que llista els articles publicats -->
<?php include 'components/llista-articles.php'; ?>
