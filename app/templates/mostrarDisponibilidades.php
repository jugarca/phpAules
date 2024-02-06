<?php ob_start() ?>

<h1><?php $params['titulo'] ?> </h1>
<h4><a href="index.php?ctl=insertarDisponibilidad">
            Insertar Disponibilidad</a></h4>
<table>
    <tr>
        <th>id Disponibilidad</th>
        <th>Disponibilidad</th>
    </tr>
    <?php foreach ($params['disponibilidades'] as $disponibilidad) :?>
        <tr>
            <td><a href="index.php?ctl=ver&id=<?php echo $disponibilidad['id_disponibilidad']?>">
            <?php echo $disponibilidad['id_disponibilidad'] ?></a></td>
            <td><?php echo $disponibilidad['disponibilidad']?></td>
            <td><a href="index.php?ctl=borrarDisponibilidad&idDisponibilidad=<?php echo $disponibilidad['id_disponibilidad']?>">Borrar</a></td>
        </tr>
    <?php endforeach; ?>

</table>


<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>
