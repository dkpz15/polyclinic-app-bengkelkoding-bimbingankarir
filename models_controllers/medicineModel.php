<?php
class MedicineModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Fetch all medicines
    public function fetch() {
        $sql = "SELECT * FROM medicine";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Add a new medicine
    public function add($medicine_name, $packaging, $price) {
        $stmt = $this->conn->prepare("INSERT INTO medicine (medicine_name, packaging, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $medicine_name, $packaging, $price);
        return $stmt->execute();
    }

    // Edit an existing medicine
    public function edit($id, $medicine_name, $packaging, $price) {
        $stmt = $this->conn->prepare("UPDATE medicine SET medicine_name = ?, packaging = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $medicine_name, $packaging, $price, $id);
        return $stmt->execute();
    }

    // Delete a medicine
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM medicine WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
