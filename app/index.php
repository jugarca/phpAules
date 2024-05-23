<?php
// web/index.php
// carga del modelo y los controladores
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/libs/bGeneral.php';
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/model/Modelo.php';
require_once __DIR__ . '/model/Usuarios.php';
require_once __DIR__ . '/model/Idioma.php';
require_once __DIR__ . '/model/Disponibilidad.php';
require_once __DIR__ . '/model/Servicios.php';
require_once __DIR__ . '/model/Tokens.php';
require_once __DIR__ . '/model/UserIdioma.php';
require_once __DIR__ . '/controlador/Controller.php';

session_start(); // Se inicia la sesion

/*
Si tenemos que usar sesiones podemos poner aqui el inicio de sesión, de manera que si el usuario todavia no está logueado
lo identificamos como visitante, por ejemplo de la siguiente manera: $_SESSION['nivel_usuario']=0
*/

if (!isset($_SESSION['nivel'])) {
    $_SESSION['nivel'] = 0;
}

// enrutamiento
$map = array(
    /*
    En cada elemento podemos añadir una posición mas que se encargará de otorgar el nivel mínimo para ejecutar la acción
    Puede quedar de la siguiente manera
    'inicio' => array('controller' =>'Controller', 'action' =>'inicio', 'nivel_usuario'=>0)
    */
    'inicio' => array('controller' =>'Controller', 'action' =>'inicio','nivel'=>0),
    'login' => array('controller' =>'Controller', 'action' =>'login','nivel'=>0),
    'logueate' => array('controller' =>'Controller', 'action' =>'logueate','nivel'=>0),
    'cerrarSesion' => array('controller' =>'Controller', 'action' =>'cerrarSesion','nivel'=>1),
    'registrate' => array('controller' =>'Controller', 'action' =>'registrate','nivel'=>0),
    'confirmarCuenta' => array('controller' =>'Controller', 'action' =>'confirmarCuenta','nivel'=>0),
    'editarPerfil' => array('controller' =>'Controller', 'action' =>'editarPerfil','nivel'=>1),
    'paginaPrincipal' => array('controller' =>'Controller', 'action' =>'paginaPrincipal','nivel'=>1),
	'error' => array('controller' =>'Controller', 'action' =>'error','nivel'=>0),
	'listarIdioma' => array('controller' =>'Controller', 'action' =>'listarIdioma','nivel'=>2),
    'borrarIdioma' => array('controller' =>'Controller', 'action' =>'borrarIdioma','nivel'=>2),
	'insertarIdioma' => array('controller' =>'Controller', 'action' =>'insertarIdioma','nivel'=>2),
    'listarDisponibilidad' => array('controller' =>'Controller', 'action' =>'listarDisponibilidad','nivel'=>2),
    'borrarDisponibilidad' => array('controller' =>'Controller', 'action' =>'borrarDisponibilidad','nivel'=>2),
    'insertarDisponibilidad' => array('controller' =>'Controller', 'action' =>'insertarDisponibilidad','nivel'=>2),
    'listarServicios' => array('controller' => 'Controller', 'action' =>'listarServicios','nivel'=>1),
    'verServicio' => array('controller' => 'Controller', 'action' =>'verServicio','nivel'=>1),
    'nuevoServicio' => array('controller' => 'Controller', 'action' =>'nuevoServicio','nivel'=>1),
    'solicitoServicio' => array('controller' => 'Controller', 'action' =>'solicitoServicio','nivel'=>1),
    'guardarServicio' => array('controller' => 'Controller', 'action' =>'guardarServicio','nivel'=>1),
    'listarUsuarios' => array('controller' => 'Controller', 'action'=> 'listarUsuarios','nivel'=>2),
    'sendMail' => array('controller' => 'Controller', 'action'=> 'sendMail'),
    /*'listar' => array('controller' =>'Controller', 'action' =>'listar'),
    'insertar' => array('controller' =>'Controller', 'action' =>'insertar'),
    'buscar' => array('controller' =>'Controller', 'action' =>'buscarPorNombre'),
    'ver' => array('controller' =>'Controller', 'action' =>'ver'),
    'error' => array('controller' =>'Controller', 'action' =>'error')*/
);
// Parseo de la ruta
if (isset($_GET['ctl'])) {
    if (isset($map[$_GET['ctl']])) {
        $ruta = $_GET['ctl'];
    } else {

        //Si el valor puesto en ctl en la URL no existe en el array de mapeo envía una cabecera de error
        header('Status: 404 Not Found');
        echo '<html><body><h1>Error 404: No existe la ruta <i>' .
            $_GET['ctl'] .'</p></body></html>';
            exit;
    }
} else {
    $ruta = 'inicio';
}
$controlador = $map[$ruta];
/* 
Comprobamos si el metodo correspondiente a la acción relacionada con el valor de ctl existe, si es así ejecutamos el método correspondiente.
En aso de no existir cabecera de error.
En caso de estar utilizando sesiones y permisos en las diferentes acciones comprobariaos tambien si el usuario tiene permiso suficiente para ejecutar esa acción
*/

if (method_exists($controlador['controller'],$controlador['action'])) {
    if ($controlador['nivel'] <= $_SESSION['nivel']) {
        call_user_func(array(
            new $controlador['controller'],
            $controlador['action']
        ));
    }else{
        call_user_func(array(
            new $controlador['controller'],
            'inicio'
        )); 
    }
} else {
    header('Status: 404 Not Found');
    echo '<html><body><h1>Error 404: El controlador <i>' .
        $controlador['controller'] .
        '->' .
        $controlador['action'] .
        '</i> no existe</h1></body></html>';
}
?>