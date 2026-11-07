<?php
require_once 'patientToPolyRegisterModel.php';

function registerPatientToPoly($conn, $patient_id, $schedule_id, $complaint) {      
    $patientToPolyRegisterModel = new PatientToPolyRegisterModel($conn);
    return $patientToPolyRegisterModel->register($patient_id, $schedule_id, $complaint);
}
?>
