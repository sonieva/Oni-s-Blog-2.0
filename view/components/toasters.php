<?php if (isset($missatge) && $missatge): ?>
  <div id="toaster" class="toaster toaster-success"><?= $missatge ?></div>
<?php endif; ?>

<?php if (isset($error) && $error): ?>
  <div id="toaster" class="toaster toaster-error"><?= $error ?></div>
<?php endif; ?>

<?php $inactiviat = getMessage('missatgeInactivitat'); ?>

<?php if (isset($inactiviat) && $inactivitat): ?>
  <div id="toaster" class="toaster toaster-info"><?= $inactivitat ?></div>
<?php endif; ?>