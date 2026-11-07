<?php
class PatientToPolyRegisterModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function register($patient_id, $schedule_id, $complaint) {
        $query = "SELECT MAX(queue_number) as last_queue FROM poly_list WHERE schedule_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $schedule_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $queue_number = $data['last_queue'] + 1;

        // Insert patient into polyclinic schedule
        $query = "INSERT INTO poly_list (patient_id, schedule_id, complaint, queue_number) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iisi", $patient_id, $schedule_id, $complaint, $queue_number);
        return $stmt->execute();
    }
}
?>
