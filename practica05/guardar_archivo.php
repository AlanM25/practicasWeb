<?php


require "config.php";

header("Content-Type: application/json");
$resObj = ["error" => null, "mensaje" => null];

if (empty($_FILES) || !isset($_FILES["archivo"])) {
    $resObj["error"] = "Archivo no especificado.";
    echo json_encode($resObj);
    exit();
}

// Validaciones de tipo de archivo
$archivo = $_FILES["archivo"];
$nombreOriginal = $archivo["name"];
$tamaño = $archivo["size"];
$rutaTemporal = $archivo["tmp_name"];
$tipo = mime_content_type($rutaTemporal);

$tiposPermitidos = ["application/pdf", "image/jpeg", "image/png", "image/gif"];
if (!in_array($tipo, $tiposPermitidos)) {
    $resObj["error"] = "Tipo de archivo no permitido.";
    echo json_encode($resObj);
    exit();
}

// Generar nombre único
$extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
$nombreGuardado = uniqid("archivo_") . ".$extension";
$rutaFinal = DIR_UPLOAD . $nombreGuardado;

if (!move_uploaded_file($rutaTemporal, $rutaFinal)) {
    $resObj["error"] = "Error al guardar el archivo.";
    echo json_encode($resObj);
    exit();
}

// Guardar en la base de datos
$db = getDbConnection();
try {
    $db->beginTransaction();

    // Insertar registro en tabla "archivos"
    $stmt = $db->prepare("INSERT INTO archivos (nombre_original, nombre_guardado, tamaño_kb, id_usuario) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombreOriginal, $nombreGuardado, round($tamaño / 1024, 2), 1]); // Suponiendo id_usuario = 1 por ahora
    $archivoId = $db->lastInsertId();

    // Registrar operación en "archivos_log_general"
    $stmt = $db->prepare("INSERT INTO archivos_log_general (id_archivo, accion, id_usuario) VALUES (?, ?, ?)");
    $stmt->execute([$archivoId, 'Subida', 1]);

    $db->commit();
    $resObj["mensaje"] = "Archivo subido correctamente.";
} catch (Exception $e) {
    $db->rollBack();
    $resObj["error"] = "Error al guardar en la base de datos: " . $e->getMessage();
}

echo json_encode($resObj);
?>
