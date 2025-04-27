<?php
header('Content-Type: application/json');
require_once '../config/db.php';

$query = "SELECT * FROM scores";
$result = $conn->query($query);

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

$conn->close();
?>
