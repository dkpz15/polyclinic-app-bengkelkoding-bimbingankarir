<?php
class DoctorProfileUpdateModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateProfile($id, $name, $address, $mobile_phone_number) {
        $query = "UPDATE doctor SET name = ?, address = ?, mobile_phone_number = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("sssi", $name, $address, $mobile_phone_number, $id);
        return $stmt->execute();
    }

    public function updatePassword($id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE doctor SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("si", $hashed_password, $id);
        return $stmt->execute();
    }

    public function getDoctorPassword($id) {
        $query = "SELECT password FROM doctor WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($password);
        $stmt->fetch();
        return $password;
    }
}
?>
