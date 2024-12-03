<?php

require_once APP_PATH . "session.php";

// Si el usuario no está autenticado, se realiza un redirect al login
if (!$USUARIO_AUTENTICADO) {
    header("Location: " . APP_ROOT . "login.php");
    exit();
}
