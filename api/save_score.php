<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

require_once '../config/db.php';

if (isset($_POST['user_id']) && isset($_POST['quiz_id']) && isset($_POST['score']) && isset($_POST['total_questions'])) {
    $user_id = $_POST['user_id'];
    $quiz_id = $_POST['quiz_id'];
    $score = $_POST['score'];
    $total_questions = $_POST['total_questions'];

    $checkQuery = "SELECT id FROM scores WHERE user_id = ? AND quiz_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $user_id, $quiz_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        $updateQuery = "UPDATE scores SET score = ?, total_questions = ? WHERE user_id = ? AND quiz_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("iiii", $score, $total_questions, $user_id, $quiz_id);
    } else {
        $stmt->close();
        $insertQuery = "INSERT INTO scores (user_id, quiz_id, score, total_questions) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("iiii", $user_id, $quiz_id, $score, $total_questions);
    }

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Score saved successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save score."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
}

$conn->close();
?>
