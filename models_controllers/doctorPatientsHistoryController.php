<?php
include 'doctorPatientsHistoryModel.php';

function getPatientsHistory($conn, $id) {
    $doctorPatientsHistoryModel = new DoctorPatientsHistoryModel($conn);
    return $doctorPatientsHistoryModel->get($id);
}
?>
