<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

require_once '../config/db.php';

$query = "SELECT id, title, description FROM quizzes";
$result = $conn->query($query);

$quizzes = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $quizzes[] = $row;
    }
}

echo json_encode([
    "status" => "success",
    "data" => $quizzes
]);

$conn->close();
?>
