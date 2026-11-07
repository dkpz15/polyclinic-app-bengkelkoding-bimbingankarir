<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <link rel="icon" href="assets/img/favicon.png">
    <link
    href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
    rel="stylesheet"
    />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/icofont.css" />
    <link rel="stylesheet" href="assets/css/magnific-popup.css" />
    <link rel="stylesheet" href="assets/css/normalize.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f9;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }

        .status-message {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            font-size: 16px;
            gap: 10px;
            border-radius: 8px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .icon {
            font-size: 24px;
        }

        /* Close Button (Font Awesome) */
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #aaa;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }
    </style>
</head>
<body>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>

<?php
session_start();

include 'config/database.php';
include 'models_controllers/adminController.php';
include 'models_controllers/doctorController.php';
include 'models_controllers/patientController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ob_start();

    $action = $_POST['action'];

    if ($action === 'sign_in_admin_doctor') {
        $role = $_POST['role'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        
        if ($role === 'admin') {
            // $sql = "INSERT INTO admin (name, password) VALUES ('$name', '$password')";
            // return $conn->query($sql);
            if (signInAdmin($conn, $name, $password)) {
                $_SESSION['auth'] = true;
                $_SESSION['role_type'] = $role;
                $_SESSION['admin_name'] = $name;
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Admin signed in successfully.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'views/admin/dashboard.php';
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Invalid admin credentials.',
                        icon: 'error'
                    }).then(() => {
                        window.location.href = 'views/auth/doctorAdminSignIn.php';
                    });
                </script>";
            }
        } elseif ($role === 'doctor') {
            $address = $_POST['address'];
            $mobile_phone_number = $_POST['mobile_phone_number'];
            $poly_id = $_POST['poly_id'];
            // $sql = "INSERT INTO doctor (name, password, address, mobile_phone_number, poly_id) 
            // VALUES ('$name', '$password', '$address', '$mobile_phone_number', '$poly_id')";
            // return $conn->query($sql);

            if (signInDoctor($conn, $name, $password, $address, $mobile_phone_number, $poly_id)) {
                $_SESSION['auth'] = true;
                $_SESSION['role_type'] = $role;
                $_SESSION['doctor_id'] = signInDoctor($conn, $name, $password, $address, $mobile_phone_number, $poly_id);
                $_SESSION['doctor_name'] = $name;
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Doctor signed in successfully.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'views/doctor/dashboard.php';
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Invalid doctor credentials.',
                        icon: 'error'
                    }).then(() => {
                        window.location.href = 'views/auth/doctorAdminSignIn.php';
                    });
                </script>";
            }
        }
    } elseif ($action === 'sign_in_patient') {
        $role = 'patient';
        $name = $_POST['name'];
        $password = $_POST['password'];

        if (signInPatient($conn, $name, $password)) {
            $_SESSION['auth'] = true;
            $_SESSION['role_type'] = $role;
            $_SESSION['patient_id'] = signInPatient($conn, $name, $password);
            $_SESSION['patient_name'] = $name;
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Patient signed in successfully.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'views/patient/dashboard.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Invalid patient credentials.',
                    icon: 'error'
                }).then(() => {
                    window.location.href = 'views/auth/patientSignIn.php';
                });
            </script>";
        }
    } elseif ($action === 'register_patient') {
        $name = $_POST['name'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $address = $_POST['address'];
        $identity_card_number = $_POST['identity_card_number'];
        $mobile_phone_number = $_POST['mobile_phone_number'];
        $medical_record_number = $_POST['medical_record_number'];

        if (registerPatient($conn, $name, $password, $address, $identity_card_number, $mobile_phone_number, $medical_record_number)) {
            $_SESSION['auth'] = true;
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Patient registered successfully.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'views/auth/patientSignIn.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Patient registration failed.',
                    icon: 'error'
                }).then(() => {
                    window.location.href = 'views/auth/patientRegister.php';
                });
            </script>";
        }
    }
    ob_end_flush();
}
?>

