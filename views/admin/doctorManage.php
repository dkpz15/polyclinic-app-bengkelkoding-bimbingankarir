<?php
session_start();
include '../../config/database.php';
include '../../models_controllers/doctorController.php';
include '../../models_controllers/polyController.php';

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: ../auth/doctorAdminSignIn.php');
    exit;
}

$adminName = $_SESSION['admin_name'];

$doctors = fetchDoctors($conn);

$sql = "SELECT * FROM poly";
$polies = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

$sweetAlert2DoctorManage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addDoctor'])) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $mobile_phone_number = $_POST['mobile_phone_number'];
        $poly_id = $_POST['poly_id'];

        if (addDoctor($conn, $name, $password, $address, $mobile_phone_number, $poly_id)) {
            $sweetAlert2DoctorManage = 
                "Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Doctor added successfully.'
                }).then(() => {
                    window.location.href = 'doctorManage.php';
                });";
        } else {
            $sweetAlert2DoctorManage = 
                "Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Add doctor failed.'
                });
            ";
        }
    }
    else if (isset($_POST['editDoctor'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $mobile_phone_number = $_POST['mobile_phone_number'];
        $poly_id = $_POST['poly_id'];

        if (editDoctor($conn, $id, $name, $password, $address, $mobile_phone_number, $poly_id)) {
            $sweetAlert2DoctorManage = 
                "Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Doctor updated successfully.'
                }).then(() => {
                    window.location.href = 'doctorManage.php';
                });
            ";
        } else {
            $sweetAlert2DoctorManage = 
                "Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Update doctor failed.'
                });
            ";
        }
    }

    else if (isset($_POST['deleteDoctor'])) {
        $id = $_POST['id'];

        if (deleteDoctor($conn, $id)) {
            $sweetAlert2DoctorManage = "
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Doctor deleted successfully.'
                }).then(() => {
                    window.location.href = 'doctorManage.php';
                });
            ";
        } else {
            $sweetAlert2DoctorManage = 
                "Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Delete doctor failed.'
                });
            ";
        }
    } else if (isset($_POST['doctor_toggle_status'])) {
        $doctorId = $_POST['doctor_id'];
        $new_status = $_POST['status'] == 'active' ? 'inactive' : 'active';
        
        if ($new_status == 'active') {
            setInactiveForOtherDoctors($conn);
        }

        if (updateDoctorStatus($conn, $doctorId, $new_status)) {
            $sweetAlert2DoctorManage = 
                "Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Doctor status updated successfully.'
                }).then(() => {
                    window.location.href = 'doctorManage.php';
                });
            ";
        } else {
            $sweetAlert2DoctorManage = 
                "Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Update doctor status failed.'
                }).then(() => {
                    window.location.href = 'doctorManage.php';
                });
            ";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Doctor Management</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Doctor Management" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="Doctor Management."
    />
    <meta
      name="keywords"
      content="Doctor Management"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
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
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../../assets/css/dashboard.css" />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
    <style>
        body{
            overflow-x: hidden;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        .app-header{
            position: sticky !important;
            top: 0;
            z-index: 2;
        }
        .app-sidebar{
            position: fixed !important ;
            top: 0;
            left: 0;
            z-index: 3;
            background-color: white;
            transition : 0.3s linear;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1em;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            border: 1px solid #ddd;
        }

        table th {
            background-color: #0d6efd !important;
            color: #fff !important;
        }

        .btn-doctor::before{
            transition : 0s linear !important;
        }
        .btn-doctor-toggle-status:hover::before{
            background-color: transparent !important;
            opacity: 0;
        }
        .btn-add:hover::before, .btn-add-add-modal:hover::before, .btn-update-edit-modal:hover::before{
            background-color: #0d6efd !important;
            opacity: 0;
        }
        .btn-edit:hover::before{
            background-color: #ffc107 !important;
            opacity: 0;
        }
        .btn-delete:hover::before{
            background-color:#dc3545 !important;
            opacity: 0;
        }
        .btn-close-add-modal:hover::before, .btn-close-edit-modal:hover::before{
            background-color:#6c757d !important;
            opacity: 0;
        }
        .active{
            background-color: #0d6efd !important;
        }
        .sidebar-item:hover{
            background-color:rgb(244, 246, 249);
        }
        .color-i{
            color: #fff !important;
        }
        .color-p{
            color: #fff !important;
        }
        .p-copyright{
          font-weight: 500;
        }
    </style>
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
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

    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <div class="row w-100 position-absolute" style="margin: 0; max-width: 100%;">
            <div class="col-lg-2 div-one">
                <aside class="app-sidebar shadow" data-bs-theme="white">
                    <!--begin::Sidebar Brand-->
                    <div class="sidebar-brand">
                    <!--begin::Brand Link-->
                        <div class="logo">
                            <a href="#"><img src="../../assets/img/logo1.png" alt="#"></a>
                        </div>
                    <!--end::Brand Link-->
                    </div>
                    <!--end::Sidebar Brand-->
                    <!--begin::Sidebar Wrapper-->
                    <div class="sidebar-wrapper">
                    <nav class="mt-2">
                        <!--begin::Sidebar Menu-->
                        <ul
                        class="nav sidebar-menu flex-column"
                        data-lte-toggle="treeview"
                        role="menu"
                        data-accordion="false"
                        >
                        <li class="nav-item sidebar-item">
                            <a href="dashboard.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-speedometer text-primary"></i>
                                <p style="font-weight: 500;">Dashboard</p>
                            </a>
                        <li class="nav-item sidebar-item active">
                            <a href="doctorManage.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-person-fill-gear text-primary color-i"></i>
                                <p class="color-p" style="font-weight: 500;">Doctors</p>
                            </a>
                        </li>
                        <li class="nav-item sidebar-item">
                            <a href="patientManage.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-people-fill text-primary"></i>
                                <p style="font-weight: 500;">Patients</p>
                            </a>
                        </li>
                        <li class="nav-item sidebar-item">
                            <a href="polyManage.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-house-fill text-primary"></i>
                                <p style="font-weight: 500;">Polies</p>
                            </a>
                        </li>
                        <li class="nav-item sidebar-item">
                            <a href="medicineManage.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-capsule-pill text-primary"></i>
                                <p style="font-weight: 500;">Medicines</p>
                            </a>
                        </li>
                        <li class="nav-item sidebar-item sign-out-sidebar">
                            <a href="../auth/signOut.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-box-arrow-right text-primary"></i>
                                <p style="font-weight: 500;">Sign Out</p>
                            </a>
                        </li>
                        </ul>
                        <!--end::Sidebar Menu-->
                    </nav>
                    </div>
                    <!--end::Sidebar Wrapper-->
                </aside>
            </div>
            <div class="col-lg-10 div-two">
                <nav class="app-header navbar navbar-expand bg-body">
                <!--begin::Container-->
                <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item nav-button-sidebar">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Doctor Management</a></li>
                </ul>
                <!--end::Start Navbar Links-->
                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img
                        src="../../assets/img/admin-profile.jpg"
                        class="user-image rounded-circle shadow"
                        alt="User Image"
                        />
                        <span class="d-none d-md-inline" style="text-transform: capitalize;font-weight: 500"><?= htmlspecialchars($adminName); ?></span>
                    </a>
                <!--end::End Navbar Links-->
                </div>
                <!--end::Container-->
            </nav>
            <!--end::Header-->
            <!--begin::Sidebar-->
            
            <!--end::Sidebar-->
            <!--begin::App Main-->
                    <div class="container-fluid pe-5 w-100">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                    <h2 class="mt-4">Manage Doctors</h2>
                                    <button class="btn btn-add btn-doctor btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addDoctorModal">Add Doctor</button>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="px-3 py-2">Name</th>
                                                <th class="px-3 py-2">Password</th>
                                                <th class="px-3 py-2">Address</th>
                                                <th class="px-3 py-2">Mobile Phone Number</th>
                                                <th class="px-3 py-2">Poly Id</th>
                                                <th class="px-3 py-2">Status</th>
                                                <th class="px-3 py-2">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($doctors as $doctor): ?>
                                            <tr>
                                                <td><?= $doctor['name'] ?></td>
                                                <td><?= $doctor['password'] ?></td>
                                                <td><?= $doctor['address'] ?></td>
                                                <td><?= $doctor['mobile_phone_number'] ?></td>
                                                <td><?= $doctor['poly_id'] ?></td>
                                                <td>
                                                    <form method="POST" action="doctorManage.php">
                                                        <input type="hidden" name="doctor_id" value="<?= $doctor['id'] ?>">
                                                        <input type="hidden" name="status" value="<?= $doctor['status'] ?>">
                                                        <button type="submit" name="doctor_toggle_status" class="btn btn-doctor btn-doctor-toggle-status">
                                                            <span class="badge <?= $doctor['status'] == 'active' ? 'bg-success' : 'bg-danger' ?>">
                                                                <?= ucfirst($doctor['status']) ?>
                                                            </span>
                                                        </button>
                                                    </form>
                                                    
                                                </td>
                                                <td class="d-flex justify-content-center gap-1">
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-edit btn-doctor btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDoctorModal" 
                                                        data-id="<?= $doctor['id'] ?>" 
                                                        data-name="<?= $doctor['name'] ?>" 
                                                        data-password="<?= $doctor['password'] ?>" 
                                                        data-address="<?= $doctor['address'] ?>" 
                                                        data-mobile-phone-number="<?= $doctor['mobile_phone_number'] ?>" 
                                                        data-poly-id="<?= $doctor['poly_id'] ?>">Edit</button>

                                                    <!-- Delete Button -->
                                                    <form action="doctorManage.php" class="form-delete" method="POST" style="display:inline;">
                                                        <input type="hidden" name="id" value="<?= $doctor['id'] ?>">
                                                        <button type="submit" name="deleteDoctor" class="btn btn-delete btn-doctor btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <p class="p-copyright pb-3"></p>
                                </div>

                                <!-- Add Doctor Modal -->
                                <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="doctorManage.php" class="form-add" method="POST">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addDoctorLabel">Add Doctor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="addName" class="form-label">Name</label>
                                                        <input type="text" class="form-control px-2 py-2" id="addName" name="name" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="addPassword" class="form-label">Password</label>
                                                        <input type="password" class="form-control px-2 py-2" id="addPassword" name="password" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="addAddress" class="form-label">Address</label>
                                                        <input type="text" class="form-control px-2 py-2" id="addAddress" name="address" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="addMobilePhoneNumber" class="form-label">Mobile Phone Number</label>
                                                        <input type="number" class="form-control px-2 py-2" id="addMobilePhoneNumber" name="mobile_phone_number" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="addPolyId" class="form-label">Poly ID</label>
                                                        <select class="form-select px-2 py-2" id="addPolyId" name="poly_id" required>
                                                            <option value="" disabled selected>Select a Poly ID</option>
                                                            <?php foreach ($polies as $poly): ?>
                                                                <option value="<?= $poly['id'] ?>"><?= $poly['poly_name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-close-add-modal btn-doctor btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="addDoctor" class="btn btn-add-add-modal btn-doctor btn-primary">Add</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Edit Doctor Modal -->
                                <div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="doctorManage.php" class="form-edit" method="POST">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editDoctorLabel">Edit Doctor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" id="editId" name="id">
                                                    <div class="mb-3">
                                                        <label for="editName" class="form-label">Name</label>
                                                        <input type="text" class="form-control px-2 py-2" id="editName" name="name" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editPassword" class="form-label">Password</label>
                                                        <input type="password" class="form-control px-2 py-2" id="editPassword" name="password" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editAddress" class="form-label">Address</label>
                                                        <input type="text" class="form-control px-2 py-2" id="editAddress" name="address" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editMobilePhoneNumber" class="form-label">Mobile Phone Number</label>
                                                        <input type="number" class="form-control px-2 py-2" id="editMobilePhoneNumber" name="mobile_phone_number" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editPolyId" class="form-label">Poly ID</label>
                                                        <select class="form-select px-2 py-2" id="editPolyId" name="poly_id" required>
                                                            <option value="" disabled>Select a Poly ID</option>
                                                            <?php foreach ($polies as $poly): ?>
                                                                <option value="<?= $poly['id'] ?>"><?= $poly['poly_name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-close-edit-modal btn-doctor btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="editDoctor" class="btn btn-update-edit-modal btn-doctor btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <script src="../../assets/js/bootstrap.min.js"></script>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/jquery.magnific-popup.min.js"></script>
    <script src="../../assets/js/main.js"></script>
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../../assets/js/dashboard.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        <?= $sweetAlert2DoctorManage ?>
        
        document.addEventListener('DOMContentLoaded', function () {
            if(document.body.classList.contains("sidebar-open")){
                    const divOne = document.querySelector(".div-one");
                    const divTwo = document.querySelector(".div-two");
                    
                    divOne.classList.remove("col-lg-0");
                    divOne.classList.add("col-lg-2");
                    divTwo.classList.remove("col-lg-12");
                    divTwo.classList.add("col-lg-10");
                }
                else if(document.body.classList.contains("sidebar-collapse")){
                    const divOne = document.querySelector(".div-one");
                    const divTwo = document.querySelector(".div-two");
                    
                    divOne.classList.remove("col-lg-2");
                    divOne.classList.add("col-lg-0");
                    divTwo.classList.remove("col-lg-10");
                    divTwo.classList.add("col-lg-12");
                }
            const navButtonSidebar = document.querySelector(".nav-button-sidebar");
            navButtonSidebar.addEventListener("click", function(){
                if(document.body.classList.contains("sidebar-open")){
                    const divOne = document.querySelector(".div-one");
                    const divTwo = document.querySelector(".div-two");
                    
                    divOne.classList.remove("col-lg-0");
                    divOne.classList.add("col-lg-2");
                    divTwo.classList.remove("col-lg-12");
                    divTwo.classList.add("col-lg-10");
                }
                else if(document.body.classList.contains("sidebar-collapse")){
                    const divOne = document.querySelector(".div-one");
                    const divTwo = document.querySelector(".div-two");
                    
                    divOne.classList.remove("col-lg-2");
                    divOne.classList.add("col-lg-0");
                    divTwo.classList.remove("col-lg-10");
                    divTwo.classList.add("col-lg-12");
                }
            });
        });
        

        const sidebarItem = Array.from(document.querySelectorAll(".sidebar-item"));
        sidebarItem.map((item) => {
            item.addEventListener("mouseover", function() {
                if(this.classList.contains("active")){
                    this.classList.add("active");
                    this.childNodes[1].firstElementChild.classList.add("color-i");
                    this.childNodes[1].lastElementChild.classList.add("color-p");
                }
            });
            item.addEventListener("click", function() {
                removeBackgroundColor();
                removeColorI();
                removeColorP();

                this.classList.add("active");
                this.childNodes[1].firstElementChild.classList.add("color-i");
                this.childNodes[1].lastElementChild.classList.add("color-p");
            });
        });

        function removeBackgroundColor(){
            sidebarItem.map((item) => {
                item.classList.remove("active");
            });
        }

        function removeColorI(){
            sidebarItem.map((item) => {
                item.childNodes[1].firstElementChild.classList.remove("color-i");
            });
        }

        function removeColorP(){
            sidebarItem.map((item) => {
                item.childNodes[1].lastElementChild.classList.remove("color-p");
            });
        }  

        const signOutSidebar = document.querySelector(".sign-out-sidebar");
        signOutSidebar.addEventListener("click", function (event) {
            event.preventDefault();

            Swal.fire({
            title: "Are you sure?",
            text: "You will be signed out.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, sign me out!",
            cancelButtonText: "No, stay signed in."
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../auth/signOut.php";
            }
            else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                title: "Cancelled!",
                text: "You are still signed in.",
                icon: "info",
                showConfirmButton: true
                });
            }
            });
        });

        const editDoctorModal = document.querySelector('#editDoctorModal');
        editDoctorModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const password = button.getAttribute('data-password');
            const address = button.getAttribute('data-address');
            const mobilePhoneNumber = button.getAttribute('data-mobile-phone-number');
            const polyId = button.getAttribute('data-poly-id');

            const modalId = document.querySelector('#editId');
            const modalName = document.querySelector('#editName');
            const modalPassword = document.querySelector('#editPassword');
            const modalAddress = document.querySelector('#editAddress');
            const modalMobilePhoneNumber = document.querySelector('#editMobilePhoneNumber');
            const modalPolyId = document.querySelector('#editPolyId');

            modalId.value = id;
            modalName.value = name;
            modalPassword.value = password;
            modalAddress.value = address;
            modalMobilePhoneNumber.value = mobilePhoneNumber;

            Array.from(modalPolyId.options).forEach(function (option) {
                option.selected = (option.value == polyId);
            });
        });

        const getYear = new Date().getFullYear();
		const getPCopyright = document.querySelector(".p-copyright");
		getPCopyright.innerHTML = `© Copyright ${getYear}  |  All Rights Reserved by Darren Marcellino Setiawan`;

        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                theme: Default.scrollbarTheme,
                autoHide: Default.scrollbarAutoHide,
                clickScroll: Default.scrollbarClickScroll,
                },
            });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>

