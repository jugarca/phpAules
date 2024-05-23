<?php
session_start();
include('../libs/bGeneral.php');
/****
Esta página es pública, en esta parte no tenemos que comprobar si el usuario tiene sesion, esto se hace en la parte privada
***/

if(!isset($_SESSION["nombre"])){
    header("location: pantallaInicioSesion.php");
}
/****
Sino existe $_COOKIE no puedes asignarlo a una variable


    ****/

if(!isset($_COOKIE["idioma"])){
    $lang = $_COOKIE["idioma"];
}

cabecera("Menu Principal");

/*
    Esta es la página inicial, no tenemos nada en la variable de sesión
*/

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
