<?php

$urlGetGames = // URL del endpoint al que vamos a llamar
        "http://primosoft.com.mx/games/api/getgames.php";
$ch = curl_init();  // init de la petición HTTP
curl_setopt_array($ch, [   // establecemos las opciones
    CURLOPT_URL => $urlGetGames,  // la url a la que llamamos
    CURLOPT_RETURNTRANSFER => true,  // para obtener el texto de la respuesta
    CURLOPT_FOLLOWLOCATION => true,  // si hay un redirect, lo seguimos
    CURLOPT_TIMEOUT => 30   // timeout en segundos
]);

// obtenemos el texto del response y cerramos la conexión
$responseContent = curl_exec($ch);
curl_close($ch);

// del JSON string, obtenemos un array de PHP 
$games = json_decode($responseContent, true);

// Incluimos la vista
include "views/index.view.php";
