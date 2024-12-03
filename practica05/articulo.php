<?php

// se incluye la configuración en el archivo PHP config.php
require_once "config.php";

require APP_PATH . "sesion_requerida.php";

$id = $_GET["id"];  // obtención del parámetro URL "id"  (forma no recomendada)
$titulo = filter_input(INPUT_GET, "titulo");  // Parámetro URL "titulo"
if (!$titulo) {  // si no se pasó el título 
    header("Location: " . APP_ROOT);  // redirect al home/index del root de la app
    exit();  // terminamos la ejecución
}

$tituloPagina = "Práctica 05 - " . $titulo;

require APP_PATH . "views/articulo.view.php";
