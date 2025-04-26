<?php
header('Content-Type: application/json');
require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['title']) && isset($data['description'])) {
    $title = $data['title'];
    $description = $data['description'];

    $query = "INSERT INTO quizzes (title, description) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $title, $description);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "Quiz created successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to create quiz."]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
}

mysqli_close($conn);
?>
