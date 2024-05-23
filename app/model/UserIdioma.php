<?php
class UserIdioma extends Modelo {
    public function mostrarIdiomaUser($id){
        $consulta = "select * from user-idioma where id_user=:id";
        $result = $this->conexion->prepare($consulta);
        $result -> bindParam(':id', $id);
        $result -> execute();
        return $result -> fetch();
    }


    public function insertarIdiomaUser($idUser, $idIdioma){
		$consulta = "insert into user-idioma (id_user, id_idioma) VALUES (?,?)";
	    $result = $this->conexion->prerare($consulta);
		$result->bindParam(1, $idUser);
		$result->bindParam(2, $idIdioma);
		$result->execute();
		return $result;

	}

    public function borrarIdiomaUser($idUser, $idIdioma){
		$consulta = "delete from user-idioma where id_user=:idUser AND id_idioma=:idIdioma";
		$result = $this->conexion->prerare($consulta);
		$result->bindParam(':idUser', $idUser);
        $result->bindParam(':idIdioma', $idIdioma);
		$result->execute();
		return $result;
	}
}
?>