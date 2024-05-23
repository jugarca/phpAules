<?php ob_start() ?>

<form action="index.php?ctl=guardarServicio" method="post" enctype="multipart/form-data">
    <label>Titulo</label>
    <input type="text" name="titulo" value="<?= isset($titulo)?$titulo:"";?>"></input>
    <?php echo(isset($errores['titulo'])) ? "$errores[titulo] <br>" : ""; ?>
    <br>
    <label>Categoría</label>
    <select name="categoria" id="categoria">
        <option value="categoria1">categoría 1</option>
        <option value="categoria2">categoría 2</option>
        <option value="categoria3">categoría 3</option>
        <option value="categoria4">categoría 4</option>
    </select>
    <?php echo(isset($errores['categoria'])) ? "$errores[categoria] <br>" : ""; ?>
    <br>
    <label>Descripción</label>
    <input type="text" name="descripcion" value="<?= isset($descripcion)?$descripcion:"";?>"></input>
    <?php echo(isset($errores['descripcion'])) ? "$errores[descripcion] <br>" : ""; ?>
    <br>
    <label>Tipo</label>
    <!-- todo -->
    <select name="tipo" id="tipo">
        <option value="1">intercambio</option>
        <option value="2">de pago</option>
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

<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>