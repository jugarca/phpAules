<form action="" method="post" enctype="multipart/form-data">
    <label>Nombre</label>
    <input type="text" name="nombre" value="<?= isset($nombre)?$nombre: "";?>"></input>
    <?php echo (isset($errores['nombre'])) ? "$errores[nombre] <br>" : "";?>
    <br>
    <label>Email</label>
    <input type="text" name="email" value="<?= isset($email)?$email: "";?>"></input>
    <?php echo (isset($errores['email'])) ? "$errores[email] <br>" : ""; ?>
    <br>
    <label>Contraseña</label>
    <input type="text" name="contrasenya" value="<?= isset($contrasenya)?$contrasenya: "";?>"></input>
    <?php echo (isset($errores['contrasenya'])) ? "$errores[contrasenya] <br>" : ""; ?>
    <br>
    <label>Fecha Nacimiento</label>
    <input type="text" name="fecha" value="<?= isset($fecha)?$fecha: "";?>"></input>
    <?php echo (isset($errores['fecha'])) ? "$errores[fecha] <br>" : "";?>
    <br>
    <label>Foto Perfil</label>
    <input type="file" name="foto" value="<?= isset($foto)?$foto : "";?>"></input>
    <?php echo (isset($errores['foto'])) ? "$errores[foto] <br>" : "";?>
    <br>
    <label>Idioma</label>
    <input type="text" name="idioma" value="<?= isset($idioma)?$idioma: "";?>"></input>
    <?php echo (isset($errores['idioma'])) ? "$errores[idioma] <br>" : "";?>
    <br>
    <label>Descripción</label>
    <input type="text" name="descripcion" value="<?= isset($descripcion)?$descripcion: "";?>"></input>
    <?php echo(isset($erroes['descripcion'])) ? "$errores[descripcion] <br>": "";?>
    <br>
    <input type="submit" name="bRegistro" value="Registro"></input>
</form>