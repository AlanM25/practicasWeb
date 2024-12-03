<?php
require "../config.php"; // Archivo de configuración
require "../data_access/db.php";
require "../sesion_requerida.php"; // Archivo de inicio de sesión


header("Content-Type: application/json");

$uploadDir = DIR_UPLOAD; // Ruta para guardar los archivos
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$resObj = ["error" => null, "mensaje" => null];

if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["error" => "Error al subir el archivo"]);
    exit;
}

// Validar archivo
$archivo = $_FILES['archivo'];
$otroDato = $_POST['otroDato'] ?? '';
$tiposPermitidos = ['application/pdf', 'image/jpeg', 'image/png', 'image/gif'];
$maxSize = 2 * 1024 * 1024;

if (!in_array($archivo['type'], $tiposPermitidos)) {
    echo json_encode(["error" => "Tipo de archivo no permitido"]);
    exit;
}

if ($archivo['size'] > $maxSize) {
    echo json_encode(["error" => "El archivo supera el tamaño permitido"]);
    exit;
}

$extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
echo $rutaArchivo; 
// Generar nombre único
$nombreUnico = uniqid() . "-" . basename($archivo['name']);
$rutaArchivo = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $nombreUnico;

// Guardar archivo
if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
    // Guardar en base de datos
    $pesoKB = round($archivo['size'] / 1024, 2);
    $fechaHora = date('Y-m-d H:i:s');
    $userId = $USUARIO_ID; // Ajusta según cómo manejas sesiones
    $db = getDbConnection();

    // Insertar en tabla archivos
    $stmt = $db->prepare("INSERT INTO archivos (usuario_subio_id, nombre_archivo, nombre_archivo_guardado, extension, tamaño, fecha_subido, es_publico, cant_descargas, hash_sha256) 
                           VALUES (?, ?, ?, ?, ?, ?, 0, 0, 0)");
    $stmtParams = [$userId, $archivo['name'], $nombreUnico, $extension, $pesoKB, $fechaHora];
    $stmt->execute($stmtParams);

    // Insertar en log general
    $dbLastId = $db->lastInsertId();
    $stmtLog = $db->prepare("INSERT INTO archivos_log_general (usuario_id, accion_realizada, archivo_id, fecha_hora, ip_realiza_operacion) 
                             VALUES (?, 'subida', ?, ?, '')");
    $stmtLogParams = [$userId, $dbLastId, $fechaHora];
    $stmtLog->execute($stmtLogParams);

    $resObj['mensaje'] = "Archivo subido con éxito";
} else {
    $resObj['error'] = "Error al guardar el archivo";
}

echo json_encode($resObj);
