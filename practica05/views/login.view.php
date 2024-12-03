<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?=APP_ROOT?>css/style.css" rel="stylesheet" type="text/css" /> 
    <title>Práctica 05: </title>
    <script src="<?=APP_ROOT?>js/config.js"></script>
</head>
<body>

    <?php require APP_PATH . "html_parts/info_usuario.php" ?>

    <div class="header">
        <h1>Práctica 05</h1>
        <h2>File Manager</h2>
    </div>
      
    <?php require APP_PATH . "html_parts/menu.php"; ?>
      
    <div class="row">

        <div class="leftcolumn">

            <div class="card">
                <h2>Login</h2>
                <h5>Inicio de sesión para el File Manager</h5>
                <p>Debe iniciar sesión para poder ingresar a la aplicación</p>
                <form action="<?=APP_ROOT?>do_login.php" method="POST">
                    <table>
                        <tr>
                            <td><label for="txt-username">Username:</label></td>
                            <td><input type="text" name="username" id="txt-username" required />
                        </tr>
                        <tr>
                            <td><label for="txt-password">Password:</label></td>
                            <td><input type="password" name="password" id="txt-password" required />
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" value="ENTRAR" /></td>
                        </tr>
                    </table>
                </form>
            </div>

            <div class="card">
                <h2>Registro</h2>
                <h5>Registro de nuevos usuarios</h5>
                <p>
                    Para poder acceder a los servicios de esta aplicación, debe temer una cuenta. 
                    Si usted todavía no tiene una cuenta, haga click en el siguiente link para registrarse.
                </p>
                <p><a href="<?=APP_ROOT?>register.php">REGISTRARME</a></p>
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
