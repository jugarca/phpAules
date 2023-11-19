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
    $existeUsuario = false;


    //4.1 Se crean las validaciones
    if ($login == ""){
        $errores['login'] = 'Debe introducir un login correcto';
    }

    if ($pass == ""){
        $errores['pass'] = 'Debe introducir el password es obligatorio';
    }
    //TODO: Comprobar que la pareja login y password es correcta dentro de nuestra "Base de datos"
    //5. Se abre el fichero de usuarios en modo lectura.
    $rutaCompleta = "../ficheros/usuarios.txt";
    if($archivo = fopen($rutaCompleta, "r")){
        
        //5.1 Mientras exista una fila se recorre para comprobar que exista la combinación entre usu y pass
        while(!feof($archivo)) {
            //5.2 Se lee cada línea 
            $linea = fgets($archivo);
            //5.3 Cada linea la tenemos que trocear y comprobar el campo "1" y campo "3"
            //    Para ello se pasa con un explode a un array.
            $usuario = explode(";",$linea);
            if ($usuario[0] == $login && $usuario[2]==$pass){
                //Se pone la existencia de user a true
                $existeUsuario = true;
                //Como lo hemos encontrado se para el bucle.
                break;
            }
        }
        //Cuando se acabe la gestion se cierra el archivo
        fclose($archivo);
    }

    //5.4 añadimos los errores del user en funcion de si existe o no.
    if (!$existeUsuario){
        $errores['usuario'] = 'El usuario no existe en el fichero usuarios.txt';
    }



    //6. Si no hay errores se visualiza la pantalla principal y Si hay errores se recarga la pantalla
    if (empty($errores)){
        //Redirigimos a la pagina final
        header("location:pantallaMenuPrincipal.php");
    }else{
        include ('../vistas/formularioInicioSesion.php');
    }
}


pie();

?>