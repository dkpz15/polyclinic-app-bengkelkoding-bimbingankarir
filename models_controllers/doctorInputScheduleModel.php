<?php
class DoctorInputScheduleModel {
    public function inputSchedule($conn, $doctor_id, $day, $start_time, $end_time) {
        $query = "INSERT INTO check_schedule (doctor_id, day, start_time, end_time) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isss", $doctor_id, $day, $start_time, $end_time);
        return $stmt->execute();
    }
}
?>
