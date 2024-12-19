<?php
function fetchPolies($conn) {
    $sql = "SELECT * FROM poly";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function editPoly($conn, $id, $poly_name, $description) {
    $sql = "UPDATE poly SET poly_name = '$poly_name', description = '$description' WHERE id = '$id'";
    return $conn->query($sql);
}

function deletePoly($conn, $id) {
    $sql = "DELETE FROM poly WHERE id = '$id'";
    return $conn->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config/database.php';

    if (isset($_POST['addPoly'])) {
        $poly_name = $_POST['poly_name'];
        $description = $_POST['description'];

        $sql = "INSERT INTO poly (poly_name, description) VALUES ('$poly_name', '$description')";

        if ($conn->query($sql)) {
            header('Location: ../views/admin/polyManage.php');
        } else {
            echo "Error: " . $conn->error;
        }
    }

    if (isset($_POST['editPoly'])) {
        $id = $_POST['id'];
        $poly_name = $_POST['poly_name'];
        $description = $_POST['description'];

        if (editPoly($conn, $id, $poly_name, $description)) {
            header('Location: ../views/admin/polyManage.php');
        } else {
            echo "Error updating poly.";
        }
    }

    if (isset($_POST['deletePoly'])) {
        $id = $_POST['id'];

        if (deletePoly($conn, $id)) {
            header('Location: ../views/admin/polyManage.php');
        } else {
            echo "Error deleting poly.";
        }
    }
}
?>
