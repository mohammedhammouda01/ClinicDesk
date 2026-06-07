<?php
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/AppointmentModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/DoctorModel.php';
require_once __DIR__ . '/../models/PrescriptionModel.php';

class DashboardController {
    public function index(): void {
        Auth::requireRole('admin', 'doctor', 'patient');
        $role = Auth::role();
        $user = Auth::currentUser();
        $apptModel = new AppointmentModel();
        $pageTitle = 'Dashboard';

        if ($role === 'admin') {
            $userModel = new UserModel();
            $docModel  = new DoctorModel();
            $db = Database::getInstance();
            $stats['roles']   = $userModel->countAll();
            $stats['doctors'] = $docModel->countAll();
            $stats['today']   = $apptModel->countFiltered('all', 0, ['from' => date('Y-m-d'), 'to' => date('Y-m-d')]);
            $stats['recent']  = $apptModel->getAll(1, []);
            require_once __DIR__ . '/../views/dashboard/admin.php';

        } elseif ($role === 'doctor') {
            $docModel  = new DoctorModel();
            $doctor    = $docModel->findByUserId($user['id']);
            $today     = $apptModel->getTodayByDoctor($doctor['id']);
            $upcoming  = $apptModel->getByDoctor($doctor['id'], 1, []);
            $stats['total']    = $apptModel->countFiltered('doctor', $doctor['id'], []);
            $stats['pending']  = $apptModel->countFiltered('doctor', $doctor['id'], ['status' => 'pending']);
            $stats['completed']= $apptModel->countFiltered('doctor', $doctor['id'], ['status' => 'completed']);
            require_once __DIR__ . '/../views/dashboard/doctor.php';

        } else {
            $active   = $apptModel->getByPatient($user['id'], 1, ['status' => 'pending']);
            $confirmed= $apptModel->getByPatient($user['id'], 1, ['status' => 'confirmed']);
            $stats['active']    = $apptModel->countFiltered('patient', $user['id'], ['status' => 'pending']);
            $stats['completed'] = $apptModel->countFiltered('patient', $user['id'], ['status' => 'completed']);
            $prescModel = new PrescriptionModel();
            $prescriptions = $prescModel->getByPatient($user['id']);
            $stats['prescriptions'] = count($prescriptions);
            require_once __DIR__ . '/../views/dashboard/patient.php';
        }
    }
}
