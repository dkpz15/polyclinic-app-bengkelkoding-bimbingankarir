<?php
// Start session and include necessary files
session_start();
include '../../config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            padding: 30px;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
        }
        .card-body {
            padding: 20px;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar .navbar-brand,
        .navbar .nav-link {
            color: #fff;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="doctorManage.php">
                        <i class="fas fa-user-md"></i> Doctors
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="patientManage.php">
                        <i class="fas fa-users"></i> Patients
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="polyManage.php">
                        <i class="fas fa-cogs"></i> Polies
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="medicineManage.php">
                        <i class="fas fa-pills"></i> Medicines
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="container">
                <h1 class="mb-4">Welcome to the Admin Dashboard</h1>
                
                <!-- Dashboard Cards -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-user-md"></i> Doctors
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Manage Doctors</h5>
                                <p class="card-text">View, add, edit, or delete Doctors.</p>
                                <a href="doctorManage.php" class="btn btn-primary">Go to Doctors</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-users"></i> Patients
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Manage Patients</h5>
                                <p class="card-text">View, edit, or delete Patients.</p>
                                <a href="patientManage.php" class="btn btn-primary">Go to Patients</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-cogs"></i> Polies
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Manage Polies</h5>
                                <p class="card-text">View, add, edit, or delete Polies.</p>
                                <a href="polyManage.php" class="btn btn-primary">Go to Polies</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-pills"></i> Medicines
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Manage Medicines</h5>
                                <p class="card-text">View, add, edit, or delete Medicines.</p>
                                <a href="polyManage.php" class="btn btn-primary">Go to Medicines</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity or Alerts (Optional) -->
                <div class="card mt-4">
                    <div class="card-header">
                        <i class="fas fa-bell"></i> Recent Activity
                    </div>
                    <div class="card-body">
                        <p>There are no recent activities yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS, Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
