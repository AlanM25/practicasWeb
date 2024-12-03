<?php

require "../config.php";
require "../data_access/db.php";

header('Content-Type: application/json');

$sql = "SELECT id, username, nombre, apellidos, genero, fecha_nacimiento, es_admin FROM usuarios";
$db = getDbConnection();
$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
