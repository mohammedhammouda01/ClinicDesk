<?php require_once __DIR__ . '/../../../partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../partials/navbar.php'; ?>
<?php require_once __DIR__ . '/../../../partials/sidebar.php'; ?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Edit Doctor</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../../partials/alerts.php'; ?>
    <div class="card"><div class="card-body">
      <form method="POST" action="<?= BASE_URL ?>/index.php?page=doctors&action=update">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
        <input type="hidden" name="id" value="<?= $doctor['id'] ?>">
        <div class="form-group">
          <label>Specialization</label>
          <select name="specialization_id" class="form-control">
            <?php foreach ($specs as $s): ?>
            <option value="<?= $s['id'] ?>" <?= $s['id'] == $doctor['specialization_id'] ? 'selected' : '' ?>><?= htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Consultation Fee</label>
          <input type="number" name="consultation_fee" class="form-control" step="0.01" value="<?= $doctor['consultation_fee'] ?>">
        </div>
        <div class="form-group">
          <label>Available Days</label><br>
          <?php $activeDays = explode(',', $doctor['available_days']); ?>
          <?php foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day): ?>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="available_days[]" value="<?= $day ?>" <?= in_array($day, $activeDays) ? 'checked' : '' ?>>
            <label class="form-check-label"><?= $day ?></label>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="form-group">
          <label>Bio</label>
          <textarea name="bio" class="form-control" rows="3"><?= htmlspecialchars($doctor['bio'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= BASE_URL ?>/index.php?page=doctors" class="btn btn-default">Cancel</a>
      </form>
    </div></div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../../partials/footer.php'; ?>
