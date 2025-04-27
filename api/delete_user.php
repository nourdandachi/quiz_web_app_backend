<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->user_id)) {
    $userId = $data->user_id;

    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "User deleted successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete user."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Missing user_id."]);
}

$conn->close();
?>
