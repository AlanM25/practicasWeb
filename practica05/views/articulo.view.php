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
        <h2><?=htmlspecialchars($titulo)?></h2>
        <h5>Este artículo tiene el Id  <?=$id?></h5>
        <div class="fakeimg" style="height:200px;">Image</div>
        <p>Aquí se muestran los datos obtenidos desde los parámetros URL</p>
      </div>

      <div class="card">
        <h2>TITLE HEADING</h2>
        <h5>Title description, Feb 14, 2023</h5>
        <div class="fakeimg" style="height:200px;">Image</div>
        <p>Some text..</p>
        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
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
