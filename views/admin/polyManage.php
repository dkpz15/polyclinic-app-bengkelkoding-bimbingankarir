<?php
include '../../config/database.php';
include '../../controllers/polyController.php';

// Fetch all polies
$polies = fetchPolies($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poly Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Manage Polies</h2>
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addPolyModal">Add Poly</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Poly Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($polies as $poly): ?>
            <tr>
                <td><?= $poly['poly_name'] ?></td>
                <td><?= $poly['description'] ?></td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPolyModal"
                            data-id="<?= $poly['id'] ?>" data-poly_name="<?= $poly['poly_name'] ?>" data-description="<?= $poly['description'] ?>">Edit</button>

                    <!-- Delete Button -->
                    <form action="../../controllers/polyController.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $poly['id'] ?>">
                        <button type="submit" name="deletePoly" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Poly Modal -->
<div class="modal fade" id="addPolyModal" tabindex="-1" aria-labelledby="addPolyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="../../controllers/polyController.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPolyLabel">Add Poly</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="poly_name" class="form-label">Poly Name</label>
                        <input type="text" class="form-control" id="poly_name" name="poly_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="addPoly" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Poly Modal -->
<div class="modal fade" id="editPolyModal" tabindex="-1" aria-labelledby="editPolyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="../../controllers/polyController.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPolyLabel">Edit Poly</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editPolyName" class="form-label">Poly Name</label>
                        <input type="text" class="form-control" id="editPolyName" name="poly_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="editPoly" class="btn btn-primary">Update</button>
                    <input type="hidden" id="editPolyId" name="id">
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
    // Auto-populate the Edit Poly Modal with existing data
    document.getElementById('editPolyModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var poly_name = button.getAttribute('data-poly_name');
        var description = button.getAttribute('data-description');

        document.getElementById('editPolyId').value = id;
        document.getElementById('editPolyName').value = poly_name;
        document.getElementById('editDescription').value = description;
    });
</script>

</body>
</html>
