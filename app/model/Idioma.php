<?php
class Idioma extends Modelo{

    public function listarIdiomas(){
		$consulta = "select * from idioma order by idioma";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll();
	}

    public function mostrarIdioma($id){
        $consulta = "select* from idioma where id_idioma=:id";
        $result = $this->conexion->prepare($consulta);
        $result -> bindParam(':id', $id);
        $result -> execute();
        return $result -> fetch();
    }

    public function maxIdIdioma(){

		$consulta = "select NVL(MAX(id_idioma),0) + 1 from idioma";
        $result = $this->conexion->query($consulta);
        return $result->fetch();
		
	}

    public function insertarIdioma($idioma){
		$id_calculado = $this->maxIdIdioma();
		$consulta = "insert into idioma (id_idioma, idioma) VALUES (?,?)";
	    $result = $this->conexion->prepare($consulta);
		$result->bindParam(1, $id_calculado[0]);
		$result->bindParam(2, $idioma);
		$result->execute();
		return $result;

	}  

    public function borrarIdioma($id){
		$consulta = "delete from idioma where id_idioma=:id";
		$result = $this->conexion->prepare($consulta);
		$result->bindParam(':id', $id);
		$result->execute();
		return $result;
	}

    public function modificarIdioma($id, $idioma){

		$consulta = "update idioma set  idioma = ? where id_idioma=?";
		$result = $this->conexion->prepare($consulta);
		$result->bindParam(1, $idioma);
		$result->bindParam(2, $id);
		$result->execute();
		return $result;
	}
}
?>