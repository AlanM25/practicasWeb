<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?=APP_ROOT?>css/style.css" rel="stylesheet" type="text/css" />
    <title>Archivos Públicos</title>
    <script src="<?=APP_ROOT?>js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php require APP_PATH . "html_parts/info_usuario.php"; ?>

    <div class="header">
        <h1>Archivos Públicos</h1>
        <h4>Usuario: <?= htmlspecialchars($nombreUsuario) ?></h4>
    </div>

    <?php require APP_PATH . "html_parts/menu.php"; ?>

    <div class="row">
        <div class="leftcolumn">
            <div class="card">
                <h2>Listado de Archivos</h2>

                <!-- Filtros -->
                <form id="filter-form" method="get" action="" style="display: flex; gap: 1rem;">
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

                <!-- Tabla de archivos -->
                <table>
                    <thead>
                        <tr>
                            <th>Nombre del Archivo</th>
                            <th>Descripción</th>
                            <th>Tamaño (KB)</th>
                            <th>Fecha-Hora</th>
                            <th>Favorito</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        require APP_PATH . "data_access/db.php";

                        $db = getDbConnection();

                        // Filtros
                        $anio = isset($_GET['anio']) ? (int)$_GET['anio'] : date("Y");
                        $mes = isset($_GET['mes']) ? (int)$_GET['mes'] : date("m");

                        // Consulta a la base de datos
                        $query = "
                            SELECT 
                                a.id, 
                                a.nombre_archivo, 
                                a.descripcion, 
                                a.tamaño, 
                                a.fecha_subido, 
                                (CASE WHEN af.id IS NOT NULL THEN 1 ELSE 0 END) AS es_favorito
                            FROM 
                                archivos a
                            LEFT JOIN 
                                archivo_favorito af 
                                ON a.id = af.archivo_id AND af.usuario_id = ?
                            WHERE 
                                a.es_publico = 1
                                AND YEAR(a.fecha_subido) = ?
                                AND MONTH(a.fecha_subido) = ?";

                        $stmt = $db->prepare($query);
                        $stmt->execute([$USUARIO_ID, $anio, $mes]);

                        $archivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (empty($archivos)) {
                            echo "<tr><td colspan='6'>No se encontraron archivos en el periodo seleccionado.</td></tr>";
                        } else {
                            foreach ($archivos as $archivo) {
                                $tamanoKB = round($archivo['tamaño'] / 1024, 2);

                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($archivo['nombre_archivo']) . "</td>";
                                echo "<td>" . htmlspecialchars($archivo['descripcion']) . "</td>";
                                echo "<td>$tamanoKB KB</td>";
                                echo "<td>" . htmlspecialchars($archivo['fecha_subido']) . "</td>";
                                echo "<td>" . ($archivo['es_favorito'] ? "Sí" : "No") . "</td>";
                                echo "<td>";
                                echo "<button class='make_favorite' data-id='" . $archivo['id'] . "'>" . 
                                    ($archivo['es_favorito'] ? "Quitar de Favoritos" : "Marcar como Favorito") . 
                                    "</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>

        <?php require APP_PATH . "html_parts/page_right_column.php"; ?>
    </div>

    <div class="footer">
        <h2>ITI - Programación Web</h2>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.make_favorite').forEach(button => {
                button.addEventListener('click', async () => {
                    const fileId = button.getAttribute('data-id');
                    const response = await fetch('<?=APP_ROOT?>ajax/make_favorite.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
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
        });
    </script>
</body>
</html>
