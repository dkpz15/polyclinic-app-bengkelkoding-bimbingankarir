<?php
session_start();
include '../../config/database.php';
include '../../models_controllers/polyController.php';

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: ../auth/doctorAdminSignIn.php');
    exit;
}

$adminName = $_SESSION['admin_name'];

$polies = fetchPolies($conn);

$sweetAlert2PolyManage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addPoly'])) {
        $poly_name = $_POST['poly_name'];
        $description = $_POST['description'];

        if (addPoly($conn, $poly_name, $description)) {
            $sweetAlert2PolyManage = 
                "Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Poly added successfully.'
                }).then(() => {
                    window.location.href = 'polyManage.php';
                });";
        } else {
            $sweetAlert2PolyManage = 
                "Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Add poly failed.',
                });
            ";
        }
    }
    else if (isset($_POST['editPoly'])) {
        $id = $_POST['id'];
        $poly_name = $_POST['poly_name'];
        $description = $_POST['description'];

        if (editPoly($conn, $id, $poly_name, $description)) {
            $sweetAlert2PolyManage = 
                "Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Poly updated successfully.'
                }).then(() => {
                    window.location.href = 'polyManage.php';
                });
            ";
        } else {
            $sweetAlert2PolyManage = 
                "Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Update poly failed.',
                });
            ";
        }
    }

    else if (isset($_POST['deletePoly'])) {
        $id = $_POST['id'];

        if (deletePoly($conn, $id)) {
            $sweetAlert2PolyManage = "
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Poly deleted successfully.'
                }).then(() => {
                    window.location.href = 'polyManage.php';
                });
            ";
        } else {
            $sweetAlert2PolyManage = 
                "Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Delete poly failed.',
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
    <title>Poly Management</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Poly Management" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="Poly Management."
    />
    <meta
      name="keywords"
      content="Poly Management"
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
            z-index: 2;
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

        .btn-poly::before{
            transition : 0s linear !important;
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
                        <li class="nav-item sidebar-item">
                            <a href="doctorManage.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-person-fill-gear text-primary"></i>
                                <p style="font-weight: 500;">Doctors</p>
                            </a>
                        </li>
                        <li class="nav-item sidebar-item">
                            <a href="patientManage.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-people-fill text-primary"></i>
                                <p style="font-weight: 500;">Patients</p>
                            </a>
                        </li>
                        <li class="nav-item sidebar-item active">
                            <a href="polyManage.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-house-fill text-primary color-i"></i>
                                <p class="color-p" style="font-weight: 500;">Polies</p>
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
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Poly Management</a></li>
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
                                    <h2 class="mt-4">Manage Polies</h2>
                                    <button class="btn btn-add btn-poly btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addPolyModal">Add Poly</button>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="px-3 py-2">Poly Name</th>
                                                <th class="px-3 py-2">Description</th>
                                                <th class="px-3 py-2">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($polies as $poly): ?>
                                            <tr>
                                                <td><?= $poly['poly_name'] ?></td>
                                                <td><?= $poly['description'] ?></td>
                                                <td class="d-flex justify-content-center gap-1">
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-edit btn-poly btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPolyModal" 
                                                        data-id="<?= $poly['id'] ?>" 
                                                        data-poly-name="<?= $poly['poly_name'] ?>" 
                                                        data-description="<?= $poly['description'] ?>">Edit</button>

                                                    <!-- Delete Button -->
                                                    <form action="polyManage.php" method="POST" style="display:inline;">
                                                        <input type="hidden" name="id" value="<?= $poly['id'] ?>">
                                                        <button type="submit" name="deletePoly" class="btn btn-delete btn-poly btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <p class="p-copyright pb-3"></p>
                                </div>

                                <!-- Add Poly Modal -->
                                <div class="modal fade" id="addPolyModal" tabindex="-1" aria-labelledby="addPolyLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="polyManage.php" method="POST">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addPolyLabel">Add Poly</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="addPolyName" class="form-label">Poly Name</label>
                                                        <input type="text" class="form-control px-2 py-2" id="addPolyName" name="poly_name" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="addDescription" class="form-label">Description</label>
                                                        <textarea class="form-control px-2 py-2" id="addDescription" name="description" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-close-add-modal btn-poly btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="addPoly" class="btn btn-add-add-modal btn-poly btn-primary">Add</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Edit Poly Modal -->
                                <div class="modal fade" id="editPolyModal" tabindex="-1" aria-labelledby="editPolyLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="polyManage.php" method="POST">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPolyLabel">Edit Poly</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" id="editId" name="id">
                                                    <div class="mb-3">
                                                        <label for="editPolyName" class="form-label">Poly Name</label>
                                                        <input type="text" class="form-control px-2 py-2" id="editPolyName" name="poly_name" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editDescription" class="form-label">Description</label>
                                                        <textarea class="form-control px-2 py-2" id="editDescription" name="description" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-close-edit-modal btn-poly btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="editPoly" class="btn btn-update-edit-modal btn-poly btn-primary">Update</button>
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
        <?= $sweetAlert2PolyManage ?>
        
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

        const editPolyModal = document.querySelector('#editPolyModal');
        editPolyModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const polyName = button.getAttribute('data-poly-name');
            const description = button.getAttribute('data-description');

            const modalId = document.querySelector('#editId');
            const modalPolyName = document.querySelector('#editPolyName');
            const modalDescription = document.querySelector('#editDescription');

            modalId.value = id;
            modalPolyName.value = polyName;
            modalDescription.value = description;
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

