<?php
require_once 'adminModel.php';

function signInAdmin($conn, $name, $password) {
    $adminModel = new AdminModel($conn);
    return $adminModel->signIn($name, $password);
}

function getDashboardAdminCounts($conn) {
    $adminModel = new AdminModel($conn);
    return $adminModel->getCounts();
}
?>
