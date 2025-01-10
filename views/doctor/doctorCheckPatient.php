<?php
session_start();
include '../../config/database.php';
include '../../models_controllers/doctorCheckPatientController.php';

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: ../auth/doctorAdminSignIn.php');
    exit;
}

$doctorName = $_SESSION['doctor_name'];

$doctorId = $_SESSION['doctor_id'];
$patients = getPatientsRegisteredForPoly($conn, $doctorId);

$stmt = $conn->prepare("SELECT status FROM doctor WHERE id = ?");
$stmt->bind_param("i", $doctorId);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();

$sweetAlert2DoctorCheckPatient = '';

if ($doctor['status'] === 'active' && !isset($_GET['alert_shown'])) {
    $sweetAlert2DoctorCheckPatient =  
        "Swal.fire({
            icon: 'success',
            title: 'Access Granted',
            text: 'You are authorized to check patients because your status are active.'
        }).then(() => {
            window.location.href = 'doctorCheckPatient.php?alert_shown=1';
        });";
} else if ($doctor['status'] === 'inactive') {
    $sweetAlert2DoctorCheckPatient =  
        "Swal.fire({
            icon: 'error',
            title: 'Access Denied',
            text: 'You are not authorized to check patients because your status are inactive.'
        }).then(() => {
            window.location.href = 'dashboard.php';
        });";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    if (isset($_POST['doctor_check_patient'])) {
        $poly_list_id = $_POST['poly_list_id'];
        $notes = $_POST['notes'];
        $medicine_ids = $_POST['medicine_ids'];

        // Calculate the checkup fee
        $check_fee = 150000; // Base fee
        foreach ($medicine_ids as $medicine_id) {
            $query = "SELECT price FROM medicine WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $medicine_id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $check_fee += $result['price'];
        }

        if (addCheck($conn, $poly_list_id, implode(', ', $notes), $check_fee)) {
            $sweetAlert2DoctorCheckPatient = 
                "Swal.fire({
                    title: 'Success!',
                    text: 'Patient checkup recorded successfully.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'doctorCheckPatient.php';
                });";
        } else {
            $sweetAlert2DoctorCheckPatient = 
                "Swal.fire({
                    title: 'Error!',
                    text: 'Record patient checkup failed.',
                    icon: 'error'
                }).then(() => {
                    window.location.href = 'doctorCheckPatient.php';
                });";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Doctor Check Patient</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Doctor Check Patient" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="Doctor Check Patient."
    />
    <meta
      name="keywords"
      content="Doctor Check Patient"
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

        .btn-doctor-check-patient::before{
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
                        <li class="nav-item sidebar-item active">
                            <a href="doctorCheckPatient.php" class="nav-link sidebar-link">
                                <i class="nav-icon bi bi-calendar2-check text-primary color-i"></i>
                                <p class="color-p" style="font-weight: 500;">Check Patient</p>
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
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Check Patient</a></li>
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
                        <span class="d-none d-md-inline" style="text-transform: capitalize;font-weight: 500"><?= htmlspecialchars($doctorName); ?></span>
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
                                <h2 class="mt-4">Check Patient</h2>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="px-3 py-2">Patient Name</th>
                                            <th class="px-3 py-2">Complaint</th>
                                            <th class="px-3 py-2">Queue Number</th>
                                            <th class="px-3 py-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $patients->fetch_assoc()) { ?>
                                            <tr>
                                                <td class="px-2 py-2"><?= $row['patient_name'] ?></td>
                                                <td class="px-2 py-2"><?= $row['complaint'] ?></td>
                                                <td class="px-2 py-2"><?= $row['queue_number'] ?></td>
                                                <td class="px-2 py-2">
                                                    <form method="POST" action="doctorCheckPatient.php">
                                                        <input type="hidden" name="poly_list_id" value="<?= $row['poly_list_id'] ?>">

                                                        <div id="medicine-container">
                                                            <div class="form">
                                                                <label for="medicine-select">Select Medicine :</label><br/>
                                                                <select id="medicine-select" class="px-2 py-2 w-100" required>
                                                                    <option value="" selected disabled>Select Medicine</option>
                                                                    <?php
                                                                    $query = "SELECT id, medicine_name, price FROM medicine";
                                                                    $result = $conn->query($query);
                                                                    while ($medicine = $result->fetch_assoc()) {
                                                                        $formatted_price = number_format($medicine['price'], 0, ',', '.'); 
                                                                        echo "<option value='{$medicine['id']}' data-price='{$medicine['price']}'>
                                                                                {$medicine['medicine_name']} | Price: {$formatted_price}
                                                                            </option>";
                                                                    }
                                                                    ?>
                                                                </select><br/>
                                                                <button type="button" id="add-medicine" class="btn btn-add btn-doctor-check-patient btn-primary mt-3">Add Medicine</button>
                                                            </div>
                                                        </div>

                                                        <div id="added-medicines"></div>

                                                        <div class="form mt-3">
                                                            <label>Total Checkup Fee :</label>
                                                            <input type="text" name="medicine_prices[]" id="total-fee" class="px-2 py-2" value="<?= number_format(150000, 0, ',', '.')?>" disabled>
                                                        </div>

                                                        <button type="submit" name="doctor_check_patient" class="btn btn-add btn-doctor-check-patient btn-success mt-3">Check</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>          
                                <p class="p-copyright pb-3"></p>
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
        <?= $sweetAlert2DoctorCheckPatient ?>
        
        $(document).ready(function () {
            let baseFee = 150000;
            let totalFee = baseFee;

            $('#add-medicine').click(function () {
                const selectedOption = $('#medicine-select option:selected');
                const medicineId = selectedOption.val();
                const medicineName = selectedOption.text().split('|')[0].trim();
                const medicinePrice = parseInt(selectedOption.data('price'));

                if (medicineId && !$('#medicine-' + medicineId).length) {
                    const newMedicine = `
                        <div class="medicine-item" id="medicine-${medicineId}">
                            <input type="hidden" name="medicine_ids[]" value="${medicineId}">
                            <div class="form">
                                <label class="mt-4">Medicine :</label><br/>
                                <input type="text" name="medicine_names[]"class="px-2 py-2 w-100" value="${medicineName}" disabled>
                            </div>
                            <div class="form">
                                <label class="mt-2">Medicine Notes:</label>
                                <textarea name="notes[]" class="px-2 py-2" style="min-height: 150px;" required></textarea>
                            </div>
                            <button type="button" class="btn btn-delete btn-doctor-check-patient btn-danger remove-medicine mt-2" data-id="${medicineId}" data-price="${medicinePrice}">
                                Remove
                            </button>
                        </div>
                        <hr>
                    `;
                    $('#added-medicines').append(newMedicine);
                    totalFee += medicinePrice;
                    updateTotalFee();
                }
            });

            $(document).on('click', '.remove-medicine', function () {
                const medicineId = $(this).data('id');
                const medicinePrice = $(this).data('price');
                $('#medicine-' + medicineId).remove();
                totalFee -= medicinePrice;
                updateTotalFee();
            });

            function updateTotalFee() {
                const formattedFee = totalFee.toLocaleString('en-DE');
                $('#total-fee').val(formattedFee);
            }
        });

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

