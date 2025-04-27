<?php
header('Content-Type: application/json');
require_once '../config/db.php';

if (isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];

    $query = "SELECT * FROM questions WHERE quiz_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $quiz_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $questions = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $questions[] = $row;
        }
        echo json_encode(["status" => "success", "questions" => $questions]);
    } else {
        echo json_encode(["status" => "error", "message" => "No questions found for this quiz."]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "message" => "Missing quiz ID."]);
}

mysqli_close($conn);
?>
