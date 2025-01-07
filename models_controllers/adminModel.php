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
}
?>
