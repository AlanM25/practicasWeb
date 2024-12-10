<?php
require APP_PATH . "data_access/db.php";

if (!$USUARIO_AUTENTICADO) {
    header("Location: login.php");
    exit;
}

$db = getDbConnection();

$searchResults = [];
if (isset($_GET['query'])) { 
    $username = $_GET['query'];

    $query = "SELECT username, nombre, apellidos, id FROM usuarios WHERE username LIKE ? OR nombre LIKE ? OR apellidos LIKE ?";
    $stmt = $db->prepare($query);
    $searchTerm = "%" . $username . "%";

    $stmt->bindValue(1, $searchTerm, PDO::PARAM_STR);
    $stmt->bindValue(2, $searchTerm, PDO::PARAM_STR);
    $stmt->bindValue(3, $searchTerm, PDO::PARAM_STR);
    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?=APP_ROOT?>css/style.css" rel="stylesheet" type="text/css" /> 
    <title><?php echo $tituloPagina; ?></title>
    <script src="<?=APP_ROOT?>js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php require APP_PATH . "html_parts/info_usuario.php" ?>

    <div class="header">
        <h1>Práctica 05</h1>
        <h2>Basic Server Side Programming</h2>
        <h4>Bienvenido <?=$USUARIO_NOMBRE_COMPLETO?></h4>
        <h5>Cantidad Visitas: <?=$cantidadVisitas?></h5>
    </div>
      
    <?php require APP_PATH . "html_parts/menu.php"; ?>
      
    <div class="row">

        <div class="leftcolumn">

        <div class="card">
            <h2>Buscar Usuarios</h2>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="query" value="<?= htmlspecialchars($username ?? '') ?>" required>
                <input type="submit" value="Buscar">
            </form>

            <?php if (!empty($searchResults)): ?>
                <h3>Resultados:</h3>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nombre Completo</th>
                            <th>Archivos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchResults as $usuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['username']) ?></td>
                                <td><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']) ?></td> 
                                <td><a href="<?=APP_ROOT?>archivos_usuario.php?id=<?= $usuario['id'] ?>">Ver Archivos</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No se encontraron resultados para "<?= htmlspecialchars($username) ?>".</p>  
            <?php endif; ?>
        </div>
        </div>  <!-- End left column -->

        <!-- Incluimos la parte derecha de la página, que está procesada en otro archivo -->
        <?php require APP_PATH . "html_parts/page_right_column.php"; ?>

    </div>  <!-- End row-->

    <div class="footer">
        <h2>ITI - Programación Web</h2>
    </div>
</body>
</html>
