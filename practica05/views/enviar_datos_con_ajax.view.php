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
                <h2>AJAX GET Request</h2>
                <p>
                    La petición que hacemos se realiza con AJAX GET, y nos regresa un JSON. 
                    La respuesta JSON la podemos usar comodamente en Javascript porque
                    un JSON lo transformamos en un object JS nativo.
                </p>
                <p>Fecha hora del server: <strong id="lbl-fecha-hora">[NO OBTENIDO]</strong></p>
                <p>
                    <input id="btn-obtener-fecha-hora" type="button" value="Obtener Fecha Hora"> 
                    <input id="btn-obtener-fecha-hora-async" type="button" value="Obtener Fecha Hora Async">
                </p>                
            </div>

            <div class="card">
                <h2>AJAX POST Request</h2>
                <p>
                    Se envían los datos usando una petición AJAX POST. Los datos se envian 
                    dentro de la petición, esta petición es de tipo multipart/form-data, 
                    puesto que es el default del objeto FormData que usamos para poner 
                    los datos dentro de la petición.
                </p>
                <form id="form-post-ajax" action="ajax/post-example.php" method="POST">
                    <table>
                        <tr>
                            <td><label for="txt-nombre">Nombre: </label></td>
                            <td><input type="text" name="nombre" id="txt-nombre" required /></td>
                        </tr>
                        <tr>
                            <td><label for="txt-apellidos">Apellidos: </label></td>
                            <td><input type="text" name="apellidos" id="txt-apellidos" required /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" value="Enviar" style="width: 100%;"></td>
                        </tr>
                    </table>
                </form>
            </div>

            <div class="card">
                <h2>AJAX POST Request enviando un JSON</h2>
                <p>
                    Aquí los datos se van a enviar en la serialización JSON (que es un string),
                    que posteriomente lo recibiremos del lado del server y ese JSON lo vamos a 
                    transformar en un assoc array para poder obtener los datos que se enviaron.
                </p>
                <form id="form-post-ajax-json" action="ajax/recibe-datos-json.php" method="POST">
                    <label for="txt-nombre-json">Nombre: </label>
                    <input type="text" name="nombre" id="txt-nombre-json" required />
                    <br />
                    <label for="txt-apellidos-json">Apellidos: </label>
                    <input type="text" name="apellidos" id="txt-apellidos-json" required />
                    <br />
                    <input type="submit" value="Enviar">
                </form>
            </div>

            <div class="card">
                <h2>Enviar Archivos con AJAX</h2>
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
                            <td><input id="btn-enviar-archivo" type="submit" value="Guardar Archivo" /></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>  <!-- End left column -->

        <!-- Incluimos la parte derecha de la página, que está procesada en otro archivo -->
        <?php require APP_PATH . "html_parts/page_right_column.php"; ?>

    </div>  <!-- End row-->

    <div class="footer">
        <h2>ITI - Programación Web</h2>
    </div>

    <script src="<?=APP_ROOT?>js/enviar_datos_con_ajax.js"></script>
    
    

</body>
</html>
