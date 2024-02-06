<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Evaluable Servidor 7S</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>
<body>
<div id="cabecera">
<h1>Evaluable Servidor 7S</h1>
</div>

<!--<div id="menu">
<hr/>
<a href="index.php?ctl=inicio">Inicio</a> |
<a href="index.php?ctl=registrate">Regístrate</a> |
<a href="index.php?ctl=error">error</a> |
<a href="index.php?ctl=editarPerfil">Editar Perfil</a> |
<a href="index.php?ctl=listarIdioma">Listar Idiomas</a> |
<a href="index.php?ctl=listarDisponibilidad">Listar Disponibilidad</a> |
<a href="index.php?ctl=listarServicios">Listar Servicios</a> |
<a href="index.php?ctl=listarUsuarios">Listar Usuarios</a> |
<a href="index.php?ctl=paginaPrincipal">Pagina Principal</a> |
<a href="index.php?ctl=nuevoServicio">Nuevo Servicio</a> |
<a href="index.php?ctl=sendMail">Enviar Correo Prueba</a> |
<a href="index.php?ctl=cerrarSesion">Cerrar Sesion</a> |
<a href="index.php?ctl=listar">ver alimentos</a> |
<a href="index.php?ctl=insertar">insertar alimento</a> |
<a href="index.php?ctl=buscar">buscar por nombre</a> |
<a href="index.php?ctl=buscarAlimentosPorEnergia">buscar por energia</a> |
<a href="index.php?ctl=buscarAlimentosCombinada">búsqueda combinada</a>
<hr/>
</div>-->
<hr/>
    <?php	
        if (!isset($menu)) {
            $menu = 'menuInvitado.php';
        }
        include $menu;
    ?>
<hr/>

<div id="contenido">
<?php echo $contenido ?>
</div>

<div id="pie">
<hr/>
<div align="center">- pie de página -</div>
</div>
</body>
</html>
