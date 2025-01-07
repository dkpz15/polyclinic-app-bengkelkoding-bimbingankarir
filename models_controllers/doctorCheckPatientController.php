<?php
include 'doctorCheckPatientModel.php';

function getPatientsRegisteredForPoly($conn, $id) {
    $doctorCheckPatientModel = new DoctorCheckPatientModel($conn);
    return $doctorCheckPatientModel->getPatientsRegister($conn, $id);
}

function calculateCheckupFee($conn, $check_id, $medicine_id) {
    $doctorCheckPatientModel = new DoctorCheckPatientModel($conn);
    return $doctorCheckPatientModel->calculate($conn, $check_id, $medicine_id);
}

function addCheckup($conn, $poly_list_id, $note, $checkup_fee) {
    $doctorCheckPatientModel = new DoctorCheckPatientModel($conn);
    return $doctorCheckPatientModel->add($conn, $poly_list_id, $note, $checkup_fee);
}
?>
