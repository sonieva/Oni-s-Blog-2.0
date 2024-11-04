<!-- Santi Onieva -->

<!-- Control de la paginació amb un formulari per a seleccionar la quantitat d'articles per pàgina. -->
<div class="pagination-control">
  <div class="pagination-order <?php if (!$isDashboard) echo 'shadow' ?>">
    <form action="controller/pagination.controller.php" method="POST">
      <label for="ordenar">Ordenar per</label>
      <select name="ordenaPer" onchange="this.form.submit()">
        <option value="creat-desc" <?= ($ordenaPer == 'creat-desc') ? 'selected' : '' ?>>Més recents</option>
        <option value="creat-asc" <?= ($ordenaPer == 'creat-asc') ? 'selected' : '' ?>>Més antics</option>
        <option value="titol-asc" <?= ($ordenaPer == 'titol-asc') ? 'selected' : '' ?>>Títol (A-Z)</option>
        <option value="titol-desc" <?= ($ordenaPer == 'titol-desc') ? 'selected' : '' ?>>Títol (Z-A)</option>
      </select>
    </form>
  </div>

  <ul class="pagination-buttons <?php if (!$isDashboard) echo 'shadow' ?>">
    <!-- Enllaç per a la fletxa d'anterior pàgina. Està deshabilitada si l'usuari es troba a la primera pàgina. -->
    <a class="flecha <?php if ($paginaActual == 1) echo 'disabled'; ?>" href="<?= $_SERVER['SCRIPT_NAME'] ?>?pagina=<?= $paginaActual - 1 ?>">
      <i class="fa-solid fa-chevron-left"></i>
    </a>

    <!-- Bucle per generar els números de pàgina dins de la paginació. -->
    <?php for ($i = 1; $i <= $totalPagines; $i++): ?>
      <li>
        <!-- Enllaç per a cada número de pàgina. Es marca com a "active" si és la pàgina actual. -->
        <a class="numPagina <?= ($i == $paginaActual) ? 'active' : '' ?>" href="<?= $_SERVER['SCRIPT_NAME'] ?>?pagina=<?= $i ?>">
          <?= $i ?>
        </a>
      </li>
    <?php endfor; ?>

    <!-- Enllaç per a la fletxa de següent pàgina. Està deshabilitada si l'usuari es troba a l'última pàgina. -->
    <a class="flecha <?php if ($paginaActual == $totalPagines) echo 'disabled'; ?>" href="<?= $_SERVER['SCRIPT_NAME'] ?>?pagina=<?= $paginaActual + 1 ?>">
      <i class="fa-solid fa-chevron-right"></i>
    </a>
  </ul>

  <div class="pagination-select <?php if (!$isDashboard) echo 'shadow' ?>">
    <form action="controller/pagination.controller.php" method="POST">
      <select name="articlesPerPagina" onchange="this.form.submit()">
        <?php foreach ([6, 12, 24, 48] as $cantitat): ?>
          <option value="<?= $cantitat ?>" <?= ($cantitat == $articlesPerPagina) ? 'selected' : '' ?>><?= $cantitat ?></option>
        <?php endforeach; ?>
      </select>
      <label for="articlesPerPagina">Articles per pàgina</label>
    </form>
  </div>
</div>