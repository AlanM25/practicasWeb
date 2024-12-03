<?php

require "../config.php";
require "../data_access/db.php";
require "../session.php";

header('Content-Type: application/json');

function checkUsername($username)
{
    $sqlCmd =
        "SELECT id, username, password_encrypted, password_salt, " .
        "    nombre, apellidos, es_admin, activo" .
        "  FROM usuarios WHERE username = ? ORDER BY id DESC";

    $db = getDbConnection();  // obtenemos la conexión (PDO object)
    $stmt = $db->prepare($sqlCmd);  // Statement a ejecutar
    $sqlParams = [$username];  // Parámetros de la consulta
    $stmt->execute($sqlParams);  // Ejecutamos con los parámetros 
    $queryResult = $stmt->fetchAll(); // Todos los resultados del consulta

    if ($queryResult) {
        return true;
    }
}

$currentUsername = $_SESSION["Usuario_Username"];
$username = filter_input(INPUT_POST, "username");
$currentPassword = filter_input(INPUT_POST, "currentPassword");
$password = filter_input(INPUT_POST, var_name: "password");
$confirmPassword = filter_input(INPUT_POST, var_name: "confirmPassword");
$firstName = filter_input(INPUT_POST, "firstName");
$lastName = filter_input(INPUT_POST, "lastName");
$genre = filter_input(INPUT_POST, var_name: "genre");
$bornDate = filter_input(INPUT_POST, "bornDate");
$registerDate = date('yyy-mm-dd');


if (
    empty($username) ||
    empty($currentPassword) ||
    empty($password) ||
    empty($confirmPassword) ||
    empty($firstName) ||
    empty($genre) ||
    empty($bornDate) ||
    empty($registerDate)
) {
    echo json_encode([
        'status' => 'error',
        'message' => 'The inputs are empty'
    ]);
    exit;
}

if (!preg_match('/^[a-z_]+$/', $username)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Username can only contain lowercase letters and underscores'
    ]);
    exit;
}


if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Password must be at least 8 characters long and contain at least one uppercase and one lowercase letter'
    ]);
    exit;
}

if ($password != $confirmPassword) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Passwords does not match'
    ]);
    exit;
}

if (checkUsername($username)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Username already exists'
    ]);
    exit;
}

// !IMPORTANT -> THIS IS THE DB CONNECTION
$db = getDbConnection();

// TODO -> CHECKING USER CURRENT PASS

$sql = "SELECT password_encrypted FROM usuarios WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$_SESSION["Usuario_Id"]]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!password_verify($currentPassword, $user['password_encrypted'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Incorrect current password'
    ]);
    exit;
}

// TODO -> UPDATING THE USER DATA INTO THE DATABASE


$salt = bin2hex(random_bytes(16));

// Hash the password using bcrypt
$password_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

// Insert the user data into the database
$sql = "UPDATE usuarios
        SET username = ?,
        password_encrypted = ?,
        password_salt = ?,
        nombre = ?,
        apellidos = ?,
        genero = ?,
        fecha_nacimiento = ?,
        es_admin = ?,
        activo = 1
        WHERE id = ?";

$stmt = $db->prepare($sql);
$stmt->bindParam(1, $username);
$stmt->bindParam(2, $password_hash);
$stmt->bindParam(3, $salt);
$stmt->bindParam(4, $firstName);
$stmt->bindParam(5, $lastName);
$stmt->bindParam(6, $genre);
$stmt->bindParam(7, $bornDate);
$stmt->bindParam(8, $_SESSION["Usuario_EsAdmin"]);
$stmt->bindParam(9, $_SESSION["Usuario_Id"]);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'User updated successfully'
    ]);
    exit;
}

echo json_encode([
    'status' => 'error',
    'message' => 'Error updating user'
]);
exit;
