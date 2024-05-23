<?php
class Tokens extends Modelo{
    
    public function mostrarTokenUser($id){
        $consulta = "SELECT * from tokens where id_user=:id";
        $result = $this->conexion->prepare($consulta);
        $result -> bindParam(':id', $id);
        $result -> execute();
        return $result -> fetch();
    }

    public function recuperaUser($token){
        $consulta = "SELECT id_user from tokens where token=:token";
        $result = $this->conexion->prepare($consulta);
        $result -> bindParam(':token', $token);
        $result -> execute();
        $usuario = $result -> fetch();
        return $usuario[0];
    }

    public function insertarTokens ($token,$validez,$idUser){
        $consulta = "INSERT INTO tokens(token, validez, id_user) VALUES (?,?,?)";
        $result = $this->conexion->prepare($consulta);
        $result -> bindParam(1, $token);
        $result -> bindParam(2, $validez);
        $result -> bindParam(3, $idUser);
        $result -> execute();
        return $result;
    }

    public function deleteToken($token){
        $consulta = "DELETE FROM `tokens` WHERE token=:token";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':token', $token);
        $result->execute();
        return $result;
    }

}
?>