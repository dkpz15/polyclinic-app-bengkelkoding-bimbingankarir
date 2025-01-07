<?php
require_once 'doctorModel.php';

function signInDoctor($conn, $name, $password, $address, $mobile_phone_number, $poly_id) {
    $doctorModel = new DoctorModel($conn);
    return $doctorModel->signIn($name, $password, $address, $mobile_phone_number, $poly_id);
}

function fetchDoctors($conn) {
    $doctorModel = new DoctorModel($conn);
    return $doctorModel->fetch();
}

function addDoctor($conn, $name, $password, $address, $mobile_phone_number, $poly_id) {
    $doctorModel = new DoctorModel($conn);
    return $doctorModel->add($name, $password, $address, $mobile_phone_number, $poly_id);
}

function editDoctor($conn, $id, $name, $password, $address, $mobile_phone_number, $poly_id) {
    $doctorModel = new DoctorModel($conn);
    return $doctorModel->edit($id, $name, $password, $address, $mobile_phone_number, $poly_id);
}

function deleteDoctor($conn, $id) {
    $doctorModel = new DoctorModel($conn);
    return $doctorModel->delete($id);
}

function getDoctors($conn) {
    $doctorModel = new DoctorModel($conn);
    return $doctorModel->get($conn);
}

function updateDoctorStatus($conn, $id, $status) {
    $doctorModel = new DoctorModel($conn);
    return $doctorModel->updateStatus($conn, $id, $status);
}

function getActiveDoctor($conn) {
    $doctorModel = new DoctorModel($conn);
    return $doctorModel->getActive($conn);
}

function setInactiveForOtherDoctors($conn) {
    $doctorModel = new DoctorModel($conn);
    return $doctorModel->setInactiveForOthers($conn);
}
?>
