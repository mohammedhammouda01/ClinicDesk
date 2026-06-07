<?php
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/CSRF.php';
require_once __DIR__ . '/../models/PrescriptionModel.php';
require_once __DIR__ . '/../models/AppointmentModel.php';
require_once __DIR__ . '/../models/DoctorModel.php';

class PrescriptionController {
    public function add(): void {
        Auth::requireRole('doctor');
        $apptModel = new AppointmentModel();
        $appt = $apptModel->findById((int)$_GET['appt_id']);
        $docModel = new DoctorModel();
        $doctor = $docModel->findByUserId(Auth::currentUser()['id']);
        if (!$appt || $appt['doctor_record_id'] != $doctor['id'] || $appt['status'] !== 'completed') {
            flashMessage('error', 'Not allowed.');
            redirect(BASE_URL . '/index.php?page=appointments');
        }
        $pageTitle = 'Add Prescription';
        require_once __DIR__ . '/../views/prescriptions/add.php';
    }

    public function store(): void {
        Auth::requireRole('doctor');
        if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
            flashMessage('error', 'Invalid request.');
            redirect(BASE_URL . '/index.php?page=appointments');
        }
        $apptId   = (int)$_POST['appointment_id'];
        $filePath = null;
        if (!empty($_FILES['prescription_file']['name'])) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $_FILES['prescription_file']['tmp_name']);
            finfo_close($finfo);
            if ($mime !== 'application/pdf') {
                flashMessage('error', 'Only PDF files allowed.');
                redirect(BASE_URL . '/index.php?page=prescriptions&action=add&appt_id=' . $apptId);
            }
            if ($_FILES['prescription_file']['size'] > MAX_PDF_SIZE) {
                flashMessage('error', 'File too large. Max 3MB.');
                redirect(BASE_URL . '/index.php?page=prescriptions&action=add&appt_id=' . $apptId);
            }
            $filename = 'prescription_' . $apptId . '_' . time() . '.pdf';
            $dest = __DIR__ . '/../public/uploads/prescriptions/' . $filename;
            move_uploaded_file($_FILES['prescription_file']['tmp_name'], $dest);
            $filePath = $filename;
        }
        $model = new PrescriptionModel();
        $model->create([
            'appointment_id' => $apptId,
            'diagnosis'      => $_POST['diagnosis'],
            'medications'    => $_POST['medications'],
            'notes'          => $_POST['notes'] ?? null,
            'file_path'      => $filePath,
        ]);
        flashMessage('success', 'Prescription added.');
        redirect(BASE_URL . '/index.php?page=appointments');
    }

    public function download(): void {
        Auth::requireRole('admin', 'doctor', 'patient');
        $apptModel = new AppointmentModel();
        $appt = $apptModel->findById((int)$_GET['id']);
        $user = Auth::currentUser();
        if (!$appt) { redirect(BASE_URL . '/index.php?page=errors&code=404'); }
        if ($user['role'] === 'patient' && $appt['patient_id'] != $user['id']) {
            redirect(BASE_URL . '/index.php?page=errors&code=403');
        }
        $prescModel = new PrescriptionModel();
        $presc = $prescModel->findByAppointmentId($appt['id']);
        if (!$presc || !$presc['file_path']) {
            flashMessage('error', 'File not found.');
            redirect(BASE_URL . '/index.php?page=appointments');
        }
        $filepath = __DIR__ . '/../public/uploads/prescriptions/' . $presc['file_path'];
        if (!file_exists($filepath)) {
            flashMessage('error', 'File missing on server.');
            redirect(BASE_URL . '/index.php?page=appointments');
        }
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="prescription.pdf"');
        readfile($filepath);
        exit();
    }

    public function index(): void {
        Auth::requireRole('patient');
        $model = new PrescriptionModel();
        $prescriptions = $model->getByPatient(Auth::currentUser()['id']);
        $pageTitle = 'My Prescriptions';
        require_once __DIR__ . '/../views/prescriptions/index.php';
    }
}
