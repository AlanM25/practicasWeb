<?php

header('Content-Type: application/json');

$urlGetScores =   // URL a donde vamos a hacer la llamada a la REST API
        "http://primosoft.com.mx/games/api/getscores.php"."?game=Tic-Tac-Toe-Alan"."&orderAsc=1";

// Llamada a la REST API
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $urlGetScores,  // la url a la que llamamos
    CURLOPT_RETURNTRANSFER => true,  // para obtener el texto de la respuesta
    CURLOPT_FOLLOWLOCATION => true,  // si hay un redirect, lo seguimos
    CURLOPT_TIMEOUT => 30   // timeout en segundos
]);

// Obtenemos el texto de la respuesta que nos regresó la API y cerramos la conexión
$responseContent = curl_exec($ch);
curl_close($ch);

// El string JSON de la respuesta lo convertimos a un assoc array para poder trabajar con él en PHP
$scores = json_decode($responseContent, true);

echo json_encode($scores);