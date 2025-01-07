<?php
require_once 'patientModel.php';

function registerPatient($conn, $name, $password, $address, $identity_card_number, $mobile_phone_number, $medical_record_number) {
    $patientModel = new PatientModel($conn);
    return $patientModel->register($name, $password, $address, $identity_card_number, $mobile_phone_number, $medical_record_number);
}

function signInPatient($conn, $name, $password) {
    $patientModel = new PatientModel($conn);
    return $patientModel->signIn($name, $password);
}

function generateMedicalRecordNumberPatient($conn) {
    $patientModel = new PatientModel($conn);
    return $patientModel->generateMedicalRecordNumber();
}

function fetchPatients($conn) {
    $patientModel = new PatientModel($conn);
    return $patientModel->fetch();
}

function editPatient($conn, $id, $name, $address, $identity_card_number, $mobile_phone_number, $medical_record_number) {
    $patientModel = new PatientModel($conn);
    return $patientModel->edit($id, $name, $address, $identity_card_number, $mobile_phone_number, $medical_record_number);
}

function deletePatient($conn, $id) {
    $patientModel = new PatientModel($conn);
    return $patientModel->delete($id);
}
?>
