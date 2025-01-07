<?php
class DoctorPatientsHistoryModel {
    public function get($conn, $id) {
        $query = "SELECT c.check_date, p.name AS patient_name, c.note, c.check_fee
                  FROM checkup c
                  JOIN poly_list pl ON c.poly_list_id = pl.id
                  JOIN patient p ON pl.patient_id = p.id
                  JOIN check_schedule cs ON pl.schedule_id = cs.id
                  WHERE cs.doctor_id = ?
                  ORDER BY c.check_date DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
