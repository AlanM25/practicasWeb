<?php

// para incluir el archivo PHP con los parámetros de configuración de la app
require "config.php";

require APP_PATH . "sesion_requerida.php";

// Recibir datos por POST
$nombre = $_POST["nombre"]; // No recomendable
$nombre = filter_input(INPUT_POST, "nombre");
$apellidos = filter_input(INPUT_POST, "apellidos");

// Validación de que se enviaron los datos
if (!$nombre || !$apellidos) {
    // Regresamos HTTP Response Header Location para decirle al web browser que
    // haga un redirect al root de nuestra app
    header("Location: " . APP_ROOT);  
    exit();  // Finaliza la ejecución del código PHP
}

$tituloPagina = "Práctica 05 - Recibir Por POST";

require APP_PATH . "views/recibir_por_post.view.php";
