<?php

require "config.php";
require "data_access/db.php";
require "session.php";

header('Content-Type: application/json');

if (!$USUARIO_ES_ADMIN) header("Location: " . APP_ROOT);

$userId = filter_input(INPUT_POST, var_name: "id");

if ($userId == $USUARIO_ID) {
    echo json_encode([
        'status' => 'error',
        'message' => 'You cannot modify yourself stupid bastard kill yourself'
    ]);
    exit;
}

$salt = bin2hex(random_bytes(16));

// Hash the password using bcrypt
$password_hash = password_hash('Password123', PASSWORD_DEFAULT, ['cost' => 12]);

$sql = "UPDATE usuarios SET password_encrypted = ?, password_salt = ? WHERE id = ?";

$db = getDbConnection();
$stmt = $db->prepare($sql);
$stmt->bindParam(1, $password_hash);
$stmt->bindParam(2, $salt);
$stmt->bindParam(3, $userId);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'User updated successfully'
    ]);
    exit;
}

echo json_encode([
    'status' => 'error',
    'message' => 'Error updating user'
]);
