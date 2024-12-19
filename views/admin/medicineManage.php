<?php
include '../../config/database.php';
include '../../controllers/medicineController.php';

// Fetch all medicines
$medicines = fetchMedicines($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Manage Medicines</h2>
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addMedicineModal">Add Medicine</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Medicine Name</th>
                <th>Packaging</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medicines as $medicine): ?>
            <tr>
                <td><?= $medicine['medicine_name'] ?></td>
                <td><?= $medicine['packaging'] ?></td>
                <td><?= number_format($medicine['price'], 0, ',', '.') ?></td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMedicineModal"
                            data-id="<?= $medicine['id'] ?>" data-name="<?= $medicine['medicine_name'] ?>" data-packaging="<?= $medicine['packaging'] ?>" data-price="<?= $medicine['price'] ?>">Edit</button>

                    <!-- Delete Button -->
                    <a href="../../controllers/medicineController.php?delete_id=<?= $medicine['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Medicine Modal -->
<div class="modal fade" id="addMedicineModal" tabindex="-1" aria-labelledby="addMedicineLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="../../controllers/medicineController.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMedicineLabel">Add Medicine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="medicine_name" class="form-label">Medicine Name</label>
                        <input type="text" class="form-control" id="medicine_name" name="medicine_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="packaging" class="form-label">Packaging</label>
                        <input type="text" class="form-control" id="packaging" name="packaging">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Medicine Modal -->
<div class="modal fade" id="editMedicineModal" tabindex="-1" aria-labelledby="editMedicineLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="../../controllers/medicineController.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMedicineLabel">Edit Medicine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="medicine_id">
                    <div class="mb-3">
                        <label for="edit_medicine_name" class="form-label">Medicine Name</label>
                        <input type="text" class="form-control" id="edit_medicine_name" name="medicine_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_packaging" class="form-label">Packaging</label>
                        <input type="text" class="form-control" id="edit_packaging" name="packaging">
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit_price" name="price" required>
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
    const editMedicineModal = document.getElementById('editMedicineModal');
    editMedicineModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const packaging = button.getAttribute('data-packaging');
        const price = button.getAttribute('data-price');
        
        const modalId = editMedicineModal.querySelector('#medicine_id');
        const modalName = editMedicineModal.querySelector('#edit_medicine_name');
        const modalPackaging = editMedicineModal.querySelector('#edit_packaging');
        const modalPrice = editMedicineModal.querySelector('#edit_price');
        
        modalId.value = id;
        modalName.value = name;
        modalPackaging.value = packaging;
        modalPrice.value = price;
    });
</script>

</body>
</html>
