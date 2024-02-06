<?php ob_start() ?>
<h1>Inicio</h1>
<form action="index.php?ctl=login" method="post">
    <label>Login</label>
    <input type="text" name="login" value="<?= isset($login) ? $login : "";?>"></input>
    <?php echo(isset($errores['login'])) ? "$errores[login] <br>" : "";?>
    <br>
    <label>Password</label>
    <input type="text" name="pass" value="<?= isset($pass) ? $pass : "";?>"></input>
    <?php echo(isset($errores['pass'])) ? "$errores[pass] <br>" : "";?>
    <br>
    <br>
    <?php echo(isset($errores['usuario'])) ? "$errores[usuario] <br>" : "";?>
    <a href="index.php?ctl=registrate">Registrate</a>
    <br>
    <input type="submit" name="bInicio" value="Iniciar Sesion"></input>
</form>
<br>
<br>

<h1>Lista de Servicios</h1>

<!-- Recorrer y mostrar los servicios de Inicio -->
<table>
    <tr>
        <th>Titulo</th>
        <th>Precio</th>
    </tr>
    <?php foreach ($params['serviciosInicio'] as $servicio) :?>
        <tr>
            <td>
                <a href="index.php?ctl=logueate">
                <?php echo $servicio['titulo'] ?></a></td>
            <td><?php echo $servicio['precio']?></td>
            </tr>
    <?php endforeach; ?>
</table>

<?php $contenido = ob_get_clean() ?>
<?php include 'layout.php' ?>

