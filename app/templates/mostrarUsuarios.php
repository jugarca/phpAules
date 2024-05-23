<?php ob_start() ?>

<table>
    <tr>
        <th>id_user</th>
        <th>Nombre</th>
        <th>email</th>
        <th>pass</th>
        <th>f_nacimiento</th>
        <th>foto_perfil</th>
        <th>descripcion</th>
        <th>nivel</th>
        <th>activo</th>
    </tr>
    <?php foreach ($params['usuarios'] as $usuario) :?>
        <tr>
            <td><a href="index.php?ctl=ver&id=<?php echo $usuario['id_user']?>">
            <?php echo $usuario['id_user'] ?></a></td>
            <td><?php echo $usuario['nombre']?></td>
            <td><?php echo $usuario['email']?></td>
            <td><?php echo $usuario['pass']?></td>
            <td><?php echo $usuario['f_nacimiento']?></td>
            <td><?php echo $usuario['foto_perfil']?></td>
            <td><?php echo $usuario['descripción']?></td>
            <td><?php echo $usuario['nivel']?></td>
            <td><?php echo $usuario['activo']?></td>
        </tr>
    <?php endforeach; ?>

</table>


<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>
