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
    <input type="checkbox" name="espanyol">Español</input>
    <?php echo (isset($errores['espanyol'])) ? "$errores[espanyol] <br>" : "";?>
    <input type="checkbox" name="ingles" value="<?= isset($ingles)?$ingles: "";?>">Inglés</input>
    <?php echo (isset($errores['ingles'])) ? "$errores[ingles] <br>" : "";?>
    <input type="checkbox" name="valenciano">Valenciano</input>
    <?php echo (isset($errores['valenciano'])) ? "$errores[valenciano] <br>" : "";?>
    <br>
    <label>Descripción</label>
    <input type="text" name="descripcion" value="<?= isset($descripcion)?$descripcion: "";?>"></input>
    <?php echo(isset($erroes['descripcion'])) ? "$errores[descripcion] <br>": "";?>
    <br>
    <input type="submit" name="bRegistro" value="Registro"></input>

    <?php echo (isset($errores['guardado'])) ? "$errores[guardado] <br>" : "";?>
</form>