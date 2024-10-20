<!-- Santi Onieva -->

<ul class="pagination-buttons <? if (!$isDashboard) echo 'shadow' ?>">
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
