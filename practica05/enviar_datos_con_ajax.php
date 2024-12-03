<?php

// Para importar otro archivo de código PHP
require_once "config.php";

// Para proteger esta vista/página por autenticación
require APP_PATH . "sesion_requerida.php";

// Diferentes tipos de variables
$tituloPagina = "Práctica 05 - Server Side Programming";  // variable string

require APP_PATH . "views/enviar_datos_con_ajax.view.php";