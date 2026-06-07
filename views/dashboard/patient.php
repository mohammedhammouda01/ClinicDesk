<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
$pageTitle = 'Patient Dashboard';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Patient Dashboard</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="row">
      <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
          <div class="inner"><h3><?= $stats['active'] ?></h3><p>Active Appointments</p></div>
          <div class="icon"><i class="fas fa-calendar"></i></div>
        </div>
      </div>
      <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
          <div class="inner"><h3><?= $stats['completed'] ?></h3><p>Completed</p></div>
          <div class="icon"><i class="fas fa-check"></i></div>
        </div>
      </div>
      <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
          <div class="inner"><h3><?= $stats['prescriptions'] ?></h3><p>Prescriptions</p></div>
          <div class="icon"><i class="fas fa-file-medical"></i></div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">My Upcoming Appointments</h3>
        <div class="card-tools">
          <a href="<?= BASE_URL ?>/index.php?page=appointments&action=book" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Book New</a>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped">
          <thead><tr><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr></thead>
          <tbody>
            <?php foreach ($active as $a): ?>
            <tr>
              <td><?= htmlspecialchars($a['doctor_name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($a['appt_date'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($a['appt_time'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><span class="badge badge-warning"><?= htmlspecialchars($a['status'], ENT_QUOTES, 'UTF-8') ?></span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($active)): ?><tr><td colspan="4" class="text-center">No upcoming appointments</td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
