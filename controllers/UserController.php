<?php
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/CSRF.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/DoctorModel.php';
require_once __DIR__ . '/../models/SpecializationModel.php';
require_once __DIR__ . '/../core/Paginator.php';

class UserController {
    public function index(): void {
        Auth::requireRole('admin');
        $model = new UserModel();
        $role  = $_GET['role'] ?? '';
        $page  = max(1, (int)($_GET['p'] ?? 1));
        $total = $model->countAll($role);
        $paginator = new Paginator($total, ITEMS_PER_PAGE, $page);
        $users = $model->getAllPaginated($page, $role);
        $pageTitle = 'Users';
        require_once __DIR__ . '/../views/users/index.php';
    }

    public function create(): void {
        Auth::requireRole('admin');
        $specs = (new SpecializationModel())->getAll();
        $pageTitle = 'Create User';
        require_once __DIR__ . '/../views/users/create.php';
    }

    public function store(): void {
        Auth::requireRole('admin');
        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            flashMessage('error', 'Invalid request.');
            redirect(BASE_URL . '/index.php?page=users');
        }
        $model = new UserModel();
        $hash  = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $id    = $model->create([
            'name'     => $_POST['name'],
            'email'    => $_POST['email'],
            'password' => $hash,
            'role'     => $_POST['role'],
            'phone'    => $_POST['phone'] ?? null,
        ]);
        if ($_POST['role'] === 'doctor') {
            $docModel = new DoctorModel();
            $docModel->create([
                'user_id'          => $id,
                'specialization_id'=> $_POST['specialization_id'],
                'bio'              => $_POST['bio'] ?? null,
                'consultation_fee' => $_POST['consultation_fee'] ?? 0,
                'available_days'   => implode(',', $_POST['available_days'] ?? ['Sun','Mon','Tue','Wed','Thu']),
            ]);
        }
        flashMessage('success', 'User created successfully.');
        redirect(BASE_URL . '/index.php?page=users');
    }

    public function edit(): void {
        Auth::requireRole('admin');
        $model = new UserModel();
        $user  = $model->findById((int)$_GET['id']);
        $pageTitle = 'Edit User';
        require_once __DIR__ . '/../views/users/edit.php';
    }

    public function update(): void {
        Auth::requireRole('admin');
        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            flashMessage('error', 'Invalid request.');
            redirect(BASE_URL . '/index.php?page=users');
        }
        $model = new UserModel();
        $model->update((int)$_POST['id'], [
            'name'  => $_POST['name'],
            'phone' => $_POST['phone'] ?? null,
            'avatar'=> null,
        ]);
        flashMessage('success', 'User updated.');
        redirect(BASE_URL . '/index.php?page=users');
    }

    public function toggleActive(): void {
        Auth::requireRole('admin');
        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            flashMessage('error', 'Invalid request.');
            redirect(BASE_URL . '/index.php?page=users');
        }
        $id = (int)$_POST['id'];
        if ($id === Auth::currentUser()['id']) {
            flashMessage('error', 'Cannot deactivate your own account.');
            redirect(BASE_URL . '/index.php?page=users');
        }
        (new UserModel())->toggleActive($id);
        flashMessage('success', 'User status updated.');
        redirect(BASE_URL . '/index.php?page=users');
    }
}
