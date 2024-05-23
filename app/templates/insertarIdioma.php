<?php ob_start() ?>

<h1>Insertar Idioma</h1>

<?php if(isset($params['error'])) :?>
<b><span style="color: red;"><?php echo $params['error'] ?></span></b><br>
<?php endif; ?>

<form action="index.php?ctl=insertarIdioma" method="post">
    <label>Idioma</label>
    <input type="text" name="idioma" value="<?= isset($idioma)?$idioma:"";?>"></input>
    <?php echo(isset($errores['idioma'])) ? "$errores[idioma] <br>" : ""; ?>
    <br>
    <input type="submit" name="bGuardar" value="Guardar"></input>
</form>

<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>