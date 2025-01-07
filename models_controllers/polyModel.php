<?php
class PolyModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Fetch all polyclinics
    public function fetch() {
        $sql = "SELECT * FROM poly";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Add a new polyclinic
    public function add($name, $description) {
        $stmt = $this->conn->prepare("INSERT INTO poly (poly_name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);
        return $stmt->execute();
    }

    // Update an existing polyclinic
    public function edit($id, $name, $description) {
        $stmt = $this->conn->prepare("UPDATE poly SET poly_name = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $description, $id);
        return $stmt->execute();
    }

    // Delete a polyclinic
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM poly WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
