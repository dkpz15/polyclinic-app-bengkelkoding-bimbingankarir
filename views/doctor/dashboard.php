<?php
session_start();
include '../../config/database.php';

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: ../auth/doctorAdminSignIn.php');
    exit;
}

$doctorName = $_SESSION['doctor_name'];
?>

<!DOCTYPE html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Doctor Dashboard</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Doctor Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="Doctor Dashboard."
    />
    <meta
      name="keywords"
      content="Doctor Dashboard"
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

        .btn-dashboard::before{
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
          margin-top: 358px;
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
                        <li class="nav-item sidebar-item active">
                            <a href="dashboard.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-speedometer text-primary color-i"></i>
                                <p class="color-p" style="font-weight: 500;">Dashboard</p>
                            </a>
                        <li class="nav-item sidebar-item">
                            <a href="doctorProfileUpdate.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-person-square text-primary"></i>
                                <p style="font-weight: 500;">Update Data</p>
                            </a>
                        </li>
                        <li class="nav-item sidebar-item">
                            <a href="doctorInputSchedule.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-credit-card-2-back text-primary"></i>
                                <p style="font-weight: 500;">Check Schedule Input</p>
                            </a>
                        </li>
                        <li class="nav-item sidebar-item">
                            <a href="doctorCheckPatient.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-calendar2-check text-primary"></i>
                                <p style="font-weight: 500;">Check Patient</p>
                            </a>
                        </li>
                        <li class="nav-item sidebar-item">
                            <a href="doctorPatientsHistory.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-clock-history text-primary"></i>
                                <p style="font-weight: 500;">Patients History</p>
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
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Doctor Dashboard</a></li>
                </ul>
                <!--end::Start Navbar Links-->
                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img
                        src="../../assets/img/doctor-profile.jpg"
                        class="user-image rounded-circle shadow"
                        alt="User Image"
                        />
                        <span class="d-none d-md-inline" style="text-transform: capitalize; font-weight: 500"><?= htmlspecialchars($doctorName); ?></span>
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
                                <main class="app-main">
                                <!--begin::App Content Header-->
                                <div class="app-content-header">
                                  <!--begin::Container-->
                                  <div class="container-fluid">
                                    <!--begin::Row-->
                                    <div class="row">
                                      <div class="col-sm-6">
                                        <h3 class="mb-0">
                                            Welcome, <span style="text-transform: capitalize;"><?= htmlspecialchars($doctorName); ?></span>!
                                        </h3>
                                      </div>
                                      <div class="col-sm-6">
                                      </div>
                                    </div>
                                    <!--end::Row-->
                                  </div>
                                  <!--end::Container-->
                                </div>
                                <!--end::App Content Header-->
                                <!--begin::App Content-->
                                <div class="app-content">
                                  <!--begin::Container-->
                                  <div class="container-fluid">
                                    <!--begin::Row-->
                                    <div class="row">
                                      <!--begin::Col-->
                                      <div class="col-lg-3 col-6">
                                        <!--begin::Small Box Widget 1-->
                                        <div class="small-box text-bg-primary">
                                          <div class="inner">
                                            <h3>150</h3>
                                            <p>New Orders</p>
                                          </div>
                                          <svg
                                            class="small-box-icon"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                            aria-hidden="true"
                                          >
                                            <path
                                              d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                                            ></path>
                                          </svg>
                                          <a
                                            href="#"
                                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                                          >
                                            More info <i class="bi bi-link-45deg"></i>
                                          </a>
                                        </div>
                                        <!--end::Small Box Widget 1-->
                                      </div>
                                      <!--end::Col-->
                                      <div class="col-lg-3 col-6">
                                        <!--begin::Small Box Widget 2-->
                                        <div class="small-box text-bg-success">
                                          <div class="inner">
                                            <h3>53<sup class="fs-5">%</sup></h3>
                                            <p>Bounce Rate</p>
                                          </div>
                                          <svg
                                            class="small-box-icon"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                            aria-hidden="true"
                                          >
                                            <path
                                              d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"
                                            ></path>
                                          </svg>
                                          <a
                                            href="#"
                                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                                          >
                                            More info <i class="bi bi-link-45deg"></i>
                                          </a>
                                        </div>
                                        <!--end::Small Box Widget 2-->
                                      </div>
                                      <!--end::Col-->
                                      <div class="col-lg-3 col-6">
                                        <!--begin::Small Box Widget 3-->
                                        <div class="small-box text-bg-warning">
                                          <div class="inner">
                                            <h3>44</h3>
                                            <p>User Registrations</p>
                                          </div>
                                          <svg
                                            class="small-box-icon"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                            aria-hidden="true"
                                          >
                                            <path
                                              d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"
                                            ></path>
                                          </svg>
                                          <a
                                            href="#"
                                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
                                          >
                                            More info <i class="bi bi-link-45deg"></i>
                                          </a>
                                        </div>
                                        <!--end::Small Box Widget 3-->
                                      </div>
                                      <!--end::Col-->
                                      <div class="col-lg-3 col-6">
                                        <!--begin::Small Box Widget 4-->
                                        <div class="small-box text-bg-danger">
                                          <div class="inner">
                                            <h3>65</h3>
                                            <p>Unique Visitors</p>
                                          </div>
                                          <svg
                                            class="small-box-icon"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                            aria-hidden="true"
                                          >
                                            <path
                                              clip-rule="evenodd"
                                              fill-rule="evenodd"
                                              d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
                                            ></path>
                                            <path
                                              clip-rule="evenodd"
                                              fill-rule="evenodd"
                                              d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
                                            ></path>
                                          </svg>
                                          <a
                                            href="#"
                                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                                          >
                                            More info <i class="bi bi-link-45deg"></i>
                                          </a>
                                        </div>
                                        <!--end::Small Box Widget 4-->
                                      </div>
                                      <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <!-- /.row (main row) -->
                                  <p class="p-copyright"></p>
                                  </div>
                                  <!--end::Container-->
                                </div>
                                <!--end::App Content-->
                              </main>
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

