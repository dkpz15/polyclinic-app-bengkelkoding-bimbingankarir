<?php
session_start();

$role = $_SESSION['role_type'];

$sweetAlert2SignOut = '';

if ($role === 'admin'){
    $sweetAlert2SignOut = 
    "Swal.fire({
        title: 'Success',
        text: 'Admin signed out successfully.',
        icon: 'success',
        showConfirmButton: true
    }).then(() => {
        window.location.href = '../../index.php';
    });";
} else if ($role === 'doctor'){
    $sweetAlert2SignOut = 
    "Swal.fire({
        title: 'Success',
        text: 'Doctor signed out successfully.',
        icon: 'success',
        showConfirmButton: true
    }).then(() => {
        window.location.href = '../../index.php';
    });";
} else if ($role === 'patient'){
    $sweetAlert2SignOut = 
    "Swal.fire({
        title: 'Success',
        text: 'Patient signed out successfully.',
        icon: 'success',
        showConfirmButton: true
    }).then(() => {
        window.location.href = '../../index.php';
    });";
}

session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <link rel="icon" href="../../assets/img/favicon.png">
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
    rel="stylesheet"
    />
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../../assets/css/icofont.css" />
    <link rel="stylesheet" href="../../assets/css/magnific-popup.css" />
    <link rel="stylesheet" href="../../assets/css/normalize.css" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="stylesheet" href="../../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <script src="../../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
</head>
<body>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/jquery.magnific-popup.min.js"></script>
    <script src="../../assets/js/main.js"></script>
    <script>
        <?= $sweetAlert2SignOut ?>
    </script>
</body>
</html>