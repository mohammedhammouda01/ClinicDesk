<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
$pageTitle = 'Users';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">Users</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="card">
      <div class="card-header">
        <form method="GET" class="form-inline">
          <input type="hidden" name="page" value="users">
          <select name="role" class="form-control form-control-sm mr-2">
            <option value="">All Roles</option>
            <?php foreach (['admin','doctor','patient'] as $r): ?>
            <option value="<?= $r ?>" <?= ($_GET['role'] ?? '') === $r ? 'selected' : '' ?>><?= ucfirst($r) ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit" class="btn btn-sm btn-primary mr-2">Filter</button>
        </form>
        <div class="card-tools">
          <a href="<?= BASE_URL ?>/index.php?page=users&action=create" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> New User</a>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped">
          <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
              <td><?= htmlspecialchars($u['name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><span class="badge badge-info"><?= htmlspecialchars($u['role'], ENT_QUOTES, 'UTF-8') ?></span></td>
              <td><span class="badge badge-<?= $u['is_active'] ? 'success' : 'danger' ?>"><?= $u['is_active'] ? 'Active' : 'Inactive' ?></span></td>
              <td>
                <a href="<?= BASE_URL ?>/index.php?page=users&action=edit&id=<?= $u['id'] ?>" class="btn btn-xs btn-warning">Edit</a>
                <form method="POST" action="<?= BASE_URL ?>/index.php?page=users&action=toggle" style="display:inline">
                  <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
                  <input type="hidden" name="id" value="<?= $u['id'] ?>">
                  <button type="submit" class="btn btn-xs btn-<?= $u['is_active'] ? 'danger' : 'success' ?>">
                    <?= $u['is_active'] ? 'Deactivate' : 'Activate' ?>
                  </button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
