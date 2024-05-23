<?php ob_start() ?>

<h1>Token incorrecto o expirado</h1>

<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>