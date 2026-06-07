<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
$pageTitle = 'Appointment Details';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Appointment Details</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="card"><div class="card-body">
      <table class="table">
        <tr><th>Patient</th><td><?= htmlspecialchars($appointment['patient_name'], ENT_QUOTES, 'UTF-8') ?></td></tr>
        <tr><th>Doctor</th><td><?= htmlspecialchars($appointment['doctor_name'], ENT_QUOTES, 'UTF-8') ?></td></tr>
        <tr><th>Date</th><td><?= htmlspecialchars($appointment['appt_date'], ENT_QUOTES, 'UTF-8') ?></td></tr>
        <tr><th>Time</th><td><?= htmlspecialchars($appointment['appt_time'], ENT_QUOTES, 'UTF-8') ?></td></tr>
        <tr><th>Status</th><td><span class="badge badge-warning"><?= htmlspecialchars($appointment['status'], ENT_QUOTES, 'UTF-8') ?></span></td></tr>
        <tr><th>Reason</th><td><?= htmlspecialchars($appointment['reason'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td></tr>
        <tr><th>Doctor Notes</th><td><?= htmlspecialchars($appointment['doctor_notes'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td></tr>
      </table>
      <a href="<?= BASE_URL ?>/index.php?page=appointments" class="btn btn-default">Back</a>
    </div></div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
