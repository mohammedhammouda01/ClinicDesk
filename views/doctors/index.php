<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
$pageTitle = 'Doctors';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Doctors</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="card"><div class="card-body p-0">
      <table class="table table-striped">
        <thead><tr><th>Name</th><th>Specialization</th><th>Fee</th><th>Available Days</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($doctors as $d): ?>
          <tr>
            <td><?= htmlspecialchars($d['name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($d['specialization'], ENT_QUOTES, 'UTF-8') ?></td>
            <td>$<?= htmlspecialchars($d['consultation_fee'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($d['available_days'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><a href="<?= BASE_URL ?>/index.php?page=doctors&action=edit&id=<?= $d['id'] ?>" class="btn btn-xs btn-warning">Edit</a></td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($doctors)): ?><tr><td colspan="5" class="text-center">No doctors found</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div></div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
