<?php
class Servicios extends Modelo{
    
    public function listarServicios(){
		$consulta = "select * from servicios order by titulo";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll();
	}

	public function listar3Servicios(){
		$consulta = "select titulo, precio from servicios order by id_servicios DESC LIMIT 3";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll();
	}

    public function listarServiciosDisponibles($idUsuario){
		$consulta = "select titulo, descripcion, tipo, id_servicios from servicios where id_user != :idusuario order by id_servicios desc";
        $result = $this->conexion->prepare($consulta);
        $result -> bindParam(':idusuario', $idUsuario);
        $result -> execute();
        return $result->fetchAll();
	}

    public function mostrarServicio($id){
		$consulta = "select * from servicios where id_servicios=:id";
        $result = $this->conexion->prepare($consulta);
		$result -> bindParam(':id', $id);
		$result -> execute();
        return $result->fetch();
	}

    public function maxIdServicio(){

		$consulta = "select NVL(MAX(id_servicios),0) + 1 from servicios";
        $result = $this->conexion->query($consulta);
        return $result->fetch();
		
	}

    public function insertarServicio($titulo, $idUser, $descripcion, $precio, $tipo, $foto){
		$id_calculado = $this->maxIdServicio();
		$consulta = "insert into servicios (id_servicios, titulo, id_user, descripcion, precio, tipo, foto_servicio) VALUES (?,?,?,?,?,?,?)";
	    $result = $this->conexion->prepare($consulta);
		$result->bindParam(1, $id_calculado[0]);
		$result->bindParam(2, $titulo);
		$result->bindParam(3, $idUser);
		$result->bindParam(4, $descripcion);
		$result->bindParam(5, $precio);
		$result->bindParam(6, $tipo);
		$result->bindParam(7, $foto);
		$result->execute();
		return $result;

	}

    public function borrarServicio($id){
		$consulta = "delete from servicios where id_servicio=:id";
		$result = $this->conexion->prerare($consulta);
		$result->bindParam(':id', $id);
		$result->execute();
		return $result;
	}

    public function modificarServicio($id, $titulo, $descripcion, $precio, $tipo, $foto){

		$consulta = "update servicios set  titulo = ?, descripcion = ?, precio = ?,  tipo = ?, foto_servicio = ? where id_servicios=?";
		$result = $this->conexion->prepare($consulta);
		$result->bindParam(1, $titulo);
		$result->bindParam(2, $descripcion);
		$result->bindParam(3, $precio);
        $result->bindParam(4, $tipo);
        $result->bindParam(5, $foto);
        $result->bindParam(6, $id);
		$result->execute();
		return $result;
	}

}   
?>