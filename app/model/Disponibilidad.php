<?php
class Disponibilidad extends Modelo {

    /**
     * Obtiene la lista de disponibilidades ordenadas.
     *
     * @return array Lista de disponibilidades.
     */
    public function listarDisponibilidad(){
		$consulta = "select * from disponibilidad order by disponibilidad";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll();
	}

    /**
     * Obtiene la información de una disponibilidad específica.
     *
     * @param int $id ID de la disponibilidad.
     * @return mixed Array con la información de la disponibilidad o false si no se encuentra.
     */
    public function mostrarDisponibilidad($id){
        $consulta = "select* from disponibilidad where id_disponibilidad=:id";
        $result = $this->conexion->prepare($consulta);
        $result -> bindParam(':id', $id);
        $result -> execute();
        return $result -> fetch();
    }

    /**
     * Obtiene el próximo ID disponible para una nueva disponibilidad.
     *
     * @return int Próximo ID disponible.
     */
    public function maxIdDisponibilidad(){

		$consulta = "select NVL(MAX(id_Disponibilidad),0) + 1 from disponibilidad";
        $result = $this->conexion->query($consulta);
        return $result->fetch();
		
	}

    /**
     * Inserta una nueva disponibilidad en la base de datos.
     *
     * @param string $disponibilidad Nombre de la disponibilidad.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function insertarDisponibilidad($disponibilidad){
  	$id_calculado = $this->maxIdDisponibilidad();
		$consulta = "insert into disponibilidad (id_disponibilidad, disponibilidad) VALUES (?,?)";
	  $result = $this->conexion->prepare($consulta);
		$result->bindParam(1, $id_calculado[0]);
		$result->bindParam(2, $disponibilidad);
		$result->execute();
		return $result;

	}

    /**
     * Elimina una disponibilidad de la base de datos.
     *
     * @param int $id ID de la disponibilidad a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function borrarDisponibilidad($id){ 
      $consulta = "delete from disponibilidad where id_disponibilidad=:id";
      $result = $this->conexion->prepare($consulta);
      $result->bindParam(':id', $id);
      $result->execute();
      return $result;
    }

     /**
     * Modifica el nombre de una disponibilidad en la base de datos.
     *
     * @param int    $id            ID de la disponibilidad a modificar.
     * @param string $disponibilidad Nuevo nombre de la disponibilidad.
     * @return bool True si la modificación fue exitosa, false en caso contrario.
     */
    public function modificarDsiponibilidad($id, $disponibilidad){

		$consulta = "update ididisponibilidadoma set  disponibilidad = ? where id_disponibilidad=?";
		$result = $this->conexion->prepare($consulta);
		$result->bindParam(1, $disponibilidad);
		$result->bindParam(2, $id);
		$result->execute();
		return $result;
	}
}
?>