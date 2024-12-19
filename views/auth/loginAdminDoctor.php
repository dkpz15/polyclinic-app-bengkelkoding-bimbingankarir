<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Doctor Sign In</title>
    <link rel="icon" href="../../assets/img/favicon.png">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-image: url('../../assets/img/blog3.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .login-container {
            background: #ffffff;
            padding: 20px 30px;
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
        }

        .form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .input-field, .select-field {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }

        .btn-submit {
            padding: 10px;
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
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin | Doctor Sign In</h1>
        <form action="../../routes.php" method="POST" class="form" id="loginForm">
            <input type="hidden" name="action" value="login_admin_doctor">

            <!-- Role Selection -->
            <select name="role" id="roleSelector" class="select-field" required>
                <option value="admin" selected>Admin</option>
                <option value="doctor">Doctor</option>
            </select>

            <!-- Name Field -->
            <input type="text" name="name" id="nameField" placeholder="Name" required class="input-field">

            <!-- Password Field -->
            <input type="password" name="password" id="passwordField" placeholder="Password" required class="input-field">

            <!-- Doctor-Specific Fields -->
            <input type="text" name="address" id="addressField" placeholder="Address" class="input-field hidden">
            <input type="text" name="mobile_phone_number" id="mobilePhoneField" placeholder="Mobile Phone Number" class="input-field hidden">

            <!-- Poly ID Dropdown -->
            <select name="poly_id" id="polyField" class="select-field hidden">
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

    <script>
        // JavaScript to toggle form fields based on selected role
        const roleSelector = document.getElementById('roleSelector');
        const addressField = document.getElementById('addressField');
        const mobilePhoneField = document.getElementById('mobilePhoneField');
        const polyField = document.getElementById('polyField');

        roleSelector.addEventListener('input', function () {
            const role = this.value;

            if (role === 'doctor') {
                // Show doctor-specific fields
                addressField.classList.remove('hidden');
                mobilePhoneField.classList.remove('hidden');
                polyField.classList.remove('hidden');
            } else {
                // Hide doctor-specific fields
                addressField.classList.add('hidden');
                mobilePhoneField.classList.add('hidden');
                polyField.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
