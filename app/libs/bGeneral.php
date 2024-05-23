<?php

function cabecera($titulo =NULL) // el archivo actual
{
    if (is_null($titulo)) {
        $titulo = basename(__FILE__);
    }
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>
				<?php
    echo $titulo;
    ?>
			
			</title>
<meta charset="utf-8" />

<style>
        body {
            background-color: <?php echo $colorFondo; ?>;
        }
    </style>
</head>
<body>
<?php
}

function pie()
{
    echo "</body>
	</html>";
}

function sinTildes($frase)
{
    $no_permitidas = array(
        "á",
        "é",
        "í",
        "ó",
        "ú",
        "Á",
        "É",
        "Í",
        "Ó",
        "Ú",
        "à",
        "è",
        "ì",
        "ò",
        "ù",
        "À",
        "È",
        "Ì",
        "Ò",
        "Ù"
    );
    $permitidas = array(
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U",
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U"
    );
    $texto = str_replace($no_permitidas, $permitidas, $frase);
    return $texto;
}

function sinEspacios($frase)
{
    $texto = trim(preg_replace('/ +/', ' ', $frase));
    return $texto;
}

function recoge($var)
{
    if (isset($_REQUEST[$var])){
        $tmp=sinEspacios($_REQUEST[$var]);
        $tmp = strip_tags($tmp);}
    else
        $tmp = "";

    return $tmp;
}

/**
 * funcion que valida si son campo de tipo Texto.
 */
function cTexto($text, $campo, &$errores,$requerido=TRUE)
{
    if($requerido && $text == ""){
        $errores[$campo] = "El campo es obligatorio";
        return false;
    }
    if (preg_match("/^[A-Za-zÑñ ]+$/", sinTildes($text))){
        return true;
    } else{
        $errores[$campo] = 'El campo de texto es incorrecto.';
        return false;
    }
}

/**
 * Función que valida que un campo sea de tipo texto y requerido.
 */
function cNum($num, $campo,&$errores,$requerido=TRUE)
{
    if($requerido && $num == ""){
        $errores[$campo] = "El campo es obligatorio";
        return false;
    }
    if (preg_match("/^[0-9]+$/", $num)){
        return true;
    }
    else{
        $errores[$campo] = "No es un campo numerico";
        return false;
    }
        
}


/**
 * Funcion que valida los ficheros.
 */
function cFile(string $nombre, array &$errores, array $extensionesValidas, string $directorio, int  $max_file_size,  bool $required = TRUE)
{
    
    if ((!$required) && $_FILES[$nombre]['error'] === 4)
        return true;
    
    if ($_FILES[$nombre]['error'] != 0) {
        $errores["$nombre"] = "Error al subir el archivo " . $nombre . ". Prueba de nuevo";
        return false;
    } else {

        $nombreArchivo = strip_tags($_FILES["$nombre"]['name']);
       
        $directorioTemp = $_FILES["$nombre"]['tmp_name'];
        
        $tamanyoFile = filesize($directorioTemp);
        
        
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));


        if (!in_array($extension, $extensionesValidas)) {
            $errores["$nombre"] = "La extensión del archivo no es válida esta enviando $extension ";
            return false;
        }
       
        if ($tamanyoFile > $max_file_size) {
            $errores["$nombre"] = "La imagen debe de tener un tamaño inferior a $max_file_size kb";
            return false;
        }


        if (empty($errores)) {
         
            if (is_dir($directorio)) {
             
                $nombreArchivo = is_file($directorio . DIRECTORY_SEPARATOR . $nombreArchivo) ? time() . $nombreArchivo : $nombreArchivo;
                $nombreCompleto = $directorio . DIRECTORY_SEPARATOR . $nombreArchivo;
               
                if (move_uploaded_file($directorioTemp, $nombreCompleto)) {
                   
                    return $nombreCompleto;
                } else {
                    $errores["$nombre"] = "Ha habido un error al subir el fichero";
                    return false;
                }
            }else {
                $errores["$nombre"] = "Ha habido un error al subir el fichero";
                return false;
            }
        }
    }
}


/**
 * Función para validar el formato de fecha.
 */
function cValidateDate($fecha, $campo, &$errores, bool $requerido=TRUE){
    
    if (($requerido) && $fecha == ""){
        $errores[$campo] = "El campo es obligatorio";
        return false;
    }
	$valores = explode('/', $fecha);
	if(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])){
		return true;
    }
    $errores[$campo] = 'Es menor de edad, debe ser mayor de edad para registrarse';
	return false;
}

/**
 * Función para comprobar que el campo email es valido.
 */
function cMail($correo, $campo, &$errore,$requerido=TRUE){
    if($requerido && $correo == ""){
        $errores[$campo] = "El campo es obligatorio";
        return false;
    }
    if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$correo)){
	   return true;
    }else{
       $errores[$campo] = 'Es menor de edad, debe ser mayor de edad para registrarse';
       return false;
    }
}

/**
 * Función para comprobar si una persona es mayor de edad o no.
 * Es muy básica solo lo realiza con el año.
 */
function cMayorEdad($fecha, $campo, &$errores){
    $anyo=date("Y")-date("Y", strtotime($fecha));

    if ($anyo>17){
        return true;
    }
    $errores[$campo] = 'Es menor de edad, debe ser mayor de edad para registrarse';
    return false;
}

/**
 * Función para comprobar si esta rellena la contrasenya.
 */
function cContrasenya($contrasenya, $campo, &$errores){

    if($contrasenya == ""){
        $errores['contrasenya'] = "Es obligatorio introducir contraseña";
        return false;
    }
    return true;
}

/**
 * Funcion para recoger un array de valores.
 */
function recogeArray(string $var):array
{
    $array=[];
    if (isset($_REQUEST[$var])&&(is_array($_REQUEST[$var]))){
        foreach($_REQUEST[$var] as $valor)
        $array[]=strip_tags(sinEspacios($valor));
        
    }
    
    return $array;
}

/**
 * Funcion que valida el valor de un checkbox es uno de los creados.
 */
function cCheck (array $text, string $campo, array &$errores, array $valores, bool $requerido=TRUE)
{
   
    if (($requerido) && (count($text)==0)){
        $errores[$campo] = "Error en el campo $campo";
        return false;
    }
    foreach ($text as $valor){
        if (!in_array($valor, $valores)){
            $errores[$campo] = "Error en el campo $campo";
            return false;
        }
        
    }
    return true;
}

/**
 * Funcion para validar el tipo select.
 */
function cSelect (string $text, string $campo, array &$errores, array $valores, bool $requerido=TRUE)
{
   
    if (($requerido) && (count($text)==0)){
        $errores[$campo] = "Error en el campo $campo";
        return false;
        }

    if (!in_array($text, $valores)){
        $errores[$campo] = "Error en el campo $campo";
        return false;
    }
        
    return true;
}

//TODO: no he revisado la funcion de creación dinamica de html.

?>