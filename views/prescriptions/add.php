<?php require_once __DIR__ . '/../../../partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../partials/navbar.php'; ?>
<?php require_once __DIR__ . '/../../../partials/sidebar.php'; ?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Add Prescription</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../../partials/alerts.php'; ?>
    <div class="card"><div class="card-body">
      <form method="POST" action="<?= BASE_URL ?>/index.php?page=prescriptions&action=store" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
        <input type="hidden" name="appointment_id" value="<?= $appt['id'] ?>">
        <div class="form-group">
          <label>Diagnosis</label>
          <textarea name="diagnosis" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
          <label>Medications</label>
          <textarea name="medications" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
          <label>Notes</label>
          <textarea name="notes" class="form-control" rows="2"></textarea>
        </div>
        <div class="form-group">
          <label>Prescription PDF (optional)</label>
          <input type="file" name="prescription_file" class="form-control-file" accept=".pdf">
        </div>
        <button type="submit" class="btn btn-primary">Save Prescription</button>
        <a href="<?= BASE_URL ?>/index.php?page=appointments" class="btn btn-default">Cancel</a>
      </form>
    </div></div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../../partials/footer.php'; ?>
