<?php
include 'patientCheckDetailsModel.php';

function fetchCheckDetails($conn, $id) {
    $patientCheckDetailsModel = new PatientCheckDetailsModel($conn);
    return $patientCheckDetailsModel->fetchDetails($id);
}
?>
