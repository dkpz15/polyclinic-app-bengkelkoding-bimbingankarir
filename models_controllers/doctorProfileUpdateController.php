<?php
require_once 'doctorProfileUpdateModel.php';

function updateDoctorProfile($conn, $id, $name = null, $address = null, $mobile_phone_number = null, $new_password = null) {
    $doctorProfileUpdateModel = new DoctorProfileUpdateModel($conn);

    if ($name !== null && $address !== null && $mobile_phone_number !== null) {
        return $doctorProfileUpdateModel->updateProfile($conn, $id, $name, $address, $mobile_phone_number);
    } elseif ($new_password !== null) {
        return $doctorProfileUpdateModel->updatePassword($conn, $id, $new_password);
    }
    return false;
}

function getDoctorPassword($conn, $id) {
    $doctorProfileUpdateModel = new DoctorProfileUpdateModel($conn);
    return $doctorProfileUpdateModel->getDoctorPassword($conn, $id);
}
?>
