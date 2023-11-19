<?php
session_start();
include('../libs/bGeneral.php');

if(!isset($_SESSION["nombre"])){
    header("location: pantallaInicioSesion.php");
}

cabecera("Menu Principal");
echo("
<a href='pantallaAltaServicios.php'>Alta de Servicios</a>
<br>
<br>
<a href='pantallaEditarPerfil.php'>Editar perfil</a>
<br>
<br>
<a href=''>Busqueda de servicios</a>
<br>
<br>
<a href='pantallaInicioSesion.php'>Cerrar Sesión</a>
");

pie();

?>