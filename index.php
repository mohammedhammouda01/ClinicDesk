<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/helpers.php';
require_once __DIR__ . '/core/Auth.php';
require_once __DIR__ . '/core/CSRF.php';

$page   = $_GET['page']   ?? 'login';
$action = $_GET['action'] ?? 'index';

switch ($page) {
    case 'login':
        require_once __DIR__ . '/controllers/AuthController.php';
        $ctrl = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ctrl->handleLogin();
        } else {
            $ctrl->showLogin();
        }
        break;

    case 'logout':
        require_once __DIR__ . '/controllers/AuthController.php';
        $ctrl = new AuthController();
        $ctrl->handleLogout();
        break;

    case 'dashboard':
        require_once __DIR__ . '/controllers/DashboardController.php';
        (new DashboardController())->index();
        break;

    case 'users':
        require_once __DIR__ . '/controllers/UserController.php';
        $ctrl = new UserController();
        match($action) {
            'create' => $ctrl->create(),
            'store'  => $ctrl->store(),
            'edit'   => $ctrl->edit(),
            'update' => $ctrl->update(),
            'toggle' => $ctrl->toggleActive(),
            default  => $ctrl->index(),
        };
        break;

    case 'doctors':
        require_once __DIR__ . '/controllers/DoctorController.php';
        $ctrl = new DoctorController();
        match($action) {
            'edit'    => $ctrl->edit(),
            'update'  => $ctrl->update(),
            'profile' => $ctrl->profile(),
            default   => $ctrl->index(),
        };
        break;

    case 'appointments':
        require_once __DIR__ . '/controllers/AppointmentController.php';
        $ctrl = new AppointmentController();
        match($action) {
            'book'          => $ctrl->book(),
            'store'         => $ctrl->store(),
            'update_status' => $ctrl->updateStatus(),
            'view'          => $ctrl->view(),
            default         => $ctrl->index(),
        };
        break;

    case 'prescriptions':
        require_once __DIR__ . '/controllers/PrescriptionController.php';
        $ctrl = new PrescriptionController();
        match($action) {
            'add'      => $ctrl->add(),
            'store'    => $ctrl->store(),
            'download' => $ctrl->download(),
            default    => $ctrl->index(),
        };
        break;

    case 'reports':
        require_once __DIR__ . '/controllers/ReportController.php';
        (new ReportController())->index();
        break;

    case 'errors':
        $code = $_GET['code'] ?? '404';
        require_once __DIR__ . '/views/errors/' . $code . '.php';
        break;

    default:
        require_once __DIR__ . '/views/errors/404.php';
        break;
}
