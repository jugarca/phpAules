<form action="" method="post">
    <label>Contraseña</label>
    <input type="text" name="contrasenya" value="<?= isset($contrasenya)?$contrasenya:"";?>"></input>
    <?php echo (isset($errores['contrasenya'])) ? "$errores[contrasenya] <br>" : ""; ?>
    <br>
    <label>Foto Perfil</label>
    <input type="text" name="foto" value="<?= isset($foto)?$foto:"";?>"></input>
    <?php echo (isset($errores['foto'])) ? "$errores[foto] <br>" : ""; ?>
    <br>
    <label>Idioma</label>
    <input type="text" name="idioma" value="<?= isset($idioma)?$idioma:"";?>"></input>
    <?php echo(isset($errores['idioma'])) ? "$errores[idioma] <br>" : ""; ?>
    <br>
    <label>Descripción</label>
    <input type="text" name="descripcion" value="<?=isset($descripcion)?$descripcion:"";?>"></input>
    <?php echo(isset($errores['descripcion'])) ? "$errores[descripcion] <br>" : ""; ?>
    <br>
    <input type="submit" name="bGuardar" value="Guardar"></input>
</form>