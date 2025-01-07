<?php
require_once 'doctorInputScheduleModel.php';

function inputCheckupSchedule($conn, $doctor_id, $day, $start_time, $end_time) {
    $doctorInputScheduleModel = new DoctorInputScheduleModel($conn);
    return $doctorInputScheduleModel->inputSchedule($conn, $doctor_id, $day, $start_time, $end_time);
}
?>