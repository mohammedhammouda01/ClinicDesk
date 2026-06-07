<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <span class="nav-link"><?= htmlspecialchars(Auth::currentUser()['name'], ENT_QUOTES, 'UTF-8') ?></span>
    </li>
    <li class="nav-item">
      <form method="POST" action="<?= BASE_URL ?>/index.php?page=logout">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">
        <button type="submit" class="nav-link btn btn-link">
          <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </form>
    </li>
  </ul>
</nav>
