<?php

// Function to register a new patient
function patientRegister($conn, $name, $password, $address, $identity_card_number, $mobile_phone_number, $medical_record_number) {
    $sql = "INSERT INTO patient (name, password, address, identity_card_number, mobile_phone_number, medical_record_number) 
            VALUES ('$name', '$password', '$address', '$identity_card_number', '$mobile_phone_number', '$medical_record_number')";
    return $conn->query($sql);
}

// Function to handle patient login
function patientLogin($conn, $name, $password) {
    $sql = "SELECT * FROM patient WHERE name = '$name'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        return password_verify($password, $patient['password']);
    }
    return false;
}

// Function to generate a new medical record number
function generateMedicalRecordNumber($conn) {
    $yearMonth = date('Ym'); // Format: YYYYMM
    $sql = "SELECT medical_record_number FROM patient WHERE medical_record_number LIKE '$yearMonth-%' ORDER BY medical_record_number DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $lastRecord = $result->fetch_assoc();
        $lastQueue = (int) explode('-', $lastRecord['medical_record_number'])[1];
        $newQueue = $lastQueue + 1;
    } else {
        $newQueue = 1; // Start the queue from 1
    }

    return $yearMonth . '-' . $newQueue; // Format: YYYYMM-N
}

// Function to update patient details
function patientUpdate($conn, $id, $name, $address, $identity_card_number, $mobile_phone_number, $medical_record_number) {
    $sql = "UPDATE patient SET name = '$name', address = '$address', identity_card_number = '$identity_card_number', mobile_phone_number = '$mobile_phone_number', medical_record_number = '$medical_record_number' WHERE id = $id";
    return $conn->query($sql);
}

// Function to delete a patient
function patientDelete($conn, $id) {
    $sql = "DELETE FROM patient WHERE id = $id";
    return $conn->query($sql);
}

// Function to fetch all patients
function fetchPatients($conn) {
    $sql = "SELECT * FROM patient";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Handle POST and GET requests for update and delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config/database.php';
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $identity_card_number = $_POST['identity_card_number'];
        $mobile_phone_number = $_POST['mobile_phone_number'];
        $medical_record_number = $_POST['medical_record_number'];

        patientUpdate($conn, $id, $name, $address, $identity_card_number, $mobile_phone_number, $medical_record_number);
        header('Location: ../views/admin/patientManage.php');
        exit();
    }
}

if (isset($_GET['delete_id'])) {
    include '../config/database.php';
    $id = $_GET['delete_id'];
    patientDelete($conn, $id);
    header('Location: ../views/admin/patientManage.php');
    exit();
}
?>
