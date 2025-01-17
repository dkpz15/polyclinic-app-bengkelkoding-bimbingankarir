<?php
class DoctorCheckPatientModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getPatientsRegister($id) {
        $query = "SELECT pl.id AS poly_list_id, p.name AS patient_name, pl.complaint, pl.queue_number
              FROM poly_list pl
              JOIN check_schedule cs ON pl.schedule_id = cs.id
              JOIN patient p ON pl.patient_id = p.id
              WHERE cs.doctor_id = ? AND NOT EXISTS (SELECT 1 FROM checkup c WHERE c.poly_list_id = pl.id)
              ORDER BY pl.queue_number ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function add($poly_list_id, $medicine_name, $note, $check_fee) {
        $query = "INSERT INTO checkup (poly_list_id, check_date, medicine_name, note, check_fee) VALUES (?, NOW(), ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issi", $poly_list_id, $medicine_name, $note, $check_fee);
        if ($stmt->execute()) {
            $check_id = $stmt->insert_id;
    
            return $check_id;
        }
        return false;
    }    
}
?>
