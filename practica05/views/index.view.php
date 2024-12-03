<!DOCTYPE html>
<html lang="en">
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
            <h2>Listado de Archivos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre del Archivo</th>
                        <th>Fecha y Hora de Subida</th>
                        <th>Peso (KB)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    require APP_PATH . "data_access/db.php";
                    
                    $db = getDbConnection();
                    $stmt = $db->prepare("SELECT id, nombre_archivo, fecha_subido, tamaño FROM archivos WHERE usuario_subio_id = :usuario_id");
                    $stmt->bindParam(":usuario_id", $USUARIO_ID, PDO::PARAM_INT);
                    $stmt->execute();
                    $archivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($archivos as $archivo) {
                        $tamanoKB = round($archivo['tamano'] / 1024, 2);
                        $urlArchivo = APP_ROOT . "archivo.php?id=" . $archivo['id'] . "&descargar=0";
                        echo "<tr>";
                        echo "<td><a href='$urlArchivo' target='_blank'>" . htmlspecialchars($archivo['nombre_archivo']) . "</a></td>";
                        echo "<td>" . htmlspecialchars($archivo['fecha_subido']) . "</td>";
                        echo "<td>" . htmlspecialchars($tamanoKB) . "</td>";
                        echo "<td>
                                <button class='make-public' data-id='" . $archivo['id'] . "'>Hacer Público</button>
                                <button class='delete-file' data-id='" . $archivo['id'] . "'>Borrar</button>
                            </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

            <div class="card">
                <h2>Creación Dinámica de HTML con PHP</h2>
                <h5>Ciclos para recorrer arrays, <?php echo $hoy->format("d/m/Y"); ?></h5>
                <p>Ciclo FOR para recorrer un array e ir imprimiendo el resultado.</p>
                <ul>
                    <?php for ($i = 0; $i < count($array01); $i++) { ?> 
                        <li><?=$array01[$i]?></li>
                    <?php } ?>
                </ul>
                 <p>Ciclo FOREACH para recorrer todos los elementos de un array</p>
                <ul>
                <?php foreach ($array01 as $a) { ?>
                    <li><?=$a?></li>
                <?php } ?>
                </ul>
                <p>Listado desde otro archivo. Podermos mandar llamar otro archivo PHP y lo que nos de de resultado imprimirlo aquí.</p>
                <?php include APP_PATH . "html_parts/listado.php"; ?>
                <p>
                    Listado de artículos. Aquí creamos links dimámicos según el array de arrays 
                    asociativos. También aquí se envían datos mediante parámetros URL a la
                    página (ruta) articulo.php
                </p>
                <ul>
                    <?php foreach ($articulos as $a) { ?>
                        <li><a href="<?=APP_ROOT?>articulo.php?id=<?=$a["id"]?>&titulo=<?=urlencode($a["titulo"])?>"><?=$a["titulo"]?></a></li>
                    <?php } ?>
                </ul>
            </div>

        </div>  <!-- End left column -->

        <!-- Incluimos la parte derecha de la página, que está procesada en otro archivo -->
        <?php require APP_PATH . "html_parts/page_right_column.php"; ?>

    </div>  <!-- End row-->

    <div class="footer">
        <h2>ITI - Programación Web</h2>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.make-public').forEach(button => {
                button.addEventListener('click', async () => {
                    const fileId = button.getAttribute('data-id');
                    const response = await fetch('<?=APP_ROOT?>ajax/make_public.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: fileId }),
                    });
                    const result = await response.json();
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Archivo hecho público exitosamente.',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al hacer público el archivo.',
                        });
                    }
                });
            });

            document.querySelectorAll('.delete-file').forEach(button => {
                button.addEventListener('click', async () => {
                    const fileId = button.getAttribute('data-id');
                    const response = await fetch('<?=APP_ROOT?>ajax/delete_file.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: fileId }),
                    });
                    const result = await response.json();
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Archivo borrado exitosamente.',
                        }).then(() => {
                            button.closest('tr').remove();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al borrar el archivo.',
                        });
                    }
                });
            });
        });
    </script>   
</body>
</html>
