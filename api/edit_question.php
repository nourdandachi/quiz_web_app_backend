<?php
header('Content-Type: application/json');
require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (
    isset($data['id']) &&
    isset($data['question_text']) &&
    isset($data['option_a']) &&
    isset($data['option_b']) &&
    isset($data['option_c']) &&
    isset($data['option_d']) &&
    isset($data['correct_option'])
) {
    $id = $data['id'];
    $question_text = $data['question_text'];
    $option_a = $data['option_a'];
    $option_b = $data['option_b'];
    $option_c = $data['option_c'];
    $option_d = $data['option_d'];
    $correct_option = $data['correct_option'];

    $query = "UPDATE questions SET question_text = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct_option = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "Question updated successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update question."]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
}

mysqli_close($conn);
?>
