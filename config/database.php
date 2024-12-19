<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'polyclinic_app_bengkelkoding_bimbingankarir';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Database connection failed : " . $conn->connect_error);
}
?>