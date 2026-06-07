<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
require_once __DIR__ . '/../../core/Database.php';
$pageTitle = 'Admin Dashboard';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Admin Dashboard</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner"><h3><?= $stats['doctors'] ?></h3><p>Doctors</p></div>
          <div class="icon"><i class="fas fa-user-md"></i></div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner"><h3><?= $stats['today'] ?></h3><p>Appointments Today</p></div>
          <div class="icon"><i class="fas fa-calendar-check"></i></div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner"><h3><?= $stats['roles'] ?></h3><p>Total Users</p></div>
          <div class="icon"><i class="fas fa-users"></i></div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><h3 class="card-title">Recent Appointments</h3></div>
      <div class="card-body p-0">
        <table class="table table-striped">
          <thead><tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Status</th></tr></thead>
          <tbody>
            <?php foreach ($stats['recent'] as $a): ?>
            <tr>
              <td><?= htmlspecialchars($a['patient_name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($a['doctor_name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($a['appt_date'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><span class="badge badge-warning"><?= htmlspecialchars($a['status'], ENT_QUOTES, 'UTF-8') ?></span></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
