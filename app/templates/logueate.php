<?php ob_start() ?>
<h1>Si quieres mas información de los servicios tienes que Loguearte</h1>
<a href="index.php?ctl=inicio">Volver</a>
<?php $contenido = ob_get_clean() ?>
<?php include 'layout.php' ?>