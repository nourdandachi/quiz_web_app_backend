<?php
header('Content-Type: application/json');
require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['title']) && isset($data['description'])) {
    $title = $data['title'];
    $description = $data['description'];

    $checkQuery = "SELECT * FROM quizzes WHERE title = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "s", $title);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(["status" => "error", "message" => "Quiz title already exists!"]);
    } else {
        $insertQuery = "INSERT INTO quizzes (title, description) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "ss", $title, $description);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "Quiz created successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to create quiz."]);
        }
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
}

mysqli_close($conn);
?>
