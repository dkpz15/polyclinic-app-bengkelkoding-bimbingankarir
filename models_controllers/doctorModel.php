<?php
class DoctorModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function signIn($name, $password, $address, $mobile_phone_number, $poly_id) {
        $stmt = $this->conn->prepare("SELECT id, password FROM doctor WHERE name = ? AND address = ? AND mobile_phone_number = ? AND poly_id = ?");
        $stmt->bind_param("ssss", $name, $address, $mobile_phone_number, $poly_id);
    
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $doctor = $result->fetch_assoc();
                if (password_verify($password, $doctor['password'])) {
                    return $doctor['id'];
                }
            }
        }
        return false;
    }

    public function fetch() {
        $sql = "SELECT * FROM doctor";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function add($name, $password, $address, $mobile_phone_number, $poly_id) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO doctor (name, password, address, mobile_phone_number, poly_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $passwordHash, $address, $mobile_phone_number, $poly_id);
        return $stmt->execute();
    }

    public function edit($id, $name, $password, $address, $mobile_phone_number, $poly_id) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("UPDATE doctor SET name = ?, password = ?, address = ?, mobile_phone_number = ?, poly_id = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $passwordHash, $address, $mobile_phone_number, $poly_id, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM doctor WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function get() {
        $query = "SELECT id, name, status FROM doctor";
        return $this->conn->query($query);
    }

    public function updateStatus($id, $status) {
        $status = $this->conn->real_escape_string($status);
        $id = (int) $id;
    
        $query = "UPDATE doctor SET status = '$status' WHERE id = $id";
        if ($this->conn->query($query)) {
            return $id;
        } else {
            return false;
        }
    }

    public function getActive() {
        $query = "SELECT id, name FROM doctor WHERE status = 'active' LIMIT 1";
        return $this->conn->query($query)->fetch_assoc();
    }

    public function setInactiveForOthers() {
        $query = "UPDATE doctor SET status = 'inactive' WHERE status = 'active'";
        return $this->conn->query($query);
    }
}
?>
