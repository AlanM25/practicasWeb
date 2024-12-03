<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?= APP_ROOT ?>css/style.css" rel="stylesheet" type="text/css" />
    <title><?php echo $tituloPagina; ?></title>
    <script src="<?= APP_ROOT ?>js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php require APP_PATH . "html_parts/info_usuario.php" ?>

    <div class="header">
        <h1>Práctica 05</h1>
        <h2>Basic Server Side Programming</h2>
    </div>

    <?php require APP_PATH . "html_parts/menu.php"; ?>


    <div class="main">
    <div class="search-bar">
        <input
            type="text"
            id="search-input"
            placeholder="Buscar por username"
            oninput="filterUsers()"
        />
    </div>
    <table id="users-table" class="users-table">
        <thead>
            <tr>
                <th>username</th>
                <th>nombre</th>
                <th>apellido</th>
                <th>genero</th>
                <th>fecha de nacimiento</th>
                <th>acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>


    <div class="footer">
        <h2>ITI - Programación Web</h2>
    </div>

    <script src="<?=APP_ROOT?>js/get_users.js"></script>

</body>

</html>