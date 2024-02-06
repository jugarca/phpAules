<?php


class Usuarios extends Modelo{

	/*
	Usaremos estas funciones para llevas a cabo la encriptación en el momento del registro y posteriormente en
	login comprobaremos si la contraseña es correcta concomprobarHash que a su vez utiliza password_verify
	*/

	//PASSWORD_BCRYPT Si queremos uUsar el algoritmo CRYPT_BLOWFISH
	public function encriptar($password, $cost=10) {
		return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost]);
	}

	public function comprobarhash($pass, $passBD) {
		// Primero comprobamos si se ha empleado una contraseña correcta:
		return password_verify($pass, $passBD);
	}
	
	public function listarUsuarios(){
		$consulta = "select * from usuario order by nombre";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll();
	}

	public function mostrarUsuario($email){
		$consulta = "select * from usuario where email=:email";
        $result = $this->conexion->prepare($consulta);
		$result -> bindParam(':email', $email);
		$result -> execute();
        return $result->fetch();
	}

	public function comprobarUsuario($email,$pass){
		$consulta = "select pass from usuario where email=:email and activo=1";
		$result = $this->conexion->prepare($consulta);
		$result->bindParam(':email', $email);
		$result->execute();
		$passwordBD = $result->fetch();
		if ($passwordBD == 1){
			return false;
		}
		
		return $this->comprobarhash($pass, $passwordBD[0]);
	}
	
	public function insertarUsuario($nombre, $email, $pass, $fNacim, $foto, $descripcion, $nivel, $activo){
		$id_calculado = $this->maxIdUser();
		$passEncriptado = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 10]);
		$consulta = "insert into usuario (id_user, nombre, email, pass, f_nacimiento, foto_perfil, descripción, nivel, activo) VALUES (?,?,?,?,?,?,?,?,?)";
	    $result = $this->conexion->prepare($consulta);
		$result->bindParam(1, $id_calculado[0]);
		$result->bindParam(2, $nombre);
		$result->bindParam(3, $email);
		$result->bindParam(4, $passEncriptado);
		$result->bindParam(5, $fNacim);
		$result->bindParam(6, $foto['name']);
		$result->bindParam(7, $descripcion);
		$result->bindParam(8, $nivel);
		$result->bindParam(9, $activo);
		$result->execute();
		return $result;

	}  
	
	public function maxIdUser(){

		$consulta = "select NVL(MAX(id_user),0) + 1 from usuario";
        $result = $this->conexion->query($consulta);
        return $result->fetch();
		
	}

	public function maxUser(){

		$consulta = "select NVL(MAX(id_user),0) from usuario";
        $result = $this->conexion->query($consulta);
		$usuarioMax = $result->fetch();
        return $usuarioMax[0];
		
	}
	
	public function borrarUsuario($id){
		$consulta = "delete from usuario where id_user=:id";
		$result = $this->conexion->prerare($consulta);
		$result->bindParam(':id', $id);
		$result->execute();
		return $result;
	}
	
	public function modificarUsuario($id, $pass, $foto, $descripcion){

		$passEncriptado = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 10]);
		$consulta = "update usuario set  pass = ?, foto_perfil = ?, descripción = ? where id_user=?";
		$result = $this->conexion->prepare($consulta);
		$result->bindParam(1, $passEncriptado);
		$result->bindParam(2, $foto);
		$result->bindParam(3, $descripcion);
		$result->bindParam(4, $id);
		$result->execute();
		return $result;

	}

	public function activarUsuario($idUser){
		$consulta = "UPDATE usuario SET activo=1 where id_user=:idUser";
		$result = $this->conexion->prepare($consulta);
		$result->bindParam(':idUser', $idUser);
		$result->execute();
		return $result;

	}

	
	
    
}
?>