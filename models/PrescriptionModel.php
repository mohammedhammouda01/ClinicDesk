<?php
require_once __DIR__ . '/BaseModel.php';
class PrescriptionModel extends BaseModel {
    public function findByAppointmentId(int $apptId): ?array {
        $result = $this->execute(
            'SELECT * FROM prescriptions WHERE appointment_id = ?',
            'i', [$apptId]
        );
        $row = $result->fetch_assoc();
        return $row ?: null;
    }
    public function create(array $data): int {
        $this->execute(
            'INSERT INTO prescriptions (appointment_id, diagnosis, medications, notes, file_path)
             VALUES (?, ?, ?, ?, ?)',
            'issss',
            [$data['appointment_id'], $data['diagnosis'], $data['medications'],
             $data['notes'] ?? null, $data['file_path'] ?? null]
        );
        return $this->db->lastInsertId();
    }
    public function update(int $id, array $data): bool {
        $result = $this->execute(
            'UPDATE prescriptions SET diagnosis=?, medications=?, notes=?, file_path=? WHERE id=?',
            'ssssi',
            [$data['diagnosis'], $data['medications'], $data['notes'] ?? null,
             $data['file_path'] ?? null, $id]
        );
        return $result === true;
    }
    public function getByPatient(int $patientId): array {
        $result = $this->execute(
            'SELECT p.*, a.appt_date, a.appt_time, du.name as doctor_name
             FROM prescriptions p
             JOIN appointments a ON p.appointment_id = a.id
             JOIN doctors d ON a.doctor_id = d.id
             JOIN users du ON d.user_id = du.id
             WHERE a.patient_id = ?
             ORDER BY a.appt_date DESC',
            'i', [$patientId]
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
