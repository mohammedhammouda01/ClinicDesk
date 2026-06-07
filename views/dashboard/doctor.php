<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
$pageTitle = 'Doctor Dashboard';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Doctor Dashboard</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="row">
      <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
          <div class="inner"><h3><?= $stats['total'] ?></h3><p>Total Appointments</p></div>
          <div class="icon"><i class="fas fa-calendar"></i></div>
        </div>
      </div>
      <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
          <div class="inner"><h3><?= $stats['pending'] ?></h3><p>Pending</p></div>
          <div class="icon"><i class="fas fa-clock"></i></div>
        </div>
      </div>
      <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
          <div class="inner"><h3><?= $stats['completed'] ?></h3><p>Completed</p></div>
          <div class="icon"><i class="fas fa-check"></i></div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><h3 class="card-title">Today's Appointments</h3></div>
      <div class="card-body p-0">
        <table class="table table-striped">
          <thead><tr><th>Patient</th><th>Time</th><th>Status</th></tr></thead>
          <tbody>
            <?php foreach ($today as $a): ?>
            <tr>
              <td><?= htmlspecialchars($a['patient_name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($a['appt_time'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><span class="badge badge-warning"><?= htmlspecialchars($a['status'], ENT_QUOTES, 'UTF-8') ?></span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($today)): ?><tr><td colspan="3" class="text-center">No appointments today</td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
