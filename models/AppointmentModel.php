<?php
require_once __DIR__ . '/BaseModel.php';
class AppointmentModel extends BaseModel {
    public function book(array $data): bool {
        $result = $this->execute(
            'INSERT INTO appointments (patient_id, doctor_id, appt_date, appt_time, reason)
             VALUES (?, ?, ?, ?, ?)',
            'iisss',
            [$data['patient_id'], $data['doctor_id'], $data['appt_date'], $data['appt_time'], $data['reason'] ?? null]
        );
        return $result === true;
    }
    public function hasConflict(int $doctorId, string $date, string $time): bool {
        $result = $this->execute(
            'SELECT id FROM appointments WHERE doctor_id=? AND appt_date=? AND appt_time=? AND status != "cancelled"',
            'iss', [$doctorId, $date, $time]
        );
        return $result->num_rows > 0;
    }
    public function getByPatient(int $patientId, int $page, array $filters = []): array {
        $limit  = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        $conditions = ['a.patient_id = ?'];
        $params = [$patientId];
        $types = 'i';
        if (!empty($filters['status'])) { $conditions[] = 'a.status = ?'; $params[] = $filters['status']; $types .= 's'; }
        if (!empty($filters['from']))   { $conditions[] = 'a.appt_date >= ?'; $params[] = $filters['from']; $types .= 's'; }
        if (!empty($filters['to']))     { $conditions[] = 'a.appt_date <= ?'; $params[] = $filters['to']; $types .= 's'; }
        $where = implode(' AND ', $conditions);
        $params[] = $limit; $params[] = $offset; $types .= 'ii';
        $result = $this->execute(
            "SELECT a.*, u.name as doctor_name, s.name as specialization
             FROM appointments a
             JOIN doctors d ON a.doctor_id = d.id
             JOIN users u ON d.user_id = u.id
             JOIN specializations s ON d.specialization_id = s.id
             WHERE $where ORDER BY a.appt_date DESC, a.appt_time DESC LIMIT ? OFFSET ?",
            $types, $params
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getByDoctor(int $doctorId, int $page, array $filters = []): array {
        $limit  = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        $conditions = ['a.doctor_id = ?'];
        $params = [$doctorId];
        $types = 'i';
        if (!empty($filters['status'])) { $conditions[] = 'a.status = ?'; $params[] = $filters['status']; $types .= 's'; }
        if (!empty($filters['from']))   { $conditions[] = 'a.appt_date >= ?'; $params[] = $filters['from']; $types .= 's'; }
        if (!empty($filters['to']))     { $conditions[] = 'a.appt_date <= ?'; $params[] = $filters['to']; $types .= 's'; }
        $where = implode(' AND ', $conditions);
        $params[] = $limit; $params[] = $offset; $types .= 'ii';
        $result = $this->execute(
            "SELECT a.*, u.name as patient_name
             FROM appointments a
             JOIN users u ON a.patient_id = u.id
             WHERE $where ORDER BY a.appt_date ASC, a.appt_time ASC LIMIT ? OFFSET ?",
            $types, $params
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getAll(int $page, array $filters = []): array {
        $limit  = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        $conditions = [];
        $params = [];
        $types = '';
        if (!empty($filters['status']))    { $conditions[] = 'a.status = ?'; $params[] = $filters['status']; $types .= 's'; }
        if (!empty($filters['doctor_id'])) { $conditions[] = 'a.doctor_id = ?'; $params[] = $filters['doctor_id']; $types .= 'i'; }
        if (!empty($filters['from']))      { $conditions[] = 'a.appt_date >= ?'; $params[] = $filters['from']; $types .= 's'; }
        if (!empty($filters['to']))        { $conditions[] = 'a.appt_date <= ?'; $params[] = $filters['to']; $types .= 's'; }
        $where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $params[] = $limit; $params[] = $offset; $types .= 'ii';
        $result = $this->execute(
            "SELECT a.*, p.name as patient_name, du.name as doctor_name
             FROM appointments a
             JOIN users p ON a.patient_id = p.id
             JOIN doctors d ON a.doctor_id = d.id
             JOIN users du ON d.user_id = du.id
             $where ORDER BY a.appt_date DESC LIMIT ? OFFSET ?",
            $types, $params
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function countFiltered(string $scope, int $scopeId, array $filters = []): int {
        $conditions = [];
        $params = [];
        $types = '';
        if ($scope === 'patient') { $conditions[] = 'patient_id = ?'; $params[] = $scopeId; $types .= 'i'; }
        if ($scope === 'doctor')  { $conditions[] = 'doctor_id = ?'; $params[] = $scopeId; $types .= 'i'; }
        if (!empty($filters['status'])) { $conditions[] = 'status = ?'; $params[] = $filters['status']; $types .= 's'; }
        if (!empty($filters['from']))   { $conditions[] = 'appt_date >= ?'; $params[] = $filters['from']; $types .= 's'; }
        if (!empty($filters['to']))     { $conditions[] = 'appt_date <= ?'; $params[] = $filters['to']; $types .= 's'; }
        $where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $result = $this->execute("SELECT COUNT(*) as total FROM appointments $where", $types, $params);
        return (int) $result->fetch_assoc()['total'];
    }
    public function updateStatus(int $id, string $status, string $notes = ''): bool {
        $result = $this->execute(
            'UPDATE appointments SET status=?, doctor_notes=? WHERE id=?',
            'ssi', [$status, $notes, $id]
        );
        return $result === true;
    }
    public function findById(int $id): ?array {
        $result = $this->execute(
            'SELECT a.*, p.name as patient_name, du.name as doctor_name, d.id as doctor_record_id
             FROM appointments a
             JOIN users p ON a.patient_id = p.id
             JOIN doctors d ON a.doctor_id = d.id
             JOIN users du ON d.user_id = du.id
             WHERE a.id = ?',
            'i', [$id]
        );
        $row = $result->fetch_assoc();
        return $row ?: null;
    }
    public function getTodayByDoctor(int $doctorId): array {
        $result = $this->execute(
            'SELECT a.*, u.name as patient_name FROM appointments a
             JOIN users u ON a.patient_id = u.id
             WHERE a.doctor_id=? AND a.appt_date=CURDATE()
             ORDER BY a.appt_time ASC',
            'i', [$doctorId]
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
