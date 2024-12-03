<?php

// Indicamos que la respuesta es de tipo JSON.
header("Content-Type: application/json");

// Array para guardar los errores obtenidos.
$errores = [];

// Obtenemos los datos que nos enviaron dentro de la petición POST.

// Obtención del datos enviado como "nombre"
$nombre = filter_input(INPUT_POST, "nombre");
if (!$nombre || !strlen(trim($nombre))) {  // Parámetro no recibido o es vacío
    $errores[] = "Parámetro nombre no especificado"; 
}

// Obtención del datos enviado como "nombre"
$apellidos = filter_input(INPUT_POST, "apellidos");
if (!$apellidos || !strlen(trim($apellidos))) {  // Parámetro no recibido o es vacío
    $errores[] = "Parámetro apellidos no especificado";   
}

if ($errores) {  // Si hay errores

    // Array asociativo que usaremos para en PHP construir el objeto JSON que regresaremos.
    $resObj = ["mensaje" => NULL, "datos" => NULL, "errores" => $errores];

    // El array asociativo lo convertimos a un string JSON y esa va a ser la respuesta.
    echo json_encode($resObj);
    
    exit();  // Terminamos la ejecución de la aplicación
}

// A este punto, ya esta correctamente validados los datos, podermos trabajar 
// con ellos de forma segura, por ejemplo para procesarlos y/o guardarlos en DB

$nombre = trim($nombre);
$apellidos = trim($apellidos);

// Mensaje que queremos regresar.
$mensaje =  "Hola $nombre $apellidos";

// regresamos los datos recibidos
$datos = ["nombre" => $nombre, "apellidos" => $apellidos];

// Array asociativo que usaremos para en PHP construir el objeto JSON que regresaremos.
$resObj = ["mensaje" => $mensaje, "datos" => $datos, "errores" => $errores];

// El array asociativo lo convertimos a un string JSON y esa va a ser la respuesta.
echo json_encode($resObj);
