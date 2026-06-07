<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
$pageTitle = 'Reports';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Reports</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="card"><div class="card-body">
      <form method="GET">
        <input type="hidden" name="page" value="reports">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>From</label>
              <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($_GET['from'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>To</label>
              <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($_GET['to'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Doctor</label>
              <select name="doctor_id" class="form-control">
                <option value="">All Doctors</option>
                <?php foreach ($doctors as $d): ?>
                <option value="<?= $d['id'] ?>" <?= ($_GET['doctor_id'] ?? '') == $d['id'] ? 'selected' : '' ?>><?= htmlspecialchars($d['name'], ENT_QUOTES, 'UTF-8') ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="">All</option>
                <?php foreach (['pending','confirmed','completed','cancelled'] as $s): ?>
                <option value="<?= $s ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Generate</button>
        <?php if (!empty($results)): ?>
        <a href="?page=reports&from=<?= $_GET['from'] ?>&to=<?= $_GET['to'] ?>&export=csv" class="btn btn-success"><i class="fas fa-download"></i> Export CSV</a>
        <?php endif; ?>
      </form>
    </div></div>
    <?php if (!empty($results)): ?>
    <div class="card"><div class="card-body p-0">
      <table class="table table-striped">
        <thead><tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th><th>Reason</th></tr></thead>
        <tbody>
          <?php foreach ($results as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['patient_name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($r['doctor_name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($r['appt_date'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($r['appt_time'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><span class="badge badge-<?= $r['status'] === 'completed' ? 'success' : ($r['status'] === 'cancelled' ? 'danger' : 'warning') ?>"><?= htmlspecialchars($r['status'], ENT_QUOTES, 'UTF-8') ?></span></td>
            <td><?= htmlspecialchars($r['reason'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div></div>
    <?php endif; ?>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
