<?php ob_start() ?>

<h1>Insertar Disponibilidad</h1>

<?php if(isset($params['error'])) :?>
<b><span style="color: red;"><?php echo $params['error'] ?></span></b><br>
<?php endif; ?>

<form action="index.php?ctl=insertarDisponibilidad" method="post">
    <label>Disponibilidad</label>
    <input type="text" name="disponibilidad" value="<?= isset($disponibilidad)?$disponibilidad:"";?>"></input>
    <?php echo(isset($errores['disponibilidad'])) ? "$errores[disponibilidad] <br>" : ""; ?>
    <br>
    <input type="submit" name="bGuardar" value="Guardar"></input>
</form>

<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>