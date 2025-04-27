<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

require_once '../config/db.php';

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);

    $query = "SELECT s.id, s.quiz_id, q.title AS quiz_title, s.score, s.total_questions
          FROM scores s
          JOIN quizzes q ON s.quiz_id = q.id
          WHERE s.user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $scores = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $scores[] = $row;
        }
    }

    echo json_encode([
        "status" => "success",
        "scores" => $scores
    ]);

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Missing user_id parameter."]);
}

$conn->close();
?>
