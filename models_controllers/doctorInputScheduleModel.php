<?php
class DoctorInputScheduleModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function inputSchedule($doctor_id, $day, $start_time, $end_time) {
        $query = "INSERT INTO check_schedule (doctor_id, day, start_time, end_time) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isss", $doctor_id, $day, $start_time, $end_time);
        return $stmt->execute();
    }
}
?>
