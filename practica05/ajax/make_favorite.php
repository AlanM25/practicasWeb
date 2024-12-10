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

    // Verificar si el archivo ya está marcado como favorito
    $stmt = $db->prepare("SELECT COUNT(*) AS count FROM archivo_favorito WHERE usuario_id = ? AND archivo_id = ?");
    $stmt->execute([$USUARIO_ID, $fileId]);
    $esFavorito = $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;

    if ($esFavorito) {
        // Si ya es favorito, eliminar de la tabla
        $stmt = $db->prepare("DELETE FROM archivo_favorito WHERE usuario_id = ? AND archivo_id = ?");
        $stmt->execute([$USUARIO_ID, $fileId]);
        echo json_encode(["success" => true, "message" => "Archivo eliminado de favoritos."]);
    } else {
        // Si no es favorito, agregar a la tabla
        $stmt = $db->prepare("INSERT INTO archivo_favorito (usuario_id, archivo_id) VALUES (?, ?)");
        $stmt->execute([$USUARIO_ID, $fileId]);
        echo json_encode(["success" => true, "message" => "Archivo añadido a favoritos."]);
    }

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error en el servidor: " . $e->getMessage()]);
}
