<?php
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/CSRF.php';
require_once __DIR__ . '/../models/AppointmentModel.php';
require_once __DIR__ . '/../models/DoctorModel.php';

class ReportController {
    public function index(): void {
        Auth::requireRole('admin');
        $doctors = (new DoctorModel())->getAll();
        $results = [];
        $filters = [];

        if (!empty($_GET['from']) && !empty($_GET['to'])) {
            if ($_GET['from'] > $_GET['to']) {
                flashMessage('error', 'Start date must be before end date.');
                redirect(BASE_URL . '/index.php?page=reports');
            }
            $filters = [
                'from'      => $_GET['from'],
                'to'        => $_GET['to'],
                'doctor_id' => $_GET['doctor_id'] ?? '',
                'status'    => $_GET['status'] ?? '',
            ];
            $model   = new AppointmentModel();
            $results = $model->getAll(1, $filters);

            if (isset($_GET['export']) && $_GET['export'] === 'csv') {
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="report.csv"');
                $out = fopen('php://output', 'w');
                fputcsv($out, ['Patient', 'Doctor', 'Date', 'Time', 'Status', 'Reason']);
                foreach ($results as $row) {
                    fputcsv($out, [
                        $row['patient_name'],
                        $row['doctor_name'],
                        $row['appt_date'],
                        $row['appt_time'],
                        $row['status'],
                        $row['reason'],
                    ]);
                }
                fclose($out);
                exit();
            }
        }
        $pageTitle = 'Reports';
        require_once __DIR__ . '/../views/reports/index.php';
    }
}
