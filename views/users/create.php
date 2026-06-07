<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
$pageTitle = 'Create User';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Create User</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="card"><div class="card-body">
      <form method="POST" action="<?= BASE_URL ?>/index.php?page=users&action=store">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Phone</label>
          <input type="text" name="phone" class="form-control">
        </div>
        <div class="form-group">
          <label>Role</label>
          <select name="role" class="form-control" id="roleSelect" required>
            <option value="patient">Patient</option>
            <option value="doctor">Doctor</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div id="doctorFields" style="display:none">
          <div class="form-group">
            <label>Specialization</label>
            <select name="specialization_id" class="form-control">
              <?php foreach ($specs as $s): ?>
              <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8') ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Consultation Fee</label>
            <input type="number" name="consultation_fee" class="form-control" step="0.01" value="0">
          </div>
          <div class="form-group">
            <label>Available Days</label><br>
            <?php foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day): ?>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="available_days[]" value="<?= $day ?>" <?= in_array($day, ['Sun','Mon','Tue','Wed','Thu']) ? 'checked' : '' ?>>
              <label class="form-check-label"><?= $day ?></label>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="form-group">
            <label>Bio</label>
            <textarea name="bio" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="<?= BASE_URL ?>/index.php?page=users" class="btn btn-default">Cancel</a>
      </form>
    </div></div>
  </div></section>
</div>
<script>
document.getElementById('roleSelect').addEventListener('change', function() {
  document.getElementById('doctorFields').style.display = this.value === 'doctor' ? 'block' : 'none';
});
</script>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
