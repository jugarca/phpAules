<form action="" method="post">

    <label> Idioma: </label>
    <input type="text" name="idioma" value="<?=isset($idioma)?$idioma:"";?>"></input>
    <br>
    <?php echo(isset($errores['idioma']))?"$errores[idioma] <br>": "";?>
    <input type="submit" name="bIdioma" value="bIdioma">

</form>