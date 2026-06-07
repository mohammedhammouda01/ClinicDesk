<?php
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/CSRF.php';
require_once __DIR__ . '/../models/AppointmentModel.php';
require_once __DIR__ . '/../models/DoctorModel.php';
require_once __DIR__ . '/../core/Paginator.php';

class AppointmentController {
    public function index(): void {
        Auth::requireRole('admin', 'doctor', 'patient');
        $role  = Auth::role();
        $user  = Auth::currentUser();
        $model = new AppointmentModel();
        $page  = max(1, (int)($_GET['p'] ?? 1));
        $filters = [
            'status' => $_GET['status'] ?? '',
            'from'   => $_GET['from'] ?? '',
            'to'     => $_GET['to'] ?? '',
            'doctor_id' => $_GET['doctor_id'] ?? '',
        ];
        if ($role === 'patient') {
            $appointments = $model->getByPatient($user['id'], $page, $filters);
            $total = $model->countFiltered('patient', $user['id'], $filters);
        } elseif ($role === 'doctor') {
            $docModel = new DoctorModel();
            $doctor   = $docModel->findByUserId($user['id']);
            $appointments = $model->getByDoctor($doctor['id'], $page, $filters);
            $total = $model->countFiltered('doctor', $doctor['id'], $filters);
        } else {
            $appointments = $model->getAll($page, $filters);
            $total = $model->countFiltered('all', 0, $filters);
        }
        $paginator = new Paginator($total, ITEMS_PER_PAGE, $page);
        $pageTitle = 'Appointments';
        require_once __DIR__ . '/../views/appointments/index.php';
    }

    public function book(): void {
        Auth::requireRole('patient');
        $doctors = (new DoctorModel())->getAll();
        $pageTitle = 'Book Appointment';
        require_once __DIR__ . '/../views/appointments/book.php';
    }

    public function store(): void {
        Auth::requireRole('patient');
        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            flashMessage('error', 'Invalid request.');
            redirect(BASE_URL . '/index.php?page=appointments&action=book');
        }
        $model    = new AppointmentModel();
        $doctorId = (int)$_POST['doctor_id'];
        $date     = $_POST['appt_date'];
        $time     = $_POST['appt_time'];
        if ($date < date('Y-m-d')) {
            flashMessage('error', 'Cannot book a past date.');
            redirect(BASE_URL . '/index.php?page=appointments&action=book');
        }
        if ($model->hasConflict($doctorId, $date, $time)) {
            flashMessage('error', 'This slot is already booked, please choose another time.');
            redirect(BASE_URL . '/index.php?page=appointments&action=book');
        }
        $model->book([
            'patient_id' => Auth::currentUser()['id'],
            'doctor_id'  => $doctorId,
            'appt_date'  => $date,
            'appt_time'  => $time,
            'reason'     => $_POST['reason'] ?? null,
        ]);
        flashMessage('success', 'Appointment booked successfully.');
        redirect(BASE_URL . '/index.php?page=appointments');
    }

    public function updateStatus(): void {
        Auth::requireRole('admin', 'doctor');
        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            flashMessage('error', 'Invalid request.');
            redirect(BASE_URL . '/index.php?page=appointments');
        }
        $model = new AppointmentModel();
        $model->updateStatus((int)$_POST['id'], $_POST['status'], $_POST['notes'] ?? '');
        flashMessage('success', 'Status updated.');
        redirect(BASE_URL . '/index.php?page=appointments');
    }

    public function view(): void {
        Auth::requireRole('admin', 'doctor', 'patient');
        $model = new AppointmentModel();
        $appointment = $model->findById((int)$_GET['id']);
        $pageTitle = 'Appointment Details';
        require_once __DIR__ . '/../views/appointments/view.php';
    }
}
