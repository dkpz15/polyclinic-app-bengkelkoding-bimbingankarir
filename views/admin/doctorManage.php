<?php
include '../../config/database.php';
include '../../controllers/doctorController.php';

// Fetch all doctors
$doctors = fetchDoctors($conn);

// Fetch all polies
$sql = "SELECT * FROM poly";
$polies = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

// Handle Add, Edit, and Delete requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addDoctor'])) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $mobile_phone_number = $_POST['mobile_phone_number'];
        $poly_id = $_POST['poly_id'];

        if (addDoctor($conn, $name, $password, $address, $mobile_phone_number, $poly_id)) {
            header('Location: doctorManage.php');
        } else {
            echo "Error adding doctor.";
        }
    }

    if (isset($_POST['editDoctor'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $mobile_phone_number = $_POST['mobile_phone_number'];
        $poly_id = $_POST['poly_id'];

        if (editDoctor($conn, $id, $name, $password, $address, $mobile_phone_number, $poly_id)) {
            header('Location: doctorManage.php');
        } else {
            echo "Error updating doctor.";
        }
    }

    if (isset($_POST['deleteDoctor'])) {
        $id = $_POST['id'];

        if (deleteDoctor($conn, $id)) {
            header('Location: doctorManage.php');
        } else {
            echo "Error deleting doctor.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Manage Doctors</h2>
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addDoctorModal">Add Doctor</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Password</th>
                <th>Address</th>
                <th>Mobile Phone Number</th>
                <th>Poly ID</th>
                <th>Actions</th>
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
                    <!-- Edit Button -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDoctorModal" 
                        data-id="<?= $doctor['id'] ?>" 
                        data-name="<?= $doctor['name'] ?>" 
                        data-password="<?= $doctor['password'] ?>" 
                        data-address="<?= $doctor['address'] ?>" 
                        data-mobile_phone_number="<?= $doctor['mobile_phone_number'] ?>" 
                        data-poly_id="<?= $doctor['poly_id'] ?>">Edit</button>

                    <!-- Delete Button -->
                    <form action="doctorManage.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $doctor['id'] ?>">
                        <button type="submit" name="deleteDoctor" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Doctor Modal -->
<div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="doctorManage.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDoctorLabel">Add Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                    <div class="mb-3">
                        <label for="mobile_phone_number" class="form-label">Mobile Phone Number</label>
                        <input type="text" class="form-control" id="mobile_phone_number" name="mobile_phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="poly_id" class="form-label">Poly ID</label>
                        <select class="form-select" id="poly_id" name="poly_id" required>
                            <option value="" disabled selected>Select a Poly ID</option>
                            <?php foreach ($polies as $poly): ?>
                                <option value="<?= $poly['id'] ?>"><?= $poly['poly_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="addDoctor" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Doctor Modal -->
<div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="doctorManage.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDoctorLabel">Edit Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editDoctorId" name="id">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="editPassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="editAddress" name="address">
                    </div>
                    <div class="mb-3">
                        <label for="editMobilePhone" class="form-label">Mobile Phone Number</label>
                        <input type="text" class="form-control" id="editMobilePhone" name="mobile_phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPolyId" class="form-label">Poly ID</label>
                        <select class="form-select" id="editPolyId" name="poly_id" required>
                            <option value="" disabled>Select a Poly ID</option>
                            <?php foreach ($polies as $poly): ?>
                                <option value="<?= $poly['id'] ?>"><?= $poly['poly_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="editDoctor" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    // Pre-fill Edit Doctor Modal
    document.getElementById('editDoctorModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var password = button.getAttribute('data-password');
        var address = button.getAttribute('data-address');
        var mobilePhone = button.getAttribute('data-mobile_phone_number');
        var polyId = button.getAttribute('data-poly_id');

        document.getElementById('editDoctorId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editPassword').value = password;
        document.getElementById('editAddress').value = address;
        document.getElementById('editMobilePhone').value = mobilePhone;

        var polySelect = document.getElementById('editPolyId');
        Array.from(polySelect.options).forEach(function (option) {
            option.selected = (option.value == polyId);
        });
    });
</script>
</body>
</html>
