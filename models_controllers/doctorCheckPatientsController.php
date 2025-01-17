<?php
include 'doctorCheckPatientsModel.php';

function getPatientsRegisteredForPoly($conn, $id) {
    $doctorCheckPatientModel = new DoctorCheckPatientModel($conn);
    return $doctorCheckPatientModel->getPatientsRegister($id);
}

function addCheck($conn, $poly_list_id, $medicine_name, $note, $check_fee) {
    $doctorCheckPatientModel = new DoctorCheckPatientModel($conn);
    return $doctorCheckPatientModel->add($poly_list_id, $medicine_name, $note, $check_fee);
}
?>
