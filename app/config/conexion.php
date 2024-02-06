<?php

//Datos de configuración a la BD. Posteriormente los sacaremos a un fichero de configuración config.php

$db_hostname = "localhost";
$db_nombre = "evaluable_7w";
/*
 * El usuario root núnca se puede usar, siempre cambiar por otro usuario
 * Nosotros lo usaremos para que nos funcionen a todos los ejemplos y los ejercicios
 */
$db_usuario = "root";
$db_clave = "";

//No capturamos la excepción porque lo haremos al incluirla


    // Conectamos
    $pdo = new PDO('mysql:host=' . $db_hostname . ';dbname=' . $db_nombre . '', $db_usuario, $db_clave);
    // Realiza el enlace con la BD en utf-8
    $pdo->exec("set names utf8");
    //Accionamos el uso de excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    


// Si todo va bien en $pdo tendremos el objeto que gestionará la conexión con la base de datos.

?>