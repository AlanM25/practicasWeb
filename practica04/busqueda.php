<?php 

//$q = $_GET['q'];
$q = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 04</title>
</head>
<body>
    <h1>Datos de Busqueda</h1>
    <p>Está buscando <strong><?=$q?></strong></p>
</body>
</html>