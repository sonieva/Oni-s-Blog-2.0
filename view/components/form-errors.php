<?php if (isset($errors) && $errors): ?>
  <div class="missatge-error">
    <ul>
      <?php foreach ($errors as $error): ?>
        <li><?= $error ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>