<?php ob_start() ?>
<h1>Pagina de prueba de error</h1>
<h3> Error: <?php echo $params['error'] ?> </h3>
<?php $contenido = ob_get_clean() ?>
<?php include 'layout.php' ?>
