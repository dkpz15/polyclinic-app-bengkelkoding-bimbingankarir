<?php
class DoctorCheckPatientModel {
    public function getPatientsRegister($conn, $id) {
        $query = "SELECT pl.id AS poly_list_id, p.name AS patient_name, pl.complaint, pl.queue_number
              FROM poly_list pl
              JOIN check_schedule cs ON pl.schedule_id = cs.id
              JOIN patient p ON pl.patient_id = p.id
              WHERE cs.doctor_id = ? AND NOT EXISTS (SELECT 1 FROM checkup c WHERE c.poly_list_id = pl.id)
              ORDER BY pl.queue_number ASC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function calculate($conn, $check_id, $medicine_id) {
        $query = "SELECT price FROM medicine WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $medicine_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $medicine_price = $result['price'];

        // Base fee is 150,000
        $checkup_fee = 150000 + $medicine_price;
        return $checkup_fee;
    }

    public function add($conn, $poly_list_id, $note, $checkup_fee) {
        $query = "INSERT INTO checkup (poly_list_id, check_date, note, check_fee) VALUES (?, CURDATE(), ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isi", $poly_list_id, $note, $checkup_fee);
        return $stmt->execute();
    }
}
?>
