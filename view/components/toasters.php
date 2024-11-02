<?php if (isset($missatge) && $missatge): ?>
  <div id="toaster" class="toaster toaster-success"><?= $missatge ?></div>
<?php endif; ?>

<?php if ($error): ?>
  <div id="toaster" class="toaster toaster-error"><?= $error ?></div>
<?php endif; ?>

<?php $inactivitat = getMessage('missatgeInactivitat'); ?>

<?php if ($inactivitat): ?>
  <div id="toaster" class="toaster toaster-info"><?= $inactivitat ?></div>
<?php endif; ?>