<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
$pageTitle = 'Book Appointment';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Book Appointment</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="card"><div class="card-body">
      <form method="POST" action="<?= BASE_URL ?>/index.php?page=appointments&action=store">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
        <div class="form-group">
          <label>Doctor</label>
          <select name="doctor_id" class="form-control" required>
            <option value="">-- Select Doctor --</option>
            <?php foreach ($doctors as $d): ?>
            <option value="<?= $d['id'] ?>" data-days="<?= htmlspecialchars($d['available_days'], ENT_QUOTES, 'UTF-8') ?>">
              <?= htmlspecialchars($d['name'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($d['specialization'], ENT_QUOTES, 'UTF-8') ?>
            </option>
            <?php endforeach; ?>
          </select>
          <small id="availableDays" class="text-muted"></small>
        </div>
        <div class="form-group">
          <label>Date</label>
          <input type="date" name="appt_date" class="form-control" min="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="form-group">
          <label>Time Slot</label>
          <select name="appt_time" class="form-control" required>
            <?php
            $start = strtotime('09:00');
            $end   = strtotime('16:00');
            for ($t = $start; $t <= $end; $t += 1800):
            ?>
            <option value="<?= date('H:i', $t) ?>"><?= date('h:i A', $t) ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Reason</label>
          <input type="text" name="reason" class="form-control" placeholder="Brief reason for visit">
        </div>
        <button type="submit" class="btn btn-primary">Book Appointment</button>
        <a href="<?= BASE_URL ?>/index.php?page=appointments" class="btn btn-default">Cancel</a>
      </form>
    </div></div>
  </div></section>
</div>
<script>
document.querySelector('select[name="doctor_id"]').addEventListener('change', function() {
  var opt = this.options[this.selectedIndex];
  var days = opt.getAttribute('data-days') || '';
  document.getElementById('availableDays').textContent = days ? 'Available days: ' + days : '';
});
</script>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
