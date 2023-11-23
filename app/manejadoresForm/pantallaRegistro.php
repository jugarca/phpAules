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
/*
    Estos datos mejor en config.php
*/

$formatosFoto = ["jpg","png","gif"];
$dirServidor = "../ficheros/imagenes";
$dir = 'C:\xampp\htdocs\dwes2\app\ficheros\imagenes';
$maxFileSize = "51200000";

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
    /* 
        Los check mejor crearlos como array porque los manejas mejor. Además había que creaarlos dnamicamete en el form
    */
    $espanyol = recoge("espanyol");
    $ingles = recoge("ingles");
    $valenciano = recoge("valenciano");
    $descripcion = recoge("descripcion");
    //4.1 Se crean las validaciones
    if($nombre == ""){
        $errores['nombre'] = "El campo nombre es obligatorio";
    }

    if($email == ""){
        $errores['email'] = "El campo email es obligatorio";
    }

    cMail($email);

    mayorEdad($fecha,'fecha',$errores);

    if($contrasenya == ""){
        $errores['contrasenya'] = "Es obligatorio introducir contraseña";
    }
    //TODO VALIDAR LA FECHA
    /* 
    Esta llamada da error porque faltan parámetros en la llamada
    La propia función escribe en el array de errores
    */
    
    if(!validateDate($fecha)){
        $errores['fecha'] = "La fecha es obligatoria y debe cumplir el siguiente formato: DD/MM/YYYY.";
    }

    //TODO: Revisar los warnings que estan dando.
/***
    Subimos la foto sólo sino hay errores en el resto de los campos.
    Tenemos que almacenar el resultado de cFile para saber el nombre con el que se ha guardado la imagen
****/
        
    cFile('foto', $errores,$formatosFoto, $dir,$maxFileSize); 

    //Validamos los input del checkbox idioma

    $espanyol = ($espanyol=="on")?"C":"";
    $ingles = ($ingles=="on")?"E":"";
    $valenciano = ($valenciano=="on")?"V":"";
    $idioma =  $ingles . $valenciano . $espanyol;

    //5. Si las validaciones han funcionado correctamente, se escribe en el fichero el numero usuario.
    $rutaCompleta = "../ficheros/usuarios.txt";
    if ($archivo = fopen($rutaCompleta, "a")) {
        $hoy = date("Y-m-d H:i:s");
        $imagen;
        /****
        Puede haber un error con la imagen, tamaño demasiado grande, extensiones, ...
        ****/
        if ($foto['name'] != ""){
           $imagen = $dirServidor."/".$foto['name'];
        }
        //TODO: ¿En la foto guardamos la ruta.?
        $usuario = "$nombre;$email;$contrasenya;$fecha;$idioma;$imagen;$descripcion;$hoy".PHP_EOL;
        if (fwrite($archivo, $usuario)){
/****
            Si luego vas a hacer un header location este echo no se mostrará
***/
            
            echo "Usuario Guardado correctamente.";
        }else{
            $errores['guardado'] = "Problema al realizar el guardado.";
        }
        fclose($archivo);
    }

    //6. Si no hay errores se visualiza la pantalla principal y Si hay errores se recarga la pantalla

    if(empty($errores)){
        //Redirigimos a la pagina de inicio de sesión
        /*** 
            Los echo antes de un header no se muestran
        ****/
            
        echo "Sin errores.";
        header("location:pantallaInicioSesion.php");
    } else{
        echo print_r($errores);
        include("../vistas/formularioRegistro.php");
    }

}

pie();

?>
