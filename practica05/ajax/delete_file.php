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

    // Check if the file exists
    $stmt = $db->prepare("SELECT id FROM archivos WHERE id = :id");
    $stmt->bindParam(":id", $fileId, PDO::PARAM_INT);
    $stmt->execute();
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$file) {
        echo json_encode(["success" => false, "message" => "Archivo no encontrado."]);
        exit;
    }

    // Log the deletion
    $stmt = $db->prepare("INSERT INTO archivos_log_general (archivo_id, usuario_id, fecha_hora, accion_realizada, ip_realiza_operacion) VALUES (:archivo_id, :usuario_id, NOW(), 'BORRADO', :ip_realiza_operacion)");
    $stmt->bindParam(":archivo_id", $fileId, PDO::PARAM_INT);
    $stmt->bindParam(":usuario_id", $USUARIO_ID, PDO::PARAM_INT);
    $stmt->bindParam(":ip_realiza_operacion", $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
    if (!$stmt->execute()) {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(["success" => false, "message" => "Error al registrar el log de borrado.", "errorInfo" => $errorInfo]);
        exit;
    }

    // Delete the file
    $stmt = $db->prepare("DELETE FROM archivos WHERE id = :id");
    $stmt->bindParam(":id", $fileId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Archivo borrado exitosamente."]);
    } else {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(["success" => false, "message" => "Error al borrar el archivo.", "errorInfo" => $errorInfo]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error en el servidor: " . $e->getMessage()]);
}