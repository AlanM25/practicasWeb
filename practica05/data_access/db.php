<?php

/**
 * Obtiene un PDO object correspondiente a la conexión a DB a usar.
 */
function getDbConnection() {

    $options = [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    return new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, $options);
}
