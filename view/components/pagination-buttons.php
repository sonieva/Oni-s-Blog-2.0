<!-- Santi Onieva -->

<ul class="pagination-buttons <? if (!$isDashboard) echo 'shadow' ?>">
  <a class="flecha <?php if ($paginaActual == 1) echo 'disabled'; ?>" href="<?= $_SERVER['SCRIPT_NAME'] ?>?pagina=<?= $paginaActual - 1 ?>">
    <i class="fa-solid fa-chevron-left"></i>
  </a>

  <?php for ($i = 1; $i <= $totalPagines; $i++): ?>
    <li>
      <a class="numPagina <?= ($i == $paginaActual) ? 'active' : '' ?>" href="<?= $_SERVER['SCRIPT_NAME'] ?>?pagina=<?= $i ?>">
        <?= $i ?>
      </a>
    </li>
  <?php endfor; ?>

  <a class="flecha <?php if ($paginaActual == $totalPagines) echo 'disabled'; ?>" href="<?= $_SERVER['SCRIPT_NAME'] ?>?pagina=<?= $paginaActual + 1 ?>">
    <i class="fa-solid fa-chevron-right"></i>
  </a>
</ul>