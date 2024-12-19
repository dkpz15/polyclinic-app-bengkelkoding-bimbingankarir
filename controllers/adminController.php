<?php
function adminLogin($conn, $name, $password) {
    $sql = "SELECT * FROM admin WHERE name = '$name'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        return password_verify($password, $admin['password']);
    }
    return false;
}
?>
