<?php
//1. Se realizan los includes para importar los metodos. Se crea la cabecera y el pie.
include("../libs/bGeneral.php");
include("../config/config.php");

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
    $nombre = recoge("nombre");
    $email = recoge("email");
    $contrasenya = recoge("contrasenya");
    $fecha = recoge("fecha");
    $foto = $_FILES['foto'];
    $espanyol = recoge("espanyol");
    $ingles = recoge("ingles");
    $valenciano = recoge("valenciano");
    $descripcion = recoge("descripcion");
    //4.1 Se crean las validaciones

    cTexto($nombre, "nombre", $errores);

    cMail($email, "email", $errores);

    //Se valida si es una fecha correcta
    cValidateDate($fecha, 'fecha de nacimiento', $errores);

    //Se valida si es mayor de edad
    cMayorEdad($fecha,'fecha de nacimiento',$errores);

    if($contrasenya == ""){
        $errores['contrasenya'] = "Es obligatorio introducir contraseña";
    }

    //TODO: Falta generar el código dinamico y ver como recoger en un array??
    $espanyol = ($espanyol=="on")?"C":"";
    $ingles = ($ingles=="on")?"E":"";
    $valenciano = ($valenciano=="on")?"V":"";
    $idioma =  $ingles . $valenciano . $espanyol;

    //Como es la ultima validacion que se ejecuta, si no llegan errores guarda el fichero.
    cFile('foto', $errores,$formatosFoto, $dir,$maxFileSize); 

    

    //6. Si no hay errores se visualiza la pantalla principal y Si hay errores se recarga la pantalla
    if(empty($errores)){
        //Se lanza el guardado si no hay errores:
        //5. Si las validaciones han funcionado correctamente, se escribe en el fichero el numero usuario.
        $errorGuardado = false;
        $rutaCompleta = "../ficheros/usuarios.txt";
        if ($archivo = fopen($rutaCompleta, "a")) {
            $hoy = date("Y-m-d H:i:s");
            $imagen;
            if ($foto['name'] != ""){
            $imagen = $dirServidor."/".$foto['name'];
            }
            //Se compone el usuario que se va a guardar.
            $usuario = "$nombre;$email;$contrasenya;$fecha;$idioma;$imagen;$descripcion;$hoy".PHP_EOL;
            //Si falla al guardar se envia un error.
            if (!fwrite($archivo, $usuario)){
                $errores['guardado'] = "Problema al realizar el guardado.";
                include("../vistas/formularioRegistro.php");
                $errorGuardado = true;
            }
            fclose($archivo);
        }

        //Redirigimos a la pagina de inicio de sesión
        if (!$errorGuardado){
          header("location:pantallaInicioSesion.php");
        }
    } else{
        echo print_r($errores);
        include("../vistas/formularioRegistro.php");
    }

}

pie();

?>