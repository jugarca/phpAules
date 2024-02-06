<?php ob_start() ?>

<h1><?php $params['titulo'] ?> </h1>
<h4><a href="index.php?ctl=insertarIdioma">
            Insertar Idioma</a></h4>

<table>
    <tr>
        <th>id Idioma</th>
        <th>Nombre</th>
    </tr>
    <?php foreach ($params['idiomas'] as $idioma) :?>
        <tr>
            <td><a href="index.php?ctl=ver&id=<?php echo $idioma['id_idioma']?>">
            <?php echo $idioma['id_idioma'] ?></a></td>
            <td><?php echo $idioma['idioma']?></td>
            <td><a href="index.php?ctl=borrarIdioma&idIdioma=<?php echo $idioma['id_idioma']?>">Borrar</a></td>
        </tr>
    <?php endforeach; ?>

</table>


<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>
