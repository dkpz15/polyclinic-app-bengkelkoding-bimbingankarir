<?php
class PatientModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function register($name, $password, $address, $identity_card_number, $mobile_phone_number, $medical_record_number) {
        $stmt = $this->conn->prepare("INSERT INTO patient (name, password, address, identity_card_number, mobile_phone_number, medical_record_number) 
                                      VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $password, $address, $identity_card_number, $mobile_phone_number, $medical_record_number);
        return $stmt->execute();
    }

    public function signIn($name, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM patient WHERE name = ?");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $patient = $result->fetch_assoc();
                if (password_verify($password, $patient['password'])) {
                    return $patient['id'];
                }
            }
        }
        return false;
    }

    public function generateMedicalRecordNumber() {
        $yearMonth = date('Ym');
        $likePattern = $yearMonth . '%';
        $stmt = $this->conn->prepare("SELECT medical_record_number FROM patient WHERE medical_record_number LIKE ? ORDER BY medical_record_number DESC LIMIT 1");
        $stmt->bind_param("s", $likePattern);
    
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $lastRecord = $result->fetch_assoc();
                $lastQueue = (int) explode('-', $lastRecord['medical_record_number'])[1];
                $newQueue = $lastQueue + 1;
            } else {
                $newQueue = 1;
            }
            return $yearMonth . '-' . $newQueue;
        }
        return null;
    }

    public function fetch() {
        $sql = "SELECT * FROM patient";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function edit($id, $name, $address, $identity_card_number, $mobile_phone_number, $medical_record_number) {
        $stmt = $this->conn->prepare("UPDATE patient SET name = ?, address = ?, identity_card_number = ?, mobile_phone_number = ?, medical_record_number = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $address, $identity_card_number, $mobile_phone_number, $medical_record_number, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM patient WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
