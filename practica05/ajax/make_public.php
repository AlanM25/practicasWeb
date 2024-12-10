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

    // Obtener el estado actual del archivo y el propietario
    $stmt = $db->prepare("SELECT es_publico, usuario_subio_id FROM archivos WHERE id = :id");
    $stmt->bindParam(":id", $fileId, PDO::PARAM_INT);
    $stmt->execute();
    $archivo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$archivo) {
        echo json_encode(["success" => false, "message" => "Archivo no encontrado."]);
        exit;
    }

    // Cambiar estado de público/privado
    $nuevoEstado = !$archivo['es_publico'];
    $stmt = $db->prepare("UPDATE archivos SET es_publico = :nuevo_estado WHERE id = :id");
    $stmt->bindParam(":nuevo_estado", $nuevoEstado, PDO::PARAM_INT);
    $stmt->bindParam(":id", $fileId, PDO::PARAM_INT);
    $stmt->execute();

    // Si el archivo se vuelve privado, eliminar favoritos de otros usuarios
    if (!$nuevoEstado) {
        $stmt = $db->prepare("DELETE FROM archivo_favorito WHERE archivo_id = :id AND usuario_id != :propietario_id");
        $stmt->bindParam(":id", $fileId, PDO::PARAM_INT);
        $stmt->bindParam(":propietario_id", $archivo['usuario_subio_id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    echo json_encode(["success" => true, "message" => "El estado de público/privado se ha cambiado exitosamente."]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error en el servidor: " . $e->getMessage()]);
}