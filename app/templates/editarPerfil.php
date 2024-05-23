<?php ob_start() ?>
<h1>Editar perfil</h1>

<?php if(isset($params['error'])) :?>
<b><span style="color: red;"><?php echo $params['error'] ?></span></b><br>
<b><span style="color: red;"><?php echo $params['errorDetalle'] ?></span></b>
<?php endif; ?>

<form action="index.php?ctl=editarPerfil" method="post" enctype="multipart/form-data">
    <label>Contraseña</label>
    <input type="text" name="contrasenya" value="<?= isset($contrasenya)?$contrasenya:"";?>"></input>
    <?php echo (isset($errores['contrasenya'])) ? "$errores[contrasenya] <br>" : ""; ?>
    <br>
    <label>Foto Perfil</label>
    <input type="file" name="foto" value="<?= isset($foto)?$foto : "";?>"></input>
    <?php echo (isset($errores['foto'])) ? "$errores[foto] <br>" : "";?>
    <br>
    <label>Idioma</label>
    <input type="checkbox" name="espanyol">Español</input>
    <?php echo (isset($errores['espanyol'])) ? "$errores[espanyol] <br>" : "";?>
    <input type="checkbox" name="ingles" value="<?= isset($ingles)?$ingles: "";?>">Inglés</input>
    <?php echo (isset($errores['ingles'])) ? "$errores[ingles] <br>" : "";?>
    <input type="checkbox" name="valenciano">Valenciano</input>
    <?php echo (isset($errores['valenciano'])) ? "$errores[valenciano] <br>" : "";?>
    <br>
    <label>Descripción</label>
    <input type="text" name="descripcion" value="<?=isset($descripcion)?$descripcion:"";?>"></input>
    <?php echo(isset($errores['descripcion'])) ? "$errores[descripcion] <br>" : ""; ?>
    <br>
    <input type="submit" name="bGuardar" value="Guardar"></input>
</form>

<?php $contenido = ob_get_clean() ?>
<?php include 'layout.php' ?>