<?php
// Santi Onieva

require_once '../config/Config.php';
// Estableix el títol de la pàgina a "Dashboard"
Config::setTitol('Dashboard');
Config::setArchiusCSS(['dashboard', 'forms', 'llista-articles', 'modal', 'article']);
Config::setArchiusJS(['article-preview', 'btn-imatge', 'delete-article', 'modal', 'show-add-article']);

require_once '../model/Usuari/Usuari.php';

session_start();

// Comprova si l'usuari està identificat, si no, el redirigeix a la pàgina principal
if (!isset($_SESSION['usuari'])) {
  header('Location: ..');
}

// Inclou el capçal de la pàgina
include 'components/header.php';

// Comprova si està en mode d'edició per actualitzar un article
$editMode = ($_SESSION['editMode']) ?? false;
$missatge = getMessage('missatgeDashboard');
$error = getMessage('errorDashboard');
$errors = getMessages('errorAdd');

include_once 'components/toasters.php'
?>

<div class="dashboard">
  <h1 class="benvinguda"><?= missatgeBenvinguda() . ', ' . ($_SESSION['usuari']->getNomComplet() ?? $_SESSION['usuari']->getAlies()) ?></h1>

  <div class="afegir-article <?php if ($editMode || $errors) echo 'show' ?>" id="afegir-article">
    <hr>

    <h2>
      <!-- Mostra "Editar" o "Afegir" depenent del mode d'edició -->
      <?= ($editMode) ? 'Editar' : 'Afegir'; ?> article
      <?php if (!$editMode): ?>
        <!-- Botó per cancel·lar l'acció en mode "Afegir" -->
        <button class="btn-cancel" id="btn-cancel">
          <i class="fa-solid fa-times"></i>
          Cancel·lar
        </button>
      <?php endif; ?>
    </h2>

    <div class="apartats-titol">
      <h3>Camps</h3>
      <h3>Vista previa</h3>
    </div>

    <div class="apartats">
      <div class="custom-form form-article">

        <?php include 'components/form-errors.php'; ?>

        <form action="controller/article.controller.php?action=<?= ($editMode) ? 'update&id=' . $_SESSION['articleUpdate']['id'] : 'add&autor=' . $_SESSION['usuari']->getId() ?>" method="POST" id="form-afegir" enctype="multipart/form-data">
          <label for="titol">Títol</label>
          <div class="input">
            <input type="text" name="titol" id="titolArticle" required value="<?php if (isset($_SESSION['articleUpdate'])) echo $_SESSION['articleUpdate']['titol'] ?>">
          </div>

          <label for="cos">Cos</label>
          <textarea name="cos" rows="10" id="cosArticle" required><?php if (isset($_SESSION['articleUpdate'])) echo $_SESSION['articleUpdate']['cos'] ?></textarea>

          <label for="imatge">Imatge</label>
          <div class="imatge">
            <button type="button" class="btn-imatge" id="btn-imatge">Examinar</button>
            <p id="nom-imatge"><?php if (isset($_SESSION['articleUpdate'])) echo substr($_SESSION['articleUpdate']['imatge'], 9) ?></p>
          </div>
          <input type="file" name="imatge" id="imatge-input" <?php if (!$editMode) echo 'required' ?>>

          <button type="submit"><?= ($editMode) ? 'Modificar' : 'Afegir' ?></button>
        </form>
      </div>

      <div class="vista-previa">
        <article>
          <figure>
            <img src="<?= ($editMode && isset($_SESSION['articleUpdate'])) ? substr($_SESSION['articleUpdate']['imatge'], 1) : BASE_PATH . '/assets/images/placeholder-article.png' ?>" alt="Imatge no disponible" id="imatge-preview" />
          </figure>

          <div class="article-body" id="article-body">
            <h2 id="titol-preview"><?= ($editMode && isset($_SESSION['articleUpdate'])) ? $_SESSION['articleUpdate']['titol'] : 'Títol de l\'article' ?></h2>
            <p id="cos-preview">
              <?php if ($editMode && isset($_SESSION['articleUpdate'])) {
                if (strlen($_SESSION['articleUpdate']['cos']) > 100) {
                  echo substr($_SESSION['articleUpdate']['cos'], 0, 100) . '...';
                } else {
                  echo $_SESSION['articleUpdate']['cos'];
                }
              } else {
                echo 'Cos de l\'article';
              }
              ?>
            </p>
            <?php if ($editMode && isset($_SESSION['articleUpdate']) && strlen($_SESSION['articleUpdate']['cos']) > 100): ?>
              <a class="read-more-preview" id="continua-llegint-preview">
                Continua llegint <i class="fa-solid fa-arrow-right"></i>
              </a>
            <?php endif; ?>
          </div>
        </article>
      </div>
      <?php unset($_SESSION['articleUpdate']); ?>
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

  <?php include 'components/llista-articles.php' ?>
</div>