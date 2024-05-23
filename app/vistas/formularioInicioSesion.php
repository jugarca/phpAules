<form action="" method="post">
    <label>Login</label>
    <input type="text" name="login" value="<?= isset($login) ? $login : "";?>"></input>
    <?php echo(isset($errores['login'])) ? "$errores[login] <br>" : "";?>
    <br>
    <label>Password</label>
    <input type="text" name="pass" value="<?= isset($pass) ? $pass : "";?>"></input>
    <?php echo(isset($errores['pass'])) ? "$errores[pass] <br>" : "";?>
    <br>
    <?php echo(isset($errores['usuario'])) ? "$errores[usuario] <br>" : "";?>
    <a href="pantallaRegistro.php">Registrate</a>
    <br>
    <input type="submit" name="bInicio" value="Inicio"></input>
</form>