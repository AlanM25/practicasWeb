<?php
require "../config.php";
header("Content-Type: application/json");

$usuarioId = $_SESSION['usuario_id'];
$mes = $_GET['mes'] ?? date('m');
$anio = $_GET['anio'] ?? date('Y');

$stmt = $db->prepare("SELECT id, nombre_archivo, fecha_subido, tamaño, es_publico, cant_descargas 
                      FROM archivos 
                      WHERE usuario_id = ? AND MONTH(fecha_subido) = ? AND YEAR(fecha_subido) = ?");
$stmt->bind_param("iii", $usuarioId, $mes, $anio);
$stmt->execute();
$result = $stmt->get_result();

$archivos = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($archivos);
?>
