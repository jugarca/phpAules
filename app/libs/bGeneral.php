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

function cTexto($text)
{
    if (preg_match("/^[A-Za-zÑñ]+$/", sinTildes($text)))
        return true;
    else
        return false;
}

function cNum($num)
{
    if (preg_match("/^[0-9]+$/", $num))
        return true;
    else
        return false;
}


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


function validateDate($fecha, $campo, &$errores){
	$valores = explode('/', $fecha);
	if(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])){
		return true;
    }
    $errores[$campo] = 'Es menor de edad, debe ser mayor de edad para registrarse';
	return false;
}

function cMail($correo){
	return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$correo);
}

function mayorEdad($fecha, $campo, &$errores){
    $anyo=date("Y")-date("Y", strtotime($fecha));


    if ($anyo>17){
        return true;
    }
    $errores[$campo] = 'Es menor de edad, debe ser mayor de edad para registrarse';
}
?>