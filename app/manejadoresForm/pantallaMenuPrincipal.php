<?php
session_start();
include('../libs/bGeneral.php');

if(!isset($_SESSION["nombre"])){
    header("location: pantallaInicioSesion.php");
}

if(!isset($_COOKIE["idioma"])){
    $lang = $_COOKIE["idioma"];
}

cabecera("Menu Principal");

$foto = $_SESSION['foto'];
echo($_COOKIE["idioma"]);
echo ("<img src='".$foto."'> <br>");
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