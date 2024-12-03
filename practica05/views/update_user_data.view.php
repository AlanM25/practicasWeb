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


    <div class="register-container" id="register-container">
        <form class="register-form" id="register-form" action="" method="POST">
            <label for="username">Nombre de usuario: </label>
            <input type="text" name="username" id="username-input">
            <label for="current-password">Contraseña Actual</label>
            <input type="password" name="current-password" id="current-password-input">
            <label for="password">Nueva Contraseña</label>
            <input type="password" name="password" id="password-input">
            <label for="confirm-password">Confirmar contraseña</label>
            <input type="password" name="confirm-password" id="confirm-password-input">
            <label for="first-name">Nombre</label>
            <input type="text" name="first-name" id="first-name-input">
            <label for="last-name">apellido</label>
            <input type="text" name="last-name" id="last-name-input">

            <label for="genre">Género (M/F)</label>
            <select name="genre" id="genre-input">
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="M">M</option>
                <option value="F">F</option>
            </select>



            <label for="born-date">Fecha de nacimiento</label>
            <input type="date" name="born-date" id="born-date-input">
            <br>
            <input type="submit" value="Actualizarme">
        </form>
    </div>

    <div class="footer">
        <h2>ITI - Programación Web</h2>
    </div>

    <script src="<?=APP_ROOT?>js/update_validation.js"></script>

</body>

</html>