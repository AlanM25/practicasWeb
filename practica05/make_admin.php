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

$sql = "UPDATE usuarios SET es_admin = 1 WHERE id = ?";

$db = getDbConnection();
$stmt = $db->prepare($sql);
$stmt->bindParam(1, $userId);

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
