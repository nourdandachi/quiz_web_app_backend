<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

require_once '../config/db.php';

if (isset($_POST['user_id']) && isset($_POST['quiz_id']) && isset($_POST['score'])) {
    $user_id = $_POST['user_id'];
    $quiz_id = $_POST['quiz_id'];
    $score = $_POST['score'];

    $stmt = $conn->prepare("INSERT INTO scores (user_id, quiz_id, score) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $user_id, $quiz_id, $score);

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
