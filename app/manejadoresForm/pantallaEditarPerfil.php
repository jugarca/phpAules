<?php

//1. Se realizan los includes para importar los metodos. Se crea la cabecera y el pie.
include('../libs/bGeneral.php');
cabecera("Formulario Editar Perfil");

//2. Se crea el array de errores y tantas variables como se necesite validar.
$errores[];
$contrasenya;
$foto;
$idioma;
$descripcion;

//3. Se comprueba si se entra por primera vez o se recarga el formulario con errores.
if(!isset($_REQUEST['bGuardar'])){
    include('../vistas/formularioEditarPerfil.php');
} else{
    //4. Se procede a validar los datos del formulario.
    $contrasenya = recoge("contrasenya");
    $foto = recoge("foto");
    $idioma = recoge("idioma");
    $descripcion = recoge("descripcion");

     //4.1 Se crean las validaciones
     if($contrasenya == ""){
        $errores['contrasenya'] = "Es obligatorio introducir contraseña";
     }

     //TODO comprobar que el archivo que llega es un foto jpg o gift
     
     //TODO modificar campo idioma para que sea un checkbox

     //5. Si no hay errores se visualiza la pantalla principal y Si hay errores se recarga la pantalla
     if(empty($errores)){
        //redirigimos a la página de Menú principal
        header("location:pantallaMenuPrincipal.php");
     } else{
        include("../vistas/formularioEditarPerfil.php");
     }
}


pie();

?>