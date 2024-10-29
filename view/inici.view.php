<?php
// Santi Onieva

// Inclou la configuració i estableix el títol de la pàgina
include_once '../config/Config.php';
Config::setTitol('Inici');

// Inclou el capçal de la pàgina
include 'components/header.php';

$error = getMessage('errorInici');
$missatge = getMessage('missatgeInici');
?>

<div class="titol-inici">
  <h1>Articles publicats</h1>
</div>

<?php if ($error): ?>
  <div id="toaster" class="toaster toaster-error"><?= $error ?></div>
<?php endif; ?>

<!-- Inclou el component que llista els articles publicats -->
<?php include 'components/llista-articles.php'; ?>
