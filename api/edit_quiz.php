<?php
header('Content-Type: application/json');
require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id']) && isset($data['title']) && isset($data['description'])) {
    $id = $data['id'];
    $title = $data['title'];
    $description = $data['description'];

    $checkQuery = "SELECT * FROM quizzes WHERE title = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "si", $title, $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(["status" => "error", "message" => "Quiz title already exists!"]);
    } else {
        $updateQuery = "UPDATE quizzes SET title = ?, description = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "Quiz updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update quiz."]);
        }
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
}

mysqli_close($conn);
?>
