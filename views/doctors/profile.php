<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../core/CSRF.php';
$pageTitle = 'My Profile';
require_once __DIR__ . '/../../views/partials/header.php';
require_once __DIR__ . '/../../views/partials/navbar.php';
require_once __DIR__ . '/../../views/partials/sidebar.php';
?>
<div class="content-wrapper">
  <div class="content-header"><div class="container-fluid"><h1 class="m-0">My Profile</h1></div></div>
  <section class="content"><div class="container-fluid">
    <?php require_once __DIR__ . '/../../views/partials/alerts.php'; ?>
    <div class="card"><div class="card-body">
      <table class="table">
        <tr><th>Name</th><td><?= htmlspecialchars($doctor['name'], ENT_QUOTES, 'UTF-8') ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($doctor['email'], ENT_QUOTES, 'UTF-8') ?></td></tr>
        <tr><th>Specialization</th><td><?= htmlspecialchars($doctor['specialization'], ENT_QUOTES, 'UTF-8') ?></td></tr>
        <tr><th>Fee</th><td>$<?= htmlspecialchars($doctor['consultation_fee'], ENT_QUOTES, 'UTF-8') ?></td></tr>
        <tr><th>Available Days</th><td><?= htmlspecialchars($doctor['available_days'], ENT_QUOTES, 'UTF-8') ?></td></tr>
        <tr><th>Bio</th><td><?= htmlspecialchars($doctor['bio'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td></tr>
      </table>
    </div></div>
  </div></section>
</div>
<?php require_once __DIR__ . '/../../views/partials/footer.php'; ?>
