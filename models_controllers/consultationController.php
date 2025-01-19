<?php
include 'consultationModel.php';

function getConsultationsForPatient($conn, $patientId) {
    $consultationModel = new ConsultationModel($conn);
    return $consultationModel->getConsultationsByPatient($patientId);
}

function getConsultationsForDoctor($conn, $doctorId) {
    $consultationModel = new ConsultationModel($conn);
    return $consultationModel->getConsultationsByDoctor($doctorId);
}

function createConsultation($conn, $patientId, $doctorId, $question) {
    $consultationModel = new ConsultationModel($conn);
    return $consultationModel->addConsultation($patientId, $doctorId, $question);
}

function editConsultation($conn, $id, $question) {
    $consultationModel = new ConsultationModel($conn);
    return $consultationModel->updateConsultation($id, $question);
}

function removeConsultation($conn, $id) {
    $consultationModel = new ConsultationModel($conn);
    return $consultationModel->deleteConsultation($id);
}

function respondToConsultation($conn, $id, $answer) {
    $consultationModel = new ConsultationModel($conn);
    return $consultationModel->answerConsultation($id, $answer);
}
?>
