<?php


class Modelo extends PDO{
	

    protected $conexion;
	public $mvc_bd_hostname = "localhost";
    public $mvc_bd_nombre = "evaluable_7w";
    public $mvc_bd_usuario = "root";
    public $mvc_bd_clave = "";

    public function __construct()
    {
        
            $this->conexion = new PDO('mysql:host=' . 'localhost' . ';dbname=' . 'evaluable_7w' . '', 'root', '');
            // Realiza el enlace con la BD en utf-8
            $this->conexion->exec("set names utf8");
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
    }

    public function getPDO(){
        return $this->$pdo;
    }

   

   
    
}
?>