<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In Patient</title>
    <link rel="icon" href="../../assets/img/favicon.png">
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
    rel="stylesheet"
    />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="../../assets/css/nice-select.css" />
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="../../assets/css/font-awesome.min.css" />
    <!-- icofont CSS -->
    <link rel="stylesheet" href="../../assets/css/icofont.css" />
    <!-- Slicknav -->
    <link rel="stylesheet" href="../../assets/css/slicknav.min.css" />
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="../../assets/css/owl-carousel.css" />
    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="../../assets/css/datepicker.css" />
    <!-- Animate CSS -->
    <link rel="stylesheet" href="../../assets/css/animate.min.css" />
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="../../assets/css/magnific-popup.css" />
    <!-- Medipro CSS -->
    <link rel="stylesheet" href="../../assets/css/normalize.css" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="stylesheet" href="../../assets/css/responsive.css" />

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-image: url('../../assets/img/sign-in-1-bg.jpg'); /* Ganti dengan path gambar Anda */
            background-size: cover; /* Pastikan gambar memenuhi seluruh layar */
            background-repeat: no-repeat; /* Hindari pengulangan gambar */
            background-position: center; /* Pusatkan gambar */
            box-shadow: inset 10px 10px 10px rgba(0, 0, 0, 0.1);
        }

        .login-container, .register-container {
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

        .input-field {
            padding: 8px 10px !important;
            font-size: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            width: 100%;
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
        <h1>Sign In Patient</h1>
        <img src="../../assets/img/section-img.png" alt="#">
        <form action="../../routes.php" method="POST" class="form mt-3">
            <input type="hidden" name="action" value="sign_in_patient">
            <input type="text" class="input-field" name="name" placeholder="Name" required>
            <input type="password" class="input-field" name="password" placeholder="Password" required>
            <button type="submit" class="btn-submit">Sign In</button>
        </form>
    </div>
    <script src="../../assets/js/jquery.min.js"></script>
    <!-- jquery Migrate JS -->
    <script src="../../assets/js/jquery-migrate-3.0.0.js"></script>
    <!-- jquery Ui JS -->
    <script src="../../assets/js/jquery-ui.min.js"></script>
    <!-- Easing JS -->
    <script src="../../assets/js/easing.js"></script>
    <!-- Color JS -->
    <script src="../../assets/js/colors.js"></script>
    <!-- Popper JS -->
    <script src="../../assets/js/popper.min.js"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="../../assets/js/bootstrap-datepicker.js"></script>
    <!-- Jquery Nav JS -->
    <script src="../../assets/js/jquery.nav.js"></script>
    <!-- Slicknav JS -->
    <script src="../../assets/js/slicknav.min.js"></script>
    <!-- ScrollUp JS -->
    <script src="../../assets/js/jquery.scrollUp.min.js"></script>
    <!-- Niceselect JS -->
    <script src="../../assets/js/niceselect.js"></script>
    <!-- Tilt Jquery JS -->
    <script src="../../assets/js/tilt.jquery.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="../../assets/js/owl-carousel.js"></script>
    <!-- counterup JS -->
    <script src="../../assets/js/jquery.counterup.min.js"></script>
    <!-- Steller JS -->
    <script src="../../assets/js/steller.js"></script>
    <!-- Wow JS -->
    <script src="../../assets/js/wow.min.js"></script>
    <!-- Magnific Popup JS -->
    <script src="../../assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Counter Up CDN JS -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="../../assets/js/bootstrap.min.js"></script>
    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>
</body>
</html>
