<?php
class AdminModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAdminByName($name) {
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE name = ?");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->num_rows > 0 ? $result->fetch_assoc() : null;
        }

        return null;
    }

    public function signIn($name, $password) {
        $admin = $this->getAdminByName($name);

        if ($admin) {
            return password_verify($password, $admin['password']);
        }

        return false;
    }

    public function getCounts() {
        $counts = [];

        // Count Doctors
        $counts['doctors'] = $this->countTable('doctor');

        // Count Patients
        $counts['patients'] = $this->countTable('patient');

        // Count Polies
        $counts['polies'] = $this->countTable('poly');

        // Count Medicines
        $counts['medicines'] = $this->countTable('medicine');

        return $counts;
    }

    private function countTable($tableName) {
        $query = "SELECT COUNT(*) AS total FROM $tableName";
        $result = $this->conn->query($query);
        $data = $result->fetch_assoc();
        return $data['total'];
    }
}
?>
