<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
$pageTitle = 'Appointments';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Appointments</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="card">
      <div class="card-header">
        <form method="GET" class="form-inline">
          <input type="hidden" name="page" value="appointments">
          <select name="status" class="form-control form-control-sm mr-2">
            <option value="">All Status</option>
            <?php foreach (['pending','confirmed','completed','cancelled'] as $s): ?>
            <option value="<?= $s ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
          </select>
          <input type="date" name="from" value="<?= htmlspecialchars($_GET['from'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="form-control form-control-sm mr-2">
          <input type="date" name="to" value="<?= htmlspecialchars($_GET['to'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="form-control form-control-sm mr-2">
          <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </form>
        <?php if (Auth::role() === 'patient'): ?>
        <div class="card-tools">
          <a href="<?= BASE_URL ?>/index.php?page=appointments&action=book" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Book</a>
        </div>
        <?php endif; ?>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <?php if (Auth::role() !== 'doctor'): ?><th>Patient</th><?php endif; ?>
              <?php if (Auth::role() !== 'patient'): ?><th>Doctor</th><?php endif; ?>
              <th>Date</th><th>Time</th><th>Status</th><th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($appointments as $a): ?>
            <tr>
              <?php if (Auth::role() !== 'doctor'): ?><td><?= htmlspecialchars($a['patient_name'], ENT_QUOTES, 'UTF-8') ?></td><?php endif; ?>
              <?php if (Auth::role() !== 'patient'): ?><td><?= htmlspecialchars($a['doctor_name'] ?? $a['patient_name'], ENT_QUOTES, 'UTF-8') ?></td><?php endif; ?>
              <td><?= htmlspecialchars($a['appt_date'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($a['appt_time'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><span class="badge badge-<?= $a['status'] === 'completed' ? 'success' : ($a['status'] === 'cancelled' ? 'danger' : ($a['status'] === 'confirmed' ? 'info' : 'warning')) ?>"><?= htmlspecialchars($a['status'], ENT_QUOTES, 'UTF-8') ?></span></td>
              <td>
                <a href="<?= BASE_URL ?>/index.php?page=appointments&action=view&id=<?= $a['id'] ?>" class="btn btn-xs btn-info">View</a>

                <?php if (Auth::role() === 'patient' && $a['status'] === 'pending'): ?>
                <form method="POST" action="<?= BASE_URL ?>/index.php?page=appointments&action=update_status" style="display:inline">
                  <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
                  <input type="hidden" name="id" value="<?= $a['id'] ?>">
                  <input type="hidden" name="status" value="cancelled">
                  <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Cancel?')">Cancel</button>
                </form>
                <?php endif; ?>

                <?php if (Auth::role() === 'doctor'): ?>
                  <?php if ($a['status'] === 'pending'): ?>
                  <form method="POST" action="<?= BASE_URL ?>/index.php?page=appointments&action=update_status" style="display:inline">
                    <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
                    <input type="hidden" name="id" value="<?= $a['id'] ?>">
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit" class="btn btn-xs btn-success">Confirm</button>
                  </form>
                  <form method="POST" action="<?= BASE_URL ?>/index.php?page=appointments&action=update_status" style="display:inline">
                    <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
                    <input type="hidden" name="id" value="<?= $a['id'] ?>">
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="btn btn-xs btn-danger">Cancel</button>
                  </form>
                  <?php endif; ?>
                  <?php if ($a['status'] === 'confirmed'): ?>
                  <form method="POST" action="<?= BASE_URL ?>/index.php?page=appointments&action=update_status" style="display:inline">
                    <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
                    <input type="hidden" name="id" value="<?= $a['id'] ?>">
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="btn btn-xs btn-primary">Complete</button>
                  </form>
                  <a href="<?= BASE_URL ?>/index.php?page=prescriptions&action=add&appt_id=<?= $a['id'] ?>" class="btn btn-xs btn-warning">Add Prescription</a>
                  <?php endif; ?>
                <?php endif; ?>

                <?php if (Auth::role() === 'admin'): ?>
                  <?php if ($a['status'] === 'pending'): ?>
                  <form method="POST" action="<?= BASE_URL ?>/index.php?page=appointments&action=update_status" style="display:inline">
                    <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
                    <input type="hidden" name="id" value="<?= $a['id'] ?>">
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit" class="btn btn-xs btn-success">Confirm</button>
                  </form>
                  <?php endif; ?>
                  <?php if ($a['status'] === 'confirmed'): ?>
                  <form method="POST" action="<?= BASE_URL ?>/index.php?page=appointments&action=update_status" style="display:inline">
                    <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
                    <input type="hidden" name="id" value="<?= $a['id'] ?>">
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="btn btn-xs btn-primary">Complete</button>
                  </form>
                  <?php endif; ?>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($appointments)): ?><tr><td colspan="6" class="text-center">No appointments found</td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
