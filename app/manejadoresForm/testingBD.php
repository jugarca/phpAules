<?php
//1. Se realizan los includes para importar los metodos. Se crea la cabecera y el pie.
include("../libs/bGeneral.php");
include("../config/config.php");
include("../config/conexion.php");

cabecera("Formulario de Registro");

echo("Prueba de Base de datos");

try {
$consulta = "SELECT * FROM idioma";
    if($resultado = $pdo->query($consulta)){
        foreach ($resultado as $row) {
            echo "<br> ";
            echo $row['id_idioma'] . "<br> ";
            echo $row['idioma'] . "<br>";
        }
    }

} catch (PDOException $e) {
    
    // En este caso guardamos los errores en un archivo de errores log
    error_log($e->getMessage() . "##Código: " . $e->getCode()."  ".  microtime() . PHP_EOL, 3, "../logBD.txt");
    // guardamos en ·errores el error que queremos mostrar a los usuarios
    $errores['datos'] = "Ha habido un error <br>";
   
    
} 

//2. Se crea el array de errores y tantas variables como se necesite validar.


pie();

?>