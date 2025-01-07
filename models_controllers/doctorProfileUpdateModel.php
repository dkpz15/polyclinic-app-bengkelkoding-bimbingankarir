<?php
class DoctorProfileUpdateModel {
    public function updateProfile($conn, $id, $name, $address, $mobile_phone_number) {
        $query = "UPDATE doctor SET name = ?, address = ?, mobile_phone_number = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        $stmt->bind_param("sssi", $name, $address, $mobile_phone_number, $id);
        return $stmt->execute();
    }

    public function updatePassword($conn, $id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE doctor SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($query);

        $stmt->bind_param("si", $hashed_password, $id);
        return $stmt->execute();
    }

    public function getDoctorPassword($conn, $id) {
        $query = "SELECT password FROM doctor WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($password);
        $stmt->fetch();
        return $password;
    }
}
?>
