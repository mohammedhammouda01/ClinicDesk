<?php if (!empty($_SESSION['flash'])): ?>
  <?php $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
  <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show mx-3 mt-2">
    <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8') ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
<?php endif; ?>
