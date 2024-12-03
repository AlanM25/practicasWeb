<?php

// Para importar otro archivo de código PHP
require_once "config.php";

// Para proteger esta vista/página por autenticación
require APP_PATH . "sesion_requerida.php";

$tituloPagina = "Práctica 05 - Server Side Programming";

// Se regresa el view
require APP_PATH . "views/enviar_datos_con_form.view.php";
