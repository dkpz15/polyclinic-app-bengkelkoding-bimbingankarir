<?php
function doctorLogin($conn, $name, $password, $address, $mobile_phone_number, $poly_id) {
    // SQL query to match all fields including name, password, address, mobile_phone_number, and poly_id
    $sql = "SELECT * FROM doctor WHERE name = '$name' AND address = '$address' AND mobile_phone_number = '$mobile_phone_number' AND poly_id = '$poly_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $doctor = $result->fetch_assoc();
        return password_verify($password, $doctor['password']);
    }
    return false;
}

function fetchDoctors($conn) {
    $sql = "SELECT * FROM doctor";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function addDoctor($conn, $name, $password, $address, $mobile_phone_number, $poly_id) {
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);  // Hash the password
    $sql = "INSERT INTO doctor (name, password, address, mobile_phone_number, poly_id) VALUES ('$name', '$passwordHash', '$address', '$mobile_phone_number', '$poly_id')";
    return $conn->query($sql);
}

function editDoctor($conn, $id, $name, $password, $address, $mobile_phone_number, $poly_id) {
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);  // Hash the password
    $sql = "UPDATE doctor SET name = '$name', password = '$passwordHash', address = '$address', mobile_phone_number = '$mobile_phone_number', poly_id = '$poly_id' WHERE id = '$id'";
    return $conn->query($sql);
}

function deleteDoctor($conn, $id) {
    $sql = "DELETE FROM doctor WHERE id = '$id'";
    return $conn->query($sql);
}
?>
