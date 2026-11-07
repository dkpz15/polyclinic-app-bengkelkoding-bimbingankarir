<?php
class ConsultationModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getConsultationsByPatient($patientId) {
        $stmt = $this->conn->prepare("
            SELECT c.*, d.name AS doctor_name 
            FROM consultation c 
            JOIN doctor d ON c.doctor_id = d.id 
            WHERE c.patient_id = ? 
            ORDER BY consultation_date DESC
        ");
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getConsultationsByDoctor($doctorId) {
        $stmt = $this->conn->prepare("
            SELECT c.*, p.name AS patient_name 
            FROM consultation c 
            JOIN patient p ON c.patient_id = p.id 
            WHERE c.doctor_id = ? 
            ORDER BY consultation_date DESC
        ");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addConsultation($patientId, $doctorId, $question) {
        $stmt = $this->conn->prepare("INSERT INTO consultation (patient_id, doctor_id, question) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $patientId, $doctorId, $question);
        return $stmt->execute();
    }

    public function updateConsultation($id, $question) {
        $stmt = $this->conn->prepare("UPDATE consultation SET question = ? WHERE id = ?");
        $stmt->bind_param("si", $question, $id);
        return $stmt->execute();
    }

    public function deleteConsultation($id) {
        $stmt = $this->conn->prepare("DELETE FROM consultation WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function answerConsultation($id, $answer) {
        $stmt = $this->conn->prepare("UPDATE consultation SET answer = ? WHERE id = ?");
        $stmt->bind_param("si", $answer, $id);
        return $stmt->execute();
    }
}
?>
