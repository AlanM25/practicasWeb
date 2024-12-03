<?php
require 'config.php';
require "../data_access/db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    $usuario_id = $_SESSION['usuario_id']; // Supongamos que el ID del usuario está en la sesión
    $archivo = $_FILES['archivo'];

    // Validar archivo
    if ($archivo['error'] === UPLOAD_ERR_OK) {
        $nombre_original = $archivo['name'];
        $tamano = $archivo['size'];
        $peso_kb = round($tamano / 1024, 2);
        $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
        $nombre_random = uniqid() . ".$extension";
        $ruta_guardado = DIR_UPLOAD . $nombre_random;

        // Mover el archivo a la carpeta de subida
        if (move_uploaded_file($archivo['tmp_name'], $ruta_guardado)) {
            $fecha_subida = date('Y-m-d H:i:s');

            // Guardar en la tabla archivos
            $stmt = $db->prepare("INSERT INTO archivos (usuario_id, nombre_archivo, nombre_archivo_guardado, tamaño, fecha_subido, cant_descargas, es_publico) 
                VALUES (?, ?, ?, ?, ?, 0, 0)");
            $stmt->execute([$usuario_id, $nombre_original, $nombre_random, $peso_kb, $fecha_subida]);

            // Registrar en la tabla archivos_log_general
            $archivo_id = $db->lastInsertId();
            $stmt = $db->prepare("INSERT INTO archivos_log_general (usuario_id, archivo_id, accion_realizada, fecha_hora) 
                VALUES (?, ?, 'Archivo subido', ?)");
            $stmt->execute([$usuario_id, $archivo_id, $fecha_subida]);

            echo json_encode(['success' => true, 'message' => 'Archivo subido correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al mover el archivo.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al subir el archivo.']);
    }
}
?>
