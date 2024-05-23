<?php ob_start() ?>
<h1>Pagina Inicial Privada</h1>
<?php echo "Foto:".$_SESSION['foto'] ?>
<img src="logo2.jpg"  alt="">
<input type="image" src="logo2.jpg" name="foo" />
<table>
    <tr>
        <th>titulo</th>
        <th>descripcion</th>
        <th>tipo</th>
    </tr>
    <?php foreach($params['serviciosDisponibles'] as $servicio):?>
        <tr>
            <td>
             <a href="index.php?ctl=verServicio&idServicio=<?php echo $servicio['id_servicios']?>">
                <?php echo $servicio['titulo']?>
            </a>
            </td>
            <td><?php echo $servicio['descripcion']?></td>
            <td><?php echo $servicio['tipo']?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php $contenido = ob_get_clean() ?>
<?php include 'layout.php' ?>

