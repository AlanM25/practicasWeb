
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?=APP_ROOT?>css/style.css" rel="stylesheet" type="text/css" /> 
    <title><?php echo $tituloPagina; ?></title>
    <script src="<?=APP_ROOT?>js/config.js"></script>
</head>
<body>

    <?php require APP_PATH . "html_parts/info_usuario.php" ?>

    <div class="header">
        <h1>Práctica 05</h1>
        <h2>Basic Server Side Programming</h2>
    </div>
      
    <?php require APP_PATH . "html_parts/menu.php"; ?>
      
    <div class="row">

        <div class="leftcolumn">

            <div class="card">
                <h2>Enviar Datos por POST</h2>
                <h5>Datos simples enviados por POST al server. Mar 12, 2024</h5>
                <p>
                    Se envían los datos que están en los inputs dentro de la etiqueta form en un
                    formato key-value, donde el key es el atributo name del input y el value lo que
                    se le asigne como valor al input (lo que el usuario ingrese). Estos datos se envían
                    dentro del payload del HTTP POST Request (es POST porque así lo especifica el 
                    atributo method del form) en un format de tipo parémetros URL.
                </p>
                <p>
                    Por ejemplo, si se ingresan los valores "Mi Nombre" y "Mis Apellidos" en los inputs
                    nombre y apellidos respectivamente, el payload del request sería:
                    <br />
                    nombre=Mi+Nombre&apellidos=Mis+Apellidos
                </p>
                <p>
                    <strong>Nota</strong>: Los caractéres especiales (como acentos, '%', '&', 'í'...) se
                    codifican usando 
                    <a href="https://www.w3schools.com/tags/ref_urlencode.asp" target="_blank"
                            title="Vea la tabla de referencia de los caracteres encodeados">
                        URL Encoding
                    </a>. 
                    Del lado del servidor (código PHP) no hay problema con esta codificación, porque
                    cuando accedemos a los datos, estos ya han sido decodificados. 
                </p>
                <form action="recibir_por_post.php" method="POST">
                    <table>
                        <tbody>
                            <tr>
                                <td><label for="txt-nombre">Nombre: </label></td>
                                <td><input type="text" name="nombre" id="txt-nombre" placeholder="Ingrese su nombre" required /></td>
                            </tr>
                            <tr>
                                <td><label for="txt-apellidos">Apellidos: </label></td>
                                <td><input type="text" name="apellidos" id="txt-apellidos" placeholder="Ingrese sus apellidos" required /></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" value="ENVIAR" /></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>

            <div id="div-enviar-archivo" class="card">
                <h2>Enviar Archivos por POST</h2>
                <h5>Title description, Mar 13, 2024</h5>
                <p>
                    Para enviar archivos, es necesario usar otro tipo de serialización que permita
                    ingresar archivos. Para esto se usa el multipart/form-data, puesto que es una 
                    de las formas más usadas para envío de archivos (binarios) del lado del client 
                    al server, además de datos simples (inputs text o cualquier otro input que no 
                    sea file).
                </p>
                <p>
                    Como cualquier otro HTTP POST Request, los datos/archivos se enviarán dentro
                    del payload de la petición.
                </p>
                <form action="guardar_archivo.php" method="POST" enctype="multipart/form-data">
                    <table>
                        <tbody>
                            <tr>
                                <td><label for="txt-otro-dato">Otro Dato: </label></td>
                                <td><input type="text" name="otroDato" id="txt-otro-dato" /></td>
                            </tr>
                            <tr>
                                <td><label for="input-archivo">Archivo: </label></td>
                                <td><input type="file" name="archivo" id="input-archivo" accept=".jpg,.jpeg,.png,.gif" required /></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" value="Guardar Archivo" /></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
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
