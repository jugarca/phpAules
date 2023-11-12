<form action="" method="post" id="formularioAltaServicios"  enctype="multipart/form-data">
    <label>Titulo</label>
    <input type="text" name="titulo" value="<?= isset($titulo)?$titulo:"";?>"></input>
    <?php echo(isset($errores['titulo'])) ? "$errores[titulo] <br>" : ""; ?>
    <br>
    <label>Categoría</label>
    <input type="text" name="categoria" value="<?= isset($categoria)?$categoria:"";?>"></input>
    <?php echo(isset($errores['categoria'])) ? "$errores[categoria] <br>" : ""; ?>
    <br>
    <label>Descripción</label>
    <input type="text" name="descripcion" value="<?= isset($descripcion)?$descripcion:"";?>"></input>
    <?php echo(isset($errores['descripcion'])) ? "$errores[descripcion] <br>" : ""; ?>
    <br>
    <label>Tipo</label>
    <!-- todo -->
    <select name="tipo" id="tipo" form="formularioAltaServicios">
        <option value="intercambio">intercambio</option>
        <option value="pago">de pago</option>
    </select>
    <?php echo(isset($errores['tipo'])) ? "$errores[tipo] <br>" : ""; ?>
    <br>
    <label> Precio Hora</label>
    <input type="text" name="precio" value="<?= isset($precio)? $precio:"";?>"></input>
    <?php echo(isset($errores['precio'])) ? "$errore[precio] <br>" : ""; ?>
    <br>
    <label>Ubicación</label>
    <input type="text" name="ubicacion" value="<?= isset($ubicacion)?$ubicacion:"";?>">
    <?php echo(isset($errores['ubicacion'])) ? " $errores[ubicacion] <br>" : ""; ?>
    <br>
    <label>Disponibilidad</label>
    <!--todo: como se le pasa el error al -->
    <select name="disponibilidad" id="disponibilidad">
        <option value="manyana">mañana</option>
        <option value="tarde">tarde</option>
        <option value="noche">noche</option>
        <option value="completa">completa</option>
        <option value="finSemana">fines de semana</option>
    </select>
    <?php echo(isset($errores['disponibilidad'])) ? " $errores[disponibilidad] <br>" : ""; ?>
    <br>
    <label>Foto</label>
    <input type="file" name="foto" value="<?= isset($foto)?$foto:"";?>">
    <?php echo(isset($errores['foto'])) ? "$errores[foto] <br>" : ""; ?>
    <br>
    <input type="submit" name="bGuardar" value="Guardar"></input>
</form>