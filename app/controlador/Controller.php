<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Controller
{

    //Método que se encarga de cargar el menu que corresponda según el tipo de usuario
    private function cargaMenu(){
        if ($_SESSION['nivel'] == 1) {
            return 'menuUser.php';
        } else if ($_SESSION['nivel'] == 2) {
            return 'menuAdmin.php';
        }else{
            return 'menuInvitado.php';
        }
    }

    public function inicio(){

        $params = array(
            'mensaje' => 'Bienvenido al Entregable de Entorno Servidor',
            'fecha' => date('d-m-y')
        );

        $serviciosModel = new Servicios;

        $params = array(
            'serviciosInicio' => $serviciosModel->listar3Servicios(),
        );

        //Si no esta logueado se pone el nivel a cero.
        if (!isset($_SESSION['idUser'])){
            $_SESSION['nivel'] = 0;
        }
        
        $menu = $this->cargaMenu();
        require __DIR__.'/../templates/inicio.php';
    }

    public function cerrarSesion(){
        session_destroy();

        header("location:index.php?ctl=inicio");
    }

    /* Metodos relacionados con Usuarios */
    public function registrate(){

        //TODO: Sacar las variables a fichero de config
        $formatosFoto = ["jpg","png","gif"];
        $dirServidor = "../ficheros/imagenes";
        $dir = 'C:\xampp\htdocs\dwes2\app\ficheros\imagenes';
        $maxFileSize = "51200000";

        $errores=[];
        if (isset($_POST['registrate'])) {
            
            //1. Se recogen los datos del formulario.
            $nombre = recoge("nombre");
            $email = recoge("email");
            $contrasenya = recoge("contrasenya");
            $fecha = recoge("fecha");
            $foto = $_FILES['foto'];
            $espanyol = recoge("espanyol");
            $ingles = recoge("ingles");
            $valenciano = recoge("valenciano");
            $descripcion = recoge("descripcion");

            //2. Se validan los datos.
            cTexto($nombre, "nombre", $errores);

            cMail($email, "email", $errores);

            cValidateDate($fecha, 'fecha de nacimiento', $errores);

            cMayorEdad($fecha,'fecha de nacimiento',$errores);

            cContrasenya($contrasenya,'contrasenya',$errores);

            cTexto($descripcion, "descripcion", $errores, false);

            //TODO: Falta generar el código dinamico y ver como recoger en un array??
            $espanyol = ($espanyol=="on")?"C":"";
            $ingles = ($ingles=="on")?"E":"";
            $valenciano = ($valenciano=="on")?"V":"";
            $idioma =  $ingles . $valenciano . $espanyol;

            //Como es la ultima validacion que se ejecuta, si no llegan errores guarda el fichero.
            cFile('foto', $errores,$formatosFoto, $dir,$maxFileSize,false); 

            //TODO: Si todo va bien insertamos y volvemos a la pantalla de inicio (login)
            //6. Si no hay errores se visualiza la pantalla principal y Si hay errores se recarga la pantalla
            if(empty($errores)){

                $usuarioModel = new Usuarios; 
                //Se crea activo Activo a 0 y mandar el correo.
                $resultado = $usuarioModel->insertarUsuario($nombre, $email, $contrasenya, $fecha, $foto, $descripcion, 1, 0);
                
                //TODO: Insertar en la tabla de idiomas - usuario.

                //Insertar en la tabla de token
                $tokenGenerado = bin2hex(openssl_random_pseudo_bytes(16));
                $validez = time()+(3600*24);
                $usuarioMax = $usuarioModel->maxUser(); 
                $tokenModel = new Tokens;

                $resultadoInsertToken = $tokenModel->insertarTokens($tokenGenerado,$validez,$usuarioMax);

                //Llamar al metodo de envio de correos.
                $enlaceCorreo = "http://localhost/dwes2/app/index.php?ctl=confirmarCuenta&token=".$tokenGenerado;
                $textoCorreo = "Tienes 24 horas para confirmar la cuenta con el siguiente enlace: ".$enlaceCorreo ;
                $this->sendMail("Registro en la APP", $email, $nombre, $textoCorreo);

                //Cargar los servicios de la pagina de inicio
                $serviciosModel = new Servicios;

                $params = array(
                    'serviciosInicio' => $serviciosModel->listar3Servicios(),
                );

                $menu = $this->cargaMenu();
                require __DIR__ . '/../templates/inicio.php';
            }else{
                error_log('Si hay errores' . PHP_EOL, 3, "logError.txt");
                $params['error'] = 'Hay datos que no son correctos. Revisa el formulario';
                $params['errorDetalle'] = implode(', ', $errores);
                
            }
        }

        //TODO: Cuando todo va bien sale 2 veces.
        $menu = $this->cargaMenu();
        require __DIR__ . '/../templates/registro.php';
        
    }

    public function confirmarCuenta(){
        if(isset($_GET['token'])){
            try{
                //Se recupera el usuario a partir del token
                $tokenModel = new Tokens;
                $userId = $tokenModel -> recuperaUser($_GET['token']);
                //cambiar action del usuario a activo=1
                $usuarioModel = new Usuarios;
                $resultado = $usuarioModel ->activarUsuario($userId);

                // eliminar fila de la tabla Tokens
                $resultadoBorrado = $tokenModel->deleteToken($_GET['token']);

                //redirigir a inicio para poder loguear
                $serviciosModel = new Servicios;

                $params = array(
                    'serviciosInicio' => $serviciosModel->listar3Servicios(),
                );

                $menu = $this->cargaMenu();
                require __DIR__ . '/../templates/inicio.php';

            } catch (Exception $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
                $params = array(
                    'error' => $e->getMessage()
                );
                header('Location: index.php?ctl=error');
            } catch (Error $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
                $params = array(
                    'error' => $e->getMessage()
                );
                header('Location: index.php?ctl=error');
            }
            
        }else{
            $menu = $this->cargaMenu();
            require __DIR__ . '/../templates/tokenIncorrecto.php';
        }
        
    }

    public function logueate(){

        require __DIR__.'/../templates/logueate.php';
    }

    public function login()
    {
        if (isset($_POST['bInicio'])) {
            //1. Recoger las variables
            $login = recoge("login");
            $pass = recoge("pass");

            //2. Llamar metodo de comprobar usuarios del Usuarios.php
            $usuarioModel = new Usuarios;

            $resultado = $usuarioModel -> comprobarUsuario($login,$pass);

            if($resultado){

                $usuarioLogueado = $usuarioModel->mostrarUsuario($login);

                //Meter variables de session
                $_SESSION['idUser'] = $usuarioLogueado['id_user'];
                $_SESSION['nombreUsuario'] = $usuarioLogueado['nombre'];
                $_SESSION['nivel'] = $usuarioLogueado['nivel'];
                $_SESSION['foto'] = "/../ficheros/imagenes/".$usuarioLogueado['foto_perfil'];

                //Si vamos a la pagina principal cargamos el parametros de la lista de servicios disponibles.
                $m = new Servicios();
                $params = array(
                    'serviciosDisponibles' => $m->listarServiciosDisponibles($usuarioLogueado['id_user']),
                );

                $menu = $this->cargaMenu();
                require __DIR__.'/../templates/paginaPrincipal.php';
            }else{
                $menu = $this->cargaMenu();
                require __DIR__.'/../templates/inicio.php';
            }

        }else{
            $menu = $this->cargaMenu();
            require __DIR__.'/../templates/inicio.php';
        }

    }

    public function listarUsuarios(){
        try {
            $m = new Usuarios();
            $params = array(
                'usuarios' => $m->listarUsuarios(),
            );

            // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        }
        $menu = $this->cargaMenu();
        require __DIR__ . '/../templates/mostrarUsuarios.php';
    }

    

    public function EditarPerfil(){

        //TODO: Tiene que guardar en caso de que venga del formulario, si valida 
        //y guarda correctamente se vuelve a la pagina principal y si no se queda en la de editar Perfil
        if(isset($_POST['bGuardar'])){

            //Recoger campos
            $errores=[];
            $contrasenya = recoge("contrasenya");
            $foto = recoge("foto");
            $idioma = recoge("idioma");
            $descripcion = recoge("descripcion");

            $formatosFoto = ["jpg","png","gif"];
            $dirServidor = "../ficheros/imagenes/servicios";
            $dir = 'C:\xampp\htdocs\dwes2\app\ficheros\imagenes\servicios';
            $maxFileSize = "51200000";
            //Validar los campos
            cContrasenya($contrasenya, 'contrasenya', $errores);
            cTexto($descripcion, 'descripcion', $errores);
            cFile('foto', $errores, $formatosFoto, $dir, $maxFileSize);


            //Si no hay errores Llamar a un metodo de BD que haga el update en esos 4 campos y volver a la pantallaPrincipal
            if(empty($errores)){
                $usuariosModel = new Usuarios;

                $resultado = $usuariosModel->modificarUsuario($_SESSION['idUser'], $contrasenya, $foto, $descripcion);

                //TODO: Guardar los idiomas del usuario.

                //Como vuelvo a la pantalla Principal que hace el listado de los servicios Disponibles, se los tenemos que pasar
                $m = new Servicios();
                $params = array(
                    'serviciosDisponibles' => $m->listarServiciosDisponibles($_SESSION['idUser']),
                );


                $menu = $this->cargaMenu();
                require __DIR__ .'/../templates/paginaPrincipal.php';

            } else{
                //Si hay errores recargar la pagina con los errores.
                $params['error'] = implode(', ', $errores);
                require __DIR__ . '/../templates/editarPerfil.php';
            }
            

        }else{
            $menu = $this->cargaMenu();
            require __DIR__ . '/../templates/editarPerfil.php';
        }

        
    }

    /* End Metodos relacionados con Usuarios */

    /* Metodos relacionados con Servicios */

    public function verServicio(){
        try {
            if (!isset($_GET['idServicio'])) {
                $params['error'] = 'No hay Servicio con este id.';
            }

            $idServicio = recoge('idServicio');

            $servicioModel = new Servicios();
            $params['servicio'] = $servicioModel->mostrarServicio($idServicio);
            if (!$params['servicio']) {
                $params['error'] = 'No hay servicios que mostrar.';
            }

        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }

        $menu = $this->cargaMenu();
        require __DIR__.'/../templates/verServicio.php';
    }

    public function nuevoServicio(){
        $menu = $this->cargaMenu();
        require __DIR__.'/../templates/nuevoServicio.php';
    }

    public function guardarServicio(){
        
        //1. Se crea el array de errores y tantas variables como se necesite validar.
        $errores = [];
        $titulo;
        $categoria;
        $categoriasPosibles = ["categoria1","categoria2","categoria3","categoria4"];
        $descripcion;
        $tipo;
        $tiposPosibles = ["1","2"];
        $precio;
        $ubicacion;
        $disponibilidad;
        $disponibilidadPosibles = ["manyana","tarde","noche","completa","finSemana"];
        $foto;

        if (isset($_POST['bGuardar'])) {

            //2. Recoger Variables
            $titulo = recoge("titulo");
            $categoria = recoge("categoria");
            $descripcion = recoge("descripcion");
            $tipo = recoge("tipo");
            $precio = recoge("precio");
            $ubicacion = recoge("ubicacion");
            $disponibilidad = recoge("disponibilidad");
            $foto = recoge("foto");

            $formatosFoto = ["jpg","png","gif"];
            $dirServidor = "../ficheros/imagenes/servicios";
            $dir = 'C:\xampp\htdocs\dwes2\app\ficheros\imagenes\servicios';
            $maxFileSize = "51200000";

            //3. Validar Variables
            cTexto($titulo, "titulo", $errores);

            //cSelect($categoria, "categoria", $errores, $categoriasPosibles);

            cTexto($descripcion, "descripcion", $errores);

            //cSelect($tipo, "tipo", $errores, $tiposPosibles);

            cNum($precio, "precio", $errores);

            cTexto($ubicacion, "ubicacion", $errores);

            //cSelect($disponibilidad, "disponibilidad", $errores, $disponibilidadPosibles);

            cFile('foto', $errores,$formatosFoto, $dir,$maxFileSize); 

            //4. Si todo va bien
            if(empty($errores)){
                $serviciosModel = new Servicios;

                $resultado = $serviciosModel->insertarServicio($titulo, $_SESSION['idUser'], $descripcion, $precio, $tipo, $foto);

                $m = new Servicios();
                $params = array(
                    'serviciosDisponibles' => $m->listarServiciosDisponibles($_SESSION['idUser']),
                );

                $menu = $this->cargaMenu();
                require __DIR__.'/../templates/paginaPrincipal.php';

            }else{

                $menu = $this->cargaMenu();
                $params['error'] = 'Error al insertar el servicio.'.print_r($errores);
                require __DIR__.'/../templates/nuevoServicio.php';
            }

            

        }else{
            $menu = $this->cargaMenu();
            require __DIR__.'/../templates/nuevoServicio.php';
        }
    }

    public function listarServicios(){
        try {
            $m = new Servicios();
            $params = array(
                'servicios' => $m->listarServicios(),
            );

            // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        }
        $menu = $this->cargaMenu();
        require __DIR__ . '/../templates/mostrarServicios.php';
    }

    public function solicitoServicio(){
        //Solicito Servicio 
    }

    /* End Metodos relacionados con Servicios */
        
	
	public function error(){
        $params = array(
            'error' => 'Este es un error de ejemplo',
        );
      
        $menu = $this->cargaMenu();
        require __DIR__.'/../templates/error.php';
    }

    /* Metodos relacionados con Idiomas */

    public function listarIdioma()
    {
        try {
            $m = new Idioma();
            $params = array(
                'idiomas' => $m->listarIdiomas(),
                'titulo' => 'pantalla de idioma'
            );

        // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        }
        $menu = $this->cargaMenu();
        require __DIR__ . '/../templates/mostrarIdiomas.php';
    }

    public function borrarIdioma(){
        try {

            $idiomaModel = new Idioma;

            if (isset($_GET['idIdioma'])) {
                $resultado = $idiomaModel->borrarIdioma($_GET['idIdioma']);
            }

            $params = array (
                'idiomas' => $idiomaModel -> listarIdiomas(),
                'titulo' => "Mostrar Idiomas"
            );

            $menu = $this->cargaMenu();
            require __DIR__ . '/../templates/mostrarIdiomas.php';
            
        // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        }
    }

    public function insertarIdioma(){
        try {
            if (isset($_POST['bGuardar'])){

                //recoger los campos y crear el array de errores
                $errores = [];
                $idioma = recoge('idioma');

                //validar los campos
                cTexto($idioma, 'idioma', $errores);

                //si no hay errores insertar y mostrar los idiomas
                if(empty($errores)){

                    $idiomaModel = new Idioma;
                    $resultado = $idiomaModel -> insertarIdioma($idioma);

                    $params = array(
                        'idiomas' => $idiomaModel->listarIdiomas(),
                        'titulo' => 'Mostrar idiomas.'
                    );

                    $menu = $this->cargaMenu();
                    require __DIR__ . '/../templates/mostrarIdiomas.php';
                }

            } else {
                $menu = $this->cargaMenu();
                require __DIR__ . '/../templates/insertarIdioma.php';
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        }
    }
    /* End Metodos relacionados con Idiomas */

    /* Metodos relacionados con Disponibilidades */
    public function listarDisponibilidad(){
        try {
            $m = new Disponibilidad();
            $params = array(
                'disponibilidades' => $m->listarDisponibilidad(),
                'titulo' => 'pantalla de disponibilidad'
            );

            // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        }
        $menu = $this->cargaMenu();
        require __DIR__ . '/../templates/mostrarDisponibilidades.php';
    }

    public function borrarDisponibilidad()
    {
        try {
            $disponibilidadModel = new Disponibilidad();

            if (isset($_GET['idDisponibilidad'])) {
                $resultado = $disponibilidadModel->borrarDisponibilidad($_GET['idDisponibilidad']);
            }

            $params = array(
                'disponibilidades' => $disponibilidadModel->listarDisponibilidad(),
                'titulo' => 'pantalla de disponibilidad'
            );

            $menu = $this->cargaMenu();
            require __DIR__ . '/../templates/mostrarDisponibilidades.php';

            // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        }
    }

    public function insertarDisponibilidad() {
        try {

            if(isset($_POST['bGuardar'])){

                //1. Recoger el/los campos de pantalla crear array errores
                $errores = [];
                $disponibilidad = recoge("disponibilidad");

                //2. Validar los campos
                cTexto($disponibilidad, "disponibilidad", $errores);

                //3. Si no hay errores, insertar y mostrar las disponibilidades 
                if(empty($errores)){
    
                    $disponibilidadModel = new Disponibilidad;
                    $resultado = $disponibilidadModel->insertarDisponibilidad($disponibilidad);

                    $params = array(
                        'disponibilidades' => $disponibilidadModel->listarDisponibilidad(),
                        'titulo' => 'Mostrar Disponibildades.'
                    );
                    
                    $menu = $this->cargaMenu();
                    require __DIR__ . '/../templates/mostrarDisponibilidades.php';
                } else{

                    //4. Si hay error recargar el formulario de insertar disponibilidad

                    $params['error'] = implode(', ', $errores);

                    $menu = $this->cargaMenu();
                    require __DIR__ . '/../templates/insertarDisponibilidad.php';
                }

            } else{
                $menu = $this->cargaMenu();
                require __DIR__ . '/../templates/insertarDisponibilidad.php';  
            }

            // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        }
    }

    /* Metodos relacionados con Disponibilidad */


    public function paginaPrincipal()
    {
        try {
            if($_SESSION['nivel']==2){
                $menu = $this->cargaMenu();
                require __DIR__ . '/../templates/panelAdministracion.php';
            }
            $idUsuario=$_SESSION['idUser'];
            $m = new Servicios();
            $params = array(
                'serviciosDisponibles' => $m->listarServiciosDisponibles($idUsuario),
            );

            // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            $params = array(
                'error' => $e->getMessage()
            );
            header('Location: index.php?ctl=error');
        }
        if($_SESSION['nivel']<2){
            $menu = $this->cargaMenu();
            require __DIR__ . '/../templates/paginaPrincipal.php';
        }
    }


    public function sendMail($asunto, $destinatarioEmail, $destinatarioNombre, $texto){
        $mail = new PHPMailer(true);

    try {
        //Valores dependientes del servidor que utilizamos
        
        $mail->isSMTP();                                           //Para usaar SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Nuestro servidor SMTMP smtp.gmail.com en caso de usar gmail
        $mail->SMTPAuth   = true;    
        /* 
        * SMTP username y password Poned los vuestros. La contraseña es la que nos generó GMAIL
        */
        $mail->Username   = 'juditentornoservidor@gmail.com';             
        $mail->Password   = 'pgaa vuwv ndnf lwvf';    
        /*
        * Encriptación a usar ssl o tls, dependiendo cual usemos hay que utilizar uno u otro puerto
        */            
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   
        $mail->Port = "465";

        //Remitente
            $mail->setFrom('entornoservidorjudit@gmail.com', 'Entorno Servidor');
        //Receptores. Podemos añadir más de uno. El segundo argumento es opcional, es el nombre
            $mail->addAddress($destinatarioEmail, $destinatarioNombre);     //Add a recipient

        //Contenido
        //Si enviamos HTML
        $mail->isHTML(true);    
        $mail->CharSet = "UTF8";    
        //Asunto
        $mail->Subject = $asunto;
        //Conteido HTML
        $mail->Body    = $texto;
        //Contenido alternativo en texto simple
        $mail->AltBody = $texto;
        //Enviar correo
        $mail->send();
        echo 'El mensaje se ha enviado con exito';
    } catch (Exception $e) {
        echo "El mensaje no se ha enviado: {$mail->ErrorInfo}";
        
    }
  }

    
}

?>
