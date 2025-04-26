<?php
header('Content-Type: application/json');
require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (
    isset($data['quiz_id']) &&
    isset($data['question_text']) &&
    isset($data['option_a']) &&
    isset($data['option_b']) &&
    isset($data['option_c']) &&
    isset($data['option_d']) &&
    isset($data['correct_option'])
) {
    $quiz_id = $data['quiz_id'];
    $question_text = $data['question_text'];
    $option_a = $data['option_a'];
    $option_b = $data['option_b'];
    $option_c = $data['option_c'];
    $option_d = $data['option_d'];
    $correct_option = $data['correct_option'];

    $query = "INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "issssss", $quiz_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "Question created successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to create question."]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
}

mysqli_close($conn);
?>
