<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->quiz_id)) {
    $quizId = $data->quiz_id;

    $query = "DELETE FROM quizzes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $quizId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Quiz deleted successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete quiz."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Missing quiz_id."]);
}

$conn->close();
?>
