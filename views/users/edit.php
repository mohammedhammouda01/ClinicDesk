<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
require_once __DIR__ . '/../../models/UserModel.php';
$pageTitle = 'Edit User';
$model = new UserModel();
$user = $model->findById((int)$_GET['id']);
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Edit User</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="card"><div class="card-body">
      <form method="POST" action="<?= BASE_URL ?>/index.php?page=users&action=update">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="form-group">
          <label>Phone</label>
          <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= BASE_URL ?>/index.php?page=users" class="btn btn-default">Cancel</a>
      </form>
    </div></div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
