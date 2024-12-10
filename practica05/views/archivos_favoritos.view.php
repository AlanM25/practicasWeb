<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?=APP_ROOT?>css/style.css" rel="stylesheet" type="text/css" /> 
    <title>Mis Favoritos</title>
    <script src="<?=APP_ROOT?>js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php require APP_PATH . "html_parts/info_usuario.php" ?>

    <div class="header">
        <h1>Mis Archivos Favoritos</h1>
        <h4>Bienvenido <?=$USUARIO_NOMBRE_COMPLETO?></h4>
    </div>

    <?php require APP_PATH . "html_parts/menu.php"; ?>

    <div class="row">
        <div class="leftcolumn">
            <div class="card">
                <h2>Archivos Marcados como Favoritos</h2>
                <table>
                    <tbody>
                        <?php
                            require APP_PATH . "data_access/db.php";

                                $db = getDbConnection();

                                $query = "
                                    SELECT 
                                        a.id, 
                                        a.nombre_archivo, 
                                        a.descripcion, 
                                        a.fecha_subido, 
                                        a.tamaño, 
                                        a.es_publico, 
                                        u.username AS usuario_username,
                                        CONCAT(u.nombre, ' ', u.apellidos) AS usuario_nombre_completo, 
                                        af.fecha_favorito
                                    FROM archivo_favorito af
                                    JOIN archivos a ON af.archivo_id = a.id
                                    JOIN usuarios u ON a.usuario_subio_id = u.id
                                    WHERE af.usuario_id = ?
                                    ORDER BY af.fecha_favorito DESC
                                ";

                                $stmt = $db->prepare($query);
                                $stmt->execute([$USUARIO_ID]);
                                $archivosFavoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Mostrar archivos favoritos
                                if (count($archivosFavoritos) > 0) {
                                    echo "<table>";
                                    echo "<thead>";
                                    echo "<tr><th>Nombre del Archivo</th><th>Descripción</th><th>Usuario</th><th>Tamaño (KB)</th><th>Acciones</th></tr>";
                                    echo "</thead>";
                                    echo "<tbody>";

                                    foreach ($archivosFavoritos as $archivo) {
                                        
                                        $esPublico = $archivo['es_publico'] == 1;
                                        $tamanoKB = round($archivo['tamaño'] / 1024, 2);
                                        $urlArchivo = APP_ROOT . "archivo.php?id=" . $archivo['id'] . "&descargar=0";
                                        $urlUsuario = APP_ROOT . "archivos_usuario.php?usuario=" . $archivo['usuario_username']; 

                                        if ($esPublico || $archivo['usuario_username'] === $USUARIO_USERNAME) {
                                            echo "<tr>";
                                            echo "<td><a href='$urlArchivo' target='_blank'>" . htmlspecialchars($archivo['nombre_archivo']) . "</a></td>";
                                            echo "<td>" . htmlspecialchars($archivo['descripcion']) . "</td>";
                                            echo "<td><a href='$urlUsuario' target='_blank'>" . htmlspecialchars($archivo['usuario_nombre_completo']) . "</a></td>";
                                            echo "<td>" . htmlspecialchars($tamanoKB) . " KB</td>";
                                            echo "<td><button class='remove_favorite' data-id='" . $archivo['id'] . "'>Desmarcar como Favorito</button></td>";
                                            echo "</tr>";
                                        }
                                    }

                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "<p>No tienes archivos favoritos.</p>";
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
            document.querySelectorAll('.remove_favorite').forEach(button => {
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
                        Swal.fire('Éxito', result.message, 'success').then(() => {
                            button.closest('tr').remove();
                        });
                    } else {
                        Swal.fire('Error', result.message, 'error');
                    }
                });
            });
        });
    </script>
</body>
</html>
