<?php

// Especificamos que la respuesta va a ser un JSON.
header('Content-Type: application/json');

// Obtenemos el string JSON de la petición POST que se hizo. Para esto se lee
// directamente la petición del input stream.
$reqObjJson = file_get_contents('php://input');

// El json string lo transformamos a un array asociativo en PHP para poder
// acceder a sus datos.
$reqObj = json_decode($reqObjJson, true);

// Array para guardar los errores que se vayan produciendo y regresarlos en la respuesta.
$errores = [];

// Validamos los datos que nos enviaron, nunca hay que confiar de las validaciones del
// lado del cliente, siempre hay que validar del lado del servidor.

if (!array_key_exists('nombre', $reqObj) || 
        !$reqObj["nombre"] || !strlen(trim($reqObj["nombre"]))) {
    $errores[] = "Parámetro nombre no enviado";
}

if (!array_key_exists("apellidos", $reqObj) ||
        !$reqObj["apellidos"] || !strlen(trim($reqObj["apellidos"]))) {
    $errores[] = "Parámetro apellidos no enviado";
}

if ($errores) {  // Si hay errores
    $resObj = ['mensaje' => NULL, 'errores' => $errores, 'otroDato' => NULL];
    echo json_encode($resObj);  // Regresamos la respuesta JSON.
    exit();  // Terminamos la ejecución de la aplicación
}

// Obtenemos los datos que nos enviaron y trabajamos con ellos.
// Aquí, por ejemplo, pudieramos mandar llamar guardar estos datos en una base de datos.
$nombre = trim($reqObj['nombre']);
$apellidos = trim($reqObj['apellidos']);
$mensaje = "Hola $nombre $apellidos, hiciste una petición enviando datos como JSON :)";

// Definimos un array asociativo que es la respuesta que vamos a enviar.
$otroDato = $reqObj["otroDato"] * 3.1416;
$resObj = ['mensaje' => $mensaje, 'errores' => $errores, 'otroDato' => $otroDato];

// Regresamos la respuesta JSON.
echo json_encode($resObj);
