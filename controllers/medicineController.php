<?php
// Fetch all medicines from the database
function fetchMedicines($conn) {
    $sql = "SELECT * FROM medicine";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Add or update a medicine
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config/database.php';

    $medicine_name = $_POST['medicine_name'];
    $packaging = $_POST['packaging'];
    $price = $_POST['price'];

    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Update medicine
        $id = $_POST['id'];
        $sql = "UPDATE medicine SET medicine_name = '$medicine_name', packaging = '$packaging', price = '$price' WHERE id = $id";
    } else {
        // Insert new medicine
        $sql = "INSERT INTO medicine (medicine_name, packaging, price) VALUES ('$medicine_name', '$packaging', '$price')";
    }

    if ($conn->query($sql)) {
        header('Location: ../views/admin/medicineManage.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Delete a medicine
if (isset($_GET['delete_id'])) {
    include '../config/database.php';

    $id = $_GET['delete_id'];
    $sql = "DELETE FROM medicine WHERE id = $id";

    if ($conn->query($sql)) {
        header('Location: ../views/admin/medicineManage.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
