<?php
header('Content-Type: application/json');
require_once '../config/db.php';

$query = "SELECT * FROM quizzes";
$result = mysqli_query($conn, $query);

$quizzes = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $quizzes[] = $row;
    }
    echo json_encode(["status" => "success", "quizzes" => $quizzes]);
} else {
    echo json_encode(["status" => "error", "message" => "No quizzes found."]);
}

mysqli_close($conn);
?>
