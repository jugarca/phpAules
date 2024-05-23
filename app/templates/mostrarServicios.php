<?php ob_start() ?>

<table>
    <tr>
        <th>id Servicios</th>
        <th>titulo</th>
        <th>id_user</th>
        <th>descripcion</th>
        <th>precio</th>
        <th>tipo</th>
        <th>foto_servicio</th>
    </tr>
    <?php foreach ($params['servicios'] as $servicios) :?>
        <tr>
            <td><a href="index.php?ctl=verServio&id=<?php echo $servicios['id_disponibilidad']?>">
            <?php echo $servicios['id_servicios'] ?></a></td>
            <td><?php echo $servicios['titulo']?></td>
            <td><?php echo $servicios['id_user']?></td>
            <td><?php echo $servicios['descrpcion']?></td>
            <td><?php echo $servicios['precio']?></td>
            <td><?php echo $servicios['tipo']?></td>
            <td><?php echo $servicios['foto_servicio']?></td>
        </tr>
    <?php endforeach; ?>

</table>


<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>
