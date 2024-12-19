<?php
include '../../config/database.php';
include '../../controllers/patientController.php';

// Fetch all patients
$patients = fetchPatients($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Manage Patients</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Mobile Phone Number</th>
                <th>Identity Card Number</th>
                <th>Medical Record Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patients as $patient): ?>
            <tr>
                <td><?= $patient['name'] ?></td>
                <td><?= $patient['address'] ?></td>
                <td><?= $patient['mobile_phone_number'] ?></td>
                <td><?= $patient['identity_card_number'] ?></td>
                <td><?= $patient['medical_record_number'] ?></td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPatientModal" 
                        data-id="<?= $patient['id'] ?>"
                        data-name="<?= $patient['name'] ?>"
                        data-address="<?= $patient['address'] ?>"
                        data-phone="<?= $patient['mobile_phone_number'] ?>"
                        data-idcard="<?= $patient['identity_card_number'] ?>"
                        data-record="<?= $patient['medical_record_number'] ?>">Edit</button>
                    
                    <!-- Delete Button -->
                    <a href="../../controllers/patientController.php?delete_id=<?= $patient['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this patient?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Edit Patient Modal -->
<div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="../../controllers/patientController.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPatientLabel">Edit Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="patient_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="edit_address" name="address">
                    </div>
                    <div class="mb-3">
                        <label for="edit_phone" class="form-label">Mobile Phone Number</label>
                        <input type="text" class="form-control" id="edit_phone" name="mobile_phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_idcard" class="form-label">Identity Card Number</label>
                        <input type="text" class="form-control" id="edit_idcard" name="identity_card_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_record" class="form-label">Medical Record Number</label>
                        <input type="text" class="form-control" id="edit_record" name="medical_record_number" required readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    const editPatientModal = document.getElementById('editPatientModal');
    editPatientModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const address = button.getAttribute('data-address');
        const phone = button.getAttribute('data-phone');
        const idcard = button.getAttribute('data-idcard');
        const record = button.getAttribute('data-record');
        
        document.getElementById('patient_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_address').value = address;
        document.getElementById('edit_phone').value = phone;
        document.getElementById('edit_idcard').value = idcard;
        document.getElementById('edit_record').value = record;
    });
</script>

</body>
</html>
