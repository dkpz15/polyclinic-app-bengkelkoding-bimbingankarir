<?php
class PatientCheckDetailsModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchDetails($id) {
        $stmt = $this->conn->prepare("
            SELECT 
                c.check_date, 
                d.name AS doctor_name,
                c.medicine_name,  
                c.note, 
                c.check_fee
            FROM 
                checkup c
            JOIN 
                poly_list pl ON c.poly_list_id = pl.id
            JOIN 
                check_schedule cs ON pl.schedule_id = cs.id
            JOIN 
                doctor d ON cs.doctor_id = d.id
            LEFT JOIN 
                check_detail cd ON c.id = cd.check_id
            LEFT JOIN 
                medicine m ON cd.medicine_id = m.id
            WHERE 
                pl.patient_id = ?
            GROUP BY 
                c.id
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
