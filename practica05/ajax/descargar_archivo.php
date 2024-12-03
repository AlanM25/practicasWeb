<?php
require "../config.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die("ID inválido.");
}

$stmt = $db->prepare("SELECT nombre_archivo_guardado, nombre_archivo FROM archivos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result) {
    die("Archivo no encontrado.");
}

$archivoPath = DIR_UPLOAD . $result['nombre_archivo_guardado'];
if (!file_exists($archivoPath)) {
    die("El archivo no existe en el servidor.");
}

header('Content-Type: application/octet-stream');
header('Content-Length: ' . filesize($archivoPath));
header('Content-Disposition: attachment; filename="' . $result['nombre_archivo'] . '"');
readfile($archivoPath);

// Actualizar contador de descargas
$stmt = $db->prepare("UPDATE archivos SET cant_descargas = cant_descargas + 1 WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
