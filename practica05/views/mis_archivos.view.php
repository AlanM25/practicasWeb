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
                <h2>Mis Archivos</h2>
                    <form id="filter-form" method="get" action="" style="justify-content: end">
                        <label for="anio">Año:</label>
                        <select id="anio" name="anio">
                            <?php
                            $anioActual = date("Y");
                            for ($i = $anioActual; $i >= $anioActual - 10; $i--) {
                                $selected = isset($_GET['anio']) && $_GET['anio'] == $i ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>

                        <label for="mes">Mes:</label>
                        <select id="mes" name="mes">
                            <option value="">Todos</option>
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                $mesNombre = date("F", mktime(0, 0, 0, $i, 1));
                                $selected = isset($_GET['mes']) && $_GET['mes'] == $i ? 'selected' : '';
                                echo "<option value='$i' $selected>$mesNombre</option>";
                            }
                            ?>
                        </select>
                        <button type="submit">Filtrar</button>
                    </form>
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

                            // Filtros
                            $anio = isset($_GET['anio']) ? (int)$_GET['anio'] : null;
                            $mes = isset($_GET['mes']) ? (int)$_GET['mes'] : null;

                            $query =  "SELECT a.id, a.nombre_archivo, a.fecha_subido, a.tamaño, a.es_publico, 
                                        IF(af.usuario_id IS NOT NULL, 1, 0) AS es_favorito
                                        FROM archivos a
                                        LEFT JOIN archivo_favorito af ON a.id = af.archivo_id AND af.usuario_id = ?
                                        WHERE a.usuario_subio_id = ?";

                            if ($anio && $mes) {
                                $query .= " AND YEAR(fecha_subido) = ? AND MONTH(fecha_subido) = ?";
                            }

                            $stmt = $db->prepare($query);

                            if ($anio && $mes) {
                                $stmt->execute([$USUARIO_ID, $USUARIO_ID, $anio, $mes]);
                            } else {
                                $stmt->execute([$USUARIO_ID, $USUARIO_ID]);
                            }

                            $archivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($archivos as $archivo) {
                                $tamanoKB = round($archivo['tamaño'] / 1024, 2);
                                $urlArchivo = APP_ROOT . "archivo.php?id=" . $archivo['id'] . "&descargar=0";

                                echo "<tr>";
                                echo "<td><a href='$urlArchivo' target='_blank'>" . htmlspecialchars($archivo['nombre_archivo']) . "</a></td>";
                                echo "<td>" . htmlspecialchars($archivo['fecha_subido']) . "</td>";
                                echo "<td>" . htmlspecialchars($tamanoKB) . "</td>";
                                echo "<td>";
                                // Botones para las acciones
                                echo "<button class='make_public' data-id='" . $archivo['id'] . "'>" . 
                                    ($archivo['es_publico'] ? "Hacer Privado" : "Hacer Público") . 
                                    "</button>";
                                echo "<button class='make_favorite' data-id='" . $archivo['id'] . "'>" . 
                                    ($archivo['es_favorito'] ? "Quitar Favorito" : "Marcar Favorito") . 
                                    "</button>";
                                echo "<button class='delete-file' data-id='" . $archivo['id'] . "'>Borrar</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // make public or private
            document.querySelectorAll('.make_public').forEach(button => {
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
                        Swal.fire('Éxito', result.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error', result.message, 'error');
                    }
                });
            });

            // make favorite or unfavorite
            document.querySelectorAll('.make_favorite').forEach(button => {
                button.addEventListener('click', async () => {
                    const fileId = button.getAttribute('data-id');
                    const response = await fetch('<?=APP_ROOT?>ajax/make_favorite.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: fileId }),
                    });
                    const result = await response.json();
                    if (result.success) {
                        Swal.fire('Éxito', result.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error', result.message, 'error');
                    }
                });
            });

            // delete file
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
