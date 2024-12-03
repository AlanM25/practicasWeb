<?php

// Obtenemos la fecha/hora actual.
$fechaHora = new DateTime();

// Obtenemos la representación en String de la fecha-hora en formato 2024-12-31 23:59:59
$fechaHoraStr = $fechaHora->format("Y-m-d H:i:s");

// Obtenemos la representación de la fecha en string en formato 31/12/2024
$fechaAMostrar = $fechaHora->format("d/m/Y");

// Fecha en string con formato 2024-12-31
$fechaStr = $fechaHora->format("Y-m-d");

// Representación en string de la hora en formato 23:59:59.
$horaStr = $fechaHora->format("H:i:s");

// Representación de la hora en formato 11:59 pm
$horaAMostrar = $fechaHora->format("h:i a");

// Assoc array con los datos de la hora
$hora = [
    "hora" => (int)$fechaHora->format("H"),
    "minuto" => (int)$fechaHora->format("i"),
    "segundo" => (int)$fechaHora->format("s")
];

// Assoc array de los datos que vamos a regresar.
$resObj = [
    "fechaHora" => $fechaHoraStr,
    "fechaAMostrar" => $fechaAMostrar,
    "horaAMostrar" => $horaAMostrar,
    "fechaStr" => $fechaStr,
    "horaStr" => $horaStr,
    "hora" => $hora
];

// Especificamos que la respuesta a esta petición va a ser de tipo JSON.
header('Content-Type: application/json');

// Imprimimos la respuesta, la representación en string JSON del array
// asociativo $resObj.
echo json_encode($resObj);

