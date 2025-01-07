<?php
require_once 'polyModel.php';

function fetchPolies($conn) {
    $polyModel = new PolyModel($conn);
    return $polyModel->fetch();
}

function addPoly($conn, $name, $description) {
    $polyModel = new PolyModel($conn);
    return $polyModel->add($name, $description);
}

function editPoly($conn, $id, $name, $description) {
    $polyModel = new PolyModel($conn);
    return $polyModel->edit($id, $name, $description);
}

function deletePoly($conn, $id) {
    $polyModel = new PolyModel($conn);
    return $polyModel->delete($id);
}
?>
