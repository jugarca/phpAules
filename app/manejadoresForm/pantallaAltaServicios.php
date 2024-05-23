<?php
session_start();
//1. Se realizan los includes para importar los metodos. Se crea la cabecera y el pie.
include("../libs/bGeneral.php");

cabecera("Formulario Alta Servicios");

//1.1 No permitir la entrada si no esta logueado el usuario
if (!isset($_SESSION["nombre"])){
    header("location:pantallaInicioSesion.php");
}

//2. Se crea el array de errores y tantas variables como se necesite validar.
$errores = [];
$titulo;
$categoria;
$categoriasPosibles = ["categoria1","categoria2","categoria3","categoria4"];
$descripcion;
$tipo;
$precio;
$ubicacion;
$disponibilidad;
$foto;

//3. Se comprueba si se entra por primera vez o se recarga el formulario con errores.
if(!isset($_REQUEST['bGuardar'])){
    include("../vistas/formularioAltaServicios.php");
}else{

    //4. Se procede a validar los datos del formulario.
    $titulo = recoge("titulo");
    $categoria = recoge("categoria");
    $descripcion = recoge("descripcion");
    $tipo = recoge("tipo");
    $precio = recoge("precio");
    $ubicacion = recoge("ubicacion");
    $disponibilidad = recoge("disponibilidad");
    $foto = recoge("foto");

    //4.1 Se crean las validaciones

    /***
    No les pasas a las funciones de validación los parámetros necesarios. Las mismas funciosnes
    comprueban si el campo es requerido y escriben en el array de errores
    Disponibilidad y categoría tenemos que validar que tiene un valor dentro de los previstos
    Falta la foto
    **/
        
    if($titulo == "" && ctexto($titulo)){
        $errores['titulo'] = "El campo título es obligatorio";
    }

    if($categoria == "" ){
        $errores['categoria'] = "Es necesario seleccionar una categoría";
    }

    if($descripcion == "" && ctexto($descripcion)){
        $errores['descripcion'] = "El campo descripción es obligatorio";
    }

    if($tipo == "" && ctexto($tipo)){
        $errores['tipo'] = "Es necesario seleccionar el tipo de servicio";
    }

    //TODO validación precio

    if($ubicacion == "" && ctexto($ubicacion)){
        $errores['ubicacion'] = "El campo ubicación es obligatorio";
    }

    if($disponibilidad == "" && ctexto($disponibilidad)){
        $errores['disponibilidad'] = "Es necesario seleccionar una opción de disponibilidad";
    }

     
    
    //6. Si no hay errores se visualiza la pantalla principal y Si hay errores se recarga la pantalla

    if(empty($errores)){
        //5. Si las validaciones han funcionado correctamente, se escribe en el fichero servicios.txt.
        $rutaCompleta = "../ficheros/servicios.txt";
        if($archivo = fopen($rutaCompleta, "a")){
            $hoy = date("Y-m-d H:i:s");
            $servicio = "$titulo;$categoria;$descripcion; $tipo;$precio;$ubicacion;$disponibilidad;$foto;$hoy" .PHP_EOL;
            if(fwrite($archivo,$servicio)){
                echo("Servicio guarado correctamente");
            } else{
                $errores['guardado'] = "Problema al realizar el guardado.";
            }
            fclose($archivo);
        }
        
        /**
        Los echo de arriba no se mostrarán porque hay un header location después
        ***/
        
        //redirigimos a la pantalla de Menú Pincipal
        header("location:pantallaMenuPrincipal.php");
    } else{
        include("../vistas/formularioAltaServicios.php");
    }

    
}

pie();
?>
