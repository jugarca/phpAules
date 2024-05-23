<?php ob_start() ?>

<a href="index.php?ctl=listarIdioma">Mantenimiento de Idiomas</a>
<a href="index.php?ctl=listarDisponibilidad">Mantenimiento de Disponibilidad</a>

<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>