<?php
require "../config.php";
require APP_PATH . "data_access/db.php";
require "../session.php";

if (!$USUARIO_AUTENTICADO) {
    echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$fileId = $data['id'] ?? '';

if (empty($fileId)) {
    echo json_encode(["success" => false, "message" => "ID de archivo no especificado."]);
    exit;
}

try {
    $db = getDbConnection();
    $stmt = $db->prepare("UPDATE archivos SET es_publico = 1 WHERE id = :id");
    $stmt->bindParam(":id", $fileId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Archivo hecho público exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al hacer público el archivo."]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error en el servidor: " . $e->getMessage()]);
}