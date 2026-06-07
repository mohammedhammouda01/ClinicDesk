<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?= BASE_URL ?>/index.php?page=dashboard" class="brand-link">
    <span class="brand-text font-weight-light"><b>Clinic</b>Desk</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

        <li class="nav-item">
          <a href="<?= BASE_URL ?>/index.php?page=dashboard" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <?php if (Auth::role() === 'admin'): ?>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/index.php?page=users" class="nav-link">
            <i class="nav-icon fas fa-users"></i><p>Users</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/index.php?page=doctors" class="nav-link">
            <i class="nav-icon fas fa-user-md"></i><p>Doctors</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/index.php?page=appointments" class="nav-link">
            <i class="nav-icon fas fa-calendar"></i><p>Appointments</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/index.php?page=reports" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i><p>Reports</p>
          </a>
        </li>
        <?php endif; ?>

        <?php if (Auth::role() === 'doctor'): ?>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/index.php?page=appointments" class="nav-link">
            <i class="nav-icon fas fa-calendar"></i><p>My Schedule</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/index.php?page=doctors&action=profile" class="nav-link">
            <i class="nav-icon fas fa-user"></i><p>My Profile</p>
          </a>
        </li>
        <?php endif; ?>

        <?php if (Auth::role() === 'patient'): ?>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/index.php?page=appointments&action=book" class="nav-link">
            <i class="nav-icon fas fa-plus"></i><p>Book Appointment</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/index.php?page=appointments" class="nav-link">
            <i class="nav-icon fas fa-calendar"></i><p>My Appointments</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/index.php?page=prescriptions" class="nav-link">
            <i class="nav-icon fas fa-file-medical"></i><p>My Prescriptions</p>
          </a>
        </li>
        <?php endif; ?>

      </ul>
    </nav>
  </div>
</aside>
