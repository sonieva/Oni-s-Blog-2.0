<?php
// Santi Onieva

// Es determina si l'usuari està a la pàgina del dashboard per mostrar els articles de l'usuari o tots.
$isDashboard = str_contains($_SERVER['REQUEST_URI'], 'dashboard');
?>

<div class="search-container">
  <div class="search-box">
    <input type="text" id="search-bar" placeholder="Busca articles..."/>
    <i class="fa fa-search search-icon"></i>
  </div>
</div>


<div class="pagination-control">
  <div class="pagination-order" <?php if (!$isDashboard) echo 'shadow' ?>>
    <label for="ordenaPer">Ordenar per:</label>
    <select id="ordenaPer">
      <option value="creat-desc">Més recents</option>
      <option value="creat-asc">Més antics</option>
      <option value="titol-asc">Títol (A-Z)</option>
      <option value="titol-desc">Títol (Z-A)</option>
    </select>
  </div>
  
  <ul class="pagination-buttons <?php if (!$isDashboard) echo 'shadow' ?>" id="pagination-container-top"></ul>
  
  <div class="pagination-select <?php if (!$isDashboard) echo 'shadow' ?>">
    <label for="articlesPerPagina">Articles per pàgina</label>
    <select id="articlesPerPagina">
    <?php foreach ([6, 12, 24, 48] as $value): ?>
      <option value="<?= $value ?>"><?= $value ?></option>
    <?php endforeach; ?>
    </select>
  </div>
</div>

<!-- Llista dels articles. -->
<div class="llistat-articles" id="articles-container"></div>

<div class="pagination-control">
  <ul class="pagination-buttons <?php if (!$isDashboard) echo 'shadow' ?>" id="pagination-container-bottom"></ul>
</div>

<!-- Modal per a mostrar el contingut complet de l'article. S'inicialitza ocult. -->
<div id="articleModal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2 class="modal-title" id="modal-title"></h2>
    <img class="modal-image" id="modal-image" src="" alt="">
    <p id="modal-body"></p>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<div id="share-article-modal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close-btn" onclick="closeQRModal()">&times;</span>
    <h2 class="modal-title">Escaneja el QR</h2>
    <img src="" alt="QR Code" id="qr-image">
  </div>
</div>