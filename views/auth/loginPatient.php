<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Sign In</title>
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
            background-image: url('../../assets/img/blog2.jpg'); /* Ganti dengan path gambar Anda */
            background-size: cover; /* Pastikan gambar memenuhi seluruh layar */
            background-repeat: no-repeat; /* Hindari pengulangan gambar */
            background-position: center; /* Pusatkan gambar */
            box-shadow: inset 10px 10px 10px rgba(0, 0, 0, 0.1);
        }

        .login-container, .register-container {
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

        .input-field {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            width: 94%;
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

        .form-footer {
            margin-top: 15px;
            font-size: 14px;
            color: #666666;
        }

        .link {
            color: #007bff;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Patient Sign In</h1>
        <form action="../../routes.php" method="POST" class="form">
            <input type="hidden" name="action" value="login_patient">
            <input type="text" name="name" placeholder="Name" required class="input-field">
            <input type="password" name="password" placeholder="Password" required class="input-field">
            <button type="submit" class="btn-submit">Sign In</button>
        </form>
    </div>
</body>
</html>
