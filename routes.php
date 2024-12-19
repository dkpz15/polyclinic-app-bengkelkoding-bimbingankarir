<?php
include 'config/database.php';
include 'controllers/adminController.php';
include 'controllers/doctorController.php';
include 'controllers/patientController.php';

$status = ''; // Variabel untuk menyimpan status login atau registrasi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'login_admin_doctor') {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $address = $_POST['address'];
        $mobile_phone_number = $_POST['mobile_phone_number'];
        $poly_id = $_POST['poly_id'];
        
        if ($role === 'admin') {
            if (adminLogin($conn, $name, $password)) {
                $status = ['type' => 'success', 'message' => 'Login Admin Successful!', 'icon' => 'fas fa-check-circle'];
                header('Location: views/admin/dashboard.php');
            } else {
                $status = ['type' => 'error', 'message' => 'Invalid Admin Credentials!', 'icon' => 'fas fa-times-circle'];
                header('Location: views/auth/loginAdminDoctor.php');
            }
        } elseif ($role === 'doctor') {
            // $sql = "INSERT INTO doctor (name, password, address, mobile_phone_number, poly_id) 
            // VALUES ('$name', '$password', '$address', '$mobile_phone_number', '$poly_id')";
            // return $conn->query($sql);

            if (doctorLogin($conn, $name, $password, $address, $mobile_phone_number, $poly_id)) {
                $status = ['type' => 'success', 'message' => 'Login Doctor Successful!', 'icon' => 'fas fa-check-circle'];
                header('Location: views/doctor/dashboard.php');
            } else {
                $status = ['type' => 'error', 'message' => 'Invalid Doctor Credentials!', 'icon' => 'fas fa-times-circle'];
                header('Location: views/auth/loginAdminDoctor.php');
            }
        }
    } elseif ($action === 'login_patient') {
        $name = $_POST['name'];
        $password = $_POST['password'];

        if (patientLogin($conn, $name, $password)) {
            $status = ['type' => 'success', 'message' => 'Login Patient Successful!', 'icon' => 'fas fa-check-circle'];
            header('Location: views/patient/dashboard.php');
        } else {
            $status = ['type' => 'error', 'message' => 'Invalid Patient Credentials!', 'icon' => 'fas fa-times-circle'];
            header('Location: views/auth/loginPatient.php');
        }
    } elseif ($action === 'register_patient') {
        $name = $_POST['name'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $address = $_POST['address'];
        $identity_card_number = $_POST['identity_card_number'];
        $mobile_phone_number = $_POST['mobile_phone_number'];
        $medical_record_number = $_POST['medical_record_number'];

        if (patientRegister($conn, $name, $password, $address, $identity_card_number, $mobile_phone_number, $medical_record_number)) {
            $status = ['type' => 'success', 'message' => 'Registration Successful! Please Sign In.', 'icon' => 'fas fa-check-circle'];
            header('Location: views/auth/loginPatient.php');
        } else {
            $status = ['type' => 'error', 'message' => 'Registration Failed!', 'icon' => 'fas fa-times-circle'];
            header('Location: views/auth/registerPatient.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Register Status</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

    <?php if ($status): ?>
        <!-- Modal for Success or Error -->
        <div id="statusModal" class="modal" style="display: block;">
            <div class="modal-content">
                <!-- Close Button with Font Awesome -->
                <i class="fas fa-times close" onclick="closeModal()"></i>
                
                <div class="status-message <?php echo $status['type']; ?>">
                    <i class="<?php echo $status['icon']; ?> icon"></i>
                    <?php echo $status['message']; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        function closeModal() {
            document.getElementById("statusModal").style.display = "none";
        }
    </script>
</body>
</html>
