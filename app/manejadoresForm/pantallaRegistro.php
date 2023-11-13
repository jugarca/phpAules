<?php
//1. Se realizan los includes para importar los metodos. Se crea la cabecera y el pie.
include("../libs/bGeneral.php");

cabecera("Formulario de Registro");

//2. Se crea el array de errores y tantas variables como se necesite validar.
$errores=[];
$nombre;
$email;
$contrasenya;
$fecha;
$foto;
$idioma;
$descripcion;

//3. Se comprueba si se entra por primera vez o se recarga el formulario con errores.

if(!isset($_REQUEST['bRegistro'])){
    include("../vistas/formularioRegistro.php");
} else{
    //4. Se procede a validar los datos del formulario.
    $nombre = recoge("nomre");
    $email = recoge("email");
    $contrasenya = recoge("contrasenya");
    $fecha = recoge("fecha");
    $foto = recoge("foto");
    $idioma = recoge("idioma");
    $descripcion = recoge("descripcion");
    //4.1 Se crean las validaciones
    if($nombre == ""){
        $errores['nombre'] = "El campo nombre es obligatorio";
    }

    if($email == ""){
        $errores['email'] = "El campo email es obligatorio";
    }

    if($contrasenya == ""){
        $errores['contrasenya'] = "Es obligatorio introducir contraseña";
    }
    //TODO VALIDAR LA FECHA
    /*if($fecha){

    }*/

    //TODO modificar el campo idioma para que sea un checkbox

    //TODO poner una validación del tamaño y tipo de fichero

    //5. Si no hay errores se visualiza la pantalla principal y Si hay errores se recarga la pantalla

    if(empty($errores)){
        //Redirigimos a la pagina de inicio de sesión
        header("location:pantallaInicioSesion.php");
    } else{
        include("../vistas/formularioRegistro.php");
    }




}

pie();

?>