<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../config/db.php';

$query = "SELECT id, name, email FROM users";
$result = $conn->query($query);

$users = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode([
    "status" => "success",
    "users" => $users
]);

$conn->close();
?>
