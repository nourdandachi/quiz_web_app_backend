<?php
header('Content-Type: application/json');
require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email']) && isset($data['password'])) {
    $email = $data['email'];
    $password = $data['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            echo json_encode(["status" => "success", "message" => "Login successful!", "user" => ["id" => $user['id'], "name" => $user['name'], "email" => $user['email']]]);
        } else {
            echo json_encode(["status" => "error", "message" => "Incorrect password."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found."]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
}

mysqli_close($conn);
?>
