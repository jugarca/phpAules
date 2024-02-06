<?php 
session_start();
include("../libs/bGeneral.php");
cabecera();

//1.1 No permitir la entrada si no esta logueado el usuario
if (!isset($_SESSION["nombre"])){
    header("location:pantallaInicioSesion.php");
}

$errores=[];
$idioma;

if (!isset($_REQUEST['bIdioma'])){
    include("../vistas/formularioCambioIdioma.php");
}else{
    $idioma = recoge("idioma");

    if($idioma==""){
        $errores['idioma'] = "Debe rellenar el campo";
    }

    if (empty($errores)){
        setcookie("idioma",$idioma);
        header("location:pantallaMenuPrincipal.php");
    }else{
        include("../vistas/formularioCambioIdioma.php");
    }
}


pie();

?>