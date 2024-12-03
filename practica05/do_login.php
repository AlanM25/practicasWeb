<?php

require "config.php";
require APP_PATH . "data_access/db.php";
require APP_PATH . "login_helper.php";

session_start();  // se inicializa la sesión

$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");


if (!$username || !$password) {
    header("Location: " . APP_ROOT . "login.html");
    exit();
}

$usuario = autentificar($username, $password);


if (!$usuario) {
    header("Location: " . APP_ROOT . "login.php");
    exit();
}

// Se establecen las variables de sesión
$_SESSION["Usuario_Id"] = $usuario["id"];
$_SESSION["Usuario_Username"] = $usuario["username"];
$_SESSION["Usuario_Nombre"] = $usuario["nombre"];
$_SESSION["Usuario_Apellidos"] = $usuario["apellidos"];
$_SESSION["Usuario_EsAdmin"] = $usuario["esAdmin"];

// Redirect al index
header("Location: " . APP_ROOT);
