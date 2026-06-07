<?php
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/CSRF.php';
require_once __DIR__ . '/../models/DoctorModel.php';
require_once __DIR__ . '/../models/SpecializationModel.php';
require_once __DIR__ . '/../core/Paginator.php';

class DoctorController {
    public function index(): void {
        Auth::requireRole('admin');
        $model = new DoctorModel();
        $page  = max(1, (int)($_GET['p'] ?? 1));
        $total = $model->countAll();
        $paginator = new Paginator($total, ITEMS_PER_PAGE, $page);
        $doctors = $model->getAllPaginated($page);
        $pageTitle = 'Doctors';
        require_once __DIR__ . '/../views/doctors/index.php';
    }

    public function edit(): void {
        Auth::requireRole('admin');
        $model  = new DoctorModel();
        $doctor = $model->findById((int)$_GET['id']);
        $specs  = (new SpecializationModel())->getAll();
        $pageTitle = 'Edit Doctor';
        require_once __DIR__ . '/../views/doctors/edit.php';
    }

    public function update(): void {
        Auth::requireRole('admin');
        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            flashMessage('error', 'Invalid request.');
            redirect(BASE_URL . '/index.php?page=doctors');
        }
        $model = new DoctorModel();
        $model->update((int)$_POST['id'], [
            'specialization_id' => $_POST['specialization_id'],
            'bio'               => $_POST['bio'] ?? null,
            'consultation_fee'  => $_POST['consultation_fee'],
            'available_days'    => implode(',', $_POST['available_days'] ?? []),
        ]);
        flashMessage('success', 'Doctor updated.');
        redirect(BASE_URL . '/index.php?page=doctors');
    }

    public function profile(): void {
        Auth::requireRole('doctor');
        $model  = new DoctorModel();
        $doctor = $model->findByUserId(Auth::currentUser()['id']);
        $specs  = (new SpecializationModel())->getAll();
        $pageTitle = 'My Profile';
        require_once __DIR__ . '/../views/doctors/profile.php';
    }
}
