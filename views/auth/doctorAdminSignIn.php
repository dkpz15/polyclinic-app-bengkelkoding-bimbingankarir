<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In Doctor | Admin</title>
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
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-image: url('../../assets/img/sign-in-2-bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .login-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333333;
            font-weight: bold;
        }

        .form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .input-field, .select-field {
            padding: 8px 10px !important;
            font-size: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }

        .btn-submit {
            padding: 12px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .hidden {
            display: none !important;
        }
    </style>
</head>
<body>
        <!-- Preloader -->
        <div class="preloader">
            <div class="loader">
                <div class="loader-outter"></div>
                <div class="loader-inner"></div>

                <div class="indicator"> 
                    <svg width="16px" height="12px">
                        <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                        <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <!-- End Preloader -->
    <div class="login-container">
        <h1>Sign In Doctor | Admin</h1>
        <img src="../../assets/img/section-img.png" alt="#">
        <form action="../../routes.php" method="POST" class="form mt-3" id="loginForm">
            <input type="hidden" name="action" value="sign_in_admin_doctor">

            <!-- Role Selection -->
            <select name="role" id="roleSelector" class="select-field" required>
                <option value="doctor" selected>Doctor</option>
                <option value="admin">Admin</option>
            </select>

            <!-- Name Field -->
            <input type="text" class="input-field" name="name" id="nameField" placeholder="Name" required>

            <!-- Password Field -->
            <input type="password" class="input-field" name="password" id="passwordField" placeholder="Password" required>

            <!-- Doctor-Specific Fields -->
            <input type="text" class="input-field" name="address" id="addressField" placeholder="Address" required>
            <input type="text" class="input-field" name="mobile_phone_number" id="mobilePhoneNumberField" placeholder="Mobile Phone Number" required>

            <!-- Poly ID Dropdown -->
            <select name="poly_id" id="polyIdField" class="select-field" required>
                <option value="" disabled selected>Select Poly</option>
                <?php
                include '../../config/database.php';
                $polyQuery = "SELECT id, poly_name FROM poly";
                $polyResult = $conn->query($polyQuery);
                if ($polyResult && $polyResult->num_rows > 0) {
                    while ($row = $polyResult->fetch_assoc()) {
                        echo "<option value=\"{$row['id']}\">{$row['poly_name']}</option>";
                    }
                }
                ?>
            </select>

            <button type="submit" class="btn-submit">Sign In</button>
        </form>
    </div>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/jquery.magnific-popup.min.js"></script>
    <script src="../../assets/js/main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelector = document.querySelector('#roleSelector');
        const nameField = document.querySelector('#nameField');
        const passwordField = document.querySelector('#passwordField');
        const addressField = document.querySelector('#addressField');
        const mobilePhoneNumberField = document.querySelector('#mobilePhoneNumberField');
        const polyIdField = document.querySelector('#polyIdField');

        const resetFields = () => {
            nameField.value = "";
            passwordField.value = "";
            addressField.value = "";
            mobilePhoneNumberField.value = "";
            polyIdField.value = "";
        };

        const updateFields = () => {
            addressField.removeAttribute('required');
            mobilePhoneNumberField.removeAttribute('required');
            polyIdField.removeAttribute('required');

            const role = roleSelector.value;
            if (role === 'admin') {
                addressField.classList.add('hidden');
                mobilePhoneNumberField.classList.add('hidden');
                polyIdField.classList.add('hidden');
                addressField.value = "";
                mobilePhoneNumberField.value = "";
                polyIdField.value = "";
            } else if (role === 'doctor') {
                addressField.classList.remove('hidden');
                mobilePhoneNumberField.classList.remove('hidden');
                polyIdField.classList.remove('hidden');
                
                addressField.setAttribute('required', 'true');
                mobilePhoneNumberField.setAttribute('required', 'true');
                polyIdField.setAttribute('required', 'true');
            }
        };

        resetFields();
        updateFields();

        roleSelector.addEventListener('input', function () {
            resetFields();
            updateFields();
        });
    });
    </script>
</body>
</html>
