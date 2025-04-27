<?php
header('Content-Type: application/json');
require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $id = $data['id'];

    $query = "DELETE FROM questions WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "Question deleted successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete question."]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "message" => "Missing question ID."]);
}

mysqli_close($conn);
?>
