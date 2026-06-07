<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
$pageTitle = 'My Prescriptions';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">My Prescriptions</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="card"><div class="card-body p-0">
      <table class="table table-striped">
        <thead><tr><th>Doctor</th><th>Date</th><th>Diagnosis</th><th>Download</th></tr></thead>
        <tbody>
          <?php foreach ($prescriptions as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p['doctor_name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($p['appt_date'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars(substr($p['diagnosis'], 0, 50), ENT_QUOTES, 'UTF-8') ?>...</td>
            <td>
              <?php if ($p['file_path']): ?>
              <a href="<?= BASE_URL ?>/index.php?page=prescriptions&action=download&id=<?= $p['appointment_id'] ?>" class="btn btn-xs btn-primary"><i class="fas fa-download"></i> PDF</a>
              <?php else: ?>
              <span class="text-muted">No file</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($prescriptions)): ?><tr><td colspan="4" class="text-center">No prescriptions found</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div></div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
