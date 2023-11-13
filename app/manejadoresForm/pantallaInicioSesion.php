<?php

//1. Se realizan los includes para importar los metodos. Se crea la cabecera y el pie.
include ('../libs/bGeneral.php');
cabecera("Formulario Sesion");

//2. Se crea el array de errores y tantas variables como se necesite validar.
$errores=[];
$login;
$pass;

//3. Se comprueba si se entra por primera vez o se recarga el formulario con errores.
if (!isset($_REQUEST['bInicio'])) {
    include ('../vistas/formularioInicioSesion.php');
} else {
    //4. Se procede a validar los datos del formulario.
    $login = recoge("login");
    $pass = recoge("pass");


    //4.1 Se crean las validaciones
    if ($login == ""){
        $errores['login'] = 'Debe introducir un login correcto';
    }

    if ($pass == ""){
        $errores['pass'] = 'Debe introducir el password es obligatorio';
    }
    //TODO: Comprobar que la pareja login y password es correcta dentro de nuestra "Base de datos"

    //5. Si no hay errores se visualiza la pantalla principal y Si hay errores se recarga la pantalla
    if (empty($errores)){
        //Redirigimos a la pagina final
        header("location:pantallaMenuPrincipal.php");
    }else{
        include ('../vistas/formularioInicioSesion.php');
    }
}


pie();

?>