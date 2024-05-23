<?php ob_start() ?>
<h1>Pagina de prueba de Judit</h1>
<h3> Frase: <?php echo $params['judit'] ?> </h3>
<?php $contenido = ob_get_clean() ?>
<?php include 'layout.php' ?>
