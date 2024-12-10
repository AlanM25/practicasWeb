<?php require_once APP_PATH . "session.php"; ?>

<div class="topnav">
    <?php if ($USUARIO_AUTENTICADO): ?>
        <a href="<?= APP_ROOT ?>">Home</a>
        <a href="<?= APP_ROOT ?>enviar_datos_con_form.php">Enviar Datos<br />con form</a>
        <a href="<?= APP_ROOT ?>enviar_datos_con_ajax.php">Enviar Datos<br /> con AJAX</a>
        <a href="<?= APP_ROOT ?>update_data.php">Update data<br /> con AJAX</a>
        <?php if ($USUARIO_ES_ADMIN) : ?>
            <a href="<?= APP_ROOT ?>user_management.php">Gestión de Usuarios</a>
        <?php endif ?>
        <a href="<?= APP_ROOT ?>vistaparaArchivos.php">Mis Archivos</a>
        <a href="<?= APP_ROOT ?>buscar_usuario.php">Buscar usuarios</a>
        <a href="<?= APP_ROOT ?>archivos_favoritos.php">Archivos Favoritos</a>
        <a href="#" style="float:right">Link</a>
    <?php else: ?>
        <a href="<?= $APP_ROOT . "login.php" ?>">Login</a>
    <?php endif; ?>

</div>