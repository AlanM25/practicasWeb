<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloPagina; ?></title>
</head>
<body>
    <h1><?=$tituloPagina?></h1>
    <?php require 'parte_html.php'; ?>
    <p>Ejemplo de generacion de HTML dinamico usando PHP</p>
    <ul>
        <?php
            for($i = 0; $i < 10; $i++){
                echo "<li>Hola Mundo $i</li>";
            }
        ?>
    </ul>
    <p>Otra lista generada por PHP</p>
    <ul>
        <?php for ($i = 1; $i < 15; $i++): ?>
            <li>Hola Mundo!!! <?=$i?></li>
        <?php endfor ?>
    </ul>
    <h3>Lista de Personas</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Edad</th>
                <th>Deportes Practicados</th>
                <th>Ver Detalle</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($personas as $p): ?>
                <tr>
                    <td><?=$p['nombre']?></td>
                    <td><?=$p['apellidos']?></td>
                    <td><?=$p['edad']?></td>
                    <td>
                        <ul>
                            <?php foreach ($p['deportesPracticados'] as $d): ?>
                                <li><?=$d?></li>
                            <?php endforeach ?>
                        </ul>
                    </td>
                    <td>
                        <a href="busqueda.php?q=<?=urlencode($p['nombre'] . ' ' . $p['apellidos'])?>">[VER DETALLE]</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <h3>Formularios</h3>
    <fieldset>
        <legend>Busqueda</legend>
        <form action="http://www.google.com/search" method="GET">
        <label>Buscar: </label>
        <input type="text" name="q" id="txt-q" placeholder="buscar...">
        <input type="submit" value="Buscar">
    </form>
    </fieldset>
    <fieldset>
        <legend>Login</legend>
        <form action="do_login.php" method="POST">
            <table>
                <tr>
                    <td><label for="txt_username">Username: </label></td>
                    <td><input type="text" name="username" ></td>
                </tr>
                <tr>
                    <td><label for="txt_password">Password: </label></td>
                    <td><input type="text" name="password"></td>
                </tr>
                <tr>
                    <td><button>ENTRAR</button></td>
                </tr>
            </table>
        </form>
    </fieldset>
    <fieldset>
        <legend>AJAX</legend>
        <p>Fecha hora del server: <strong id="s-fecha-hora"></strong></p>
        <button id="btn-get-fecha-hora">Actualizar Fecha Hora</button>
    </fieldset>
    <script src="index.js"></script>
</body>
</html>