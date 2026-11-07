<?php
require_once 'medicineModel.php';

function fetchMedicines($conn) {
    $medicineModel = new MedicineModel($conn);
    return $medicineModel->fetch();
}

function addMedicine($conn, $medicine_name, $packaging, $price) {
    $medicineModel = new MedicineModel($conn);
    return $medicineModel->add($medicine_name, $packaging, $price);
}

function editMedicine($conn, $id, $medicine_name, $packaging, $price) {
    $medicineModel = new MedicineModel($conn);
    return $medicineModel->edit($id, $medicine_name, $packaging, $price);
}

function deleteMedicine($conn, $id) {
    $medicineModel = new MedicineModel($conn);
    return $medicineModel->delete($id);
}
?>
