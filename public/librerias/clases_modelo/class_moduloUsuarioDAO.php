<?php

class moduloUsuarioDAO extends base_datos {

	public function __construct() {
		$this->initial_database();
	}

    public function fn_obtenerUsuarios(){
        $query ="SELECT * FROM usuario_web ";
        $this->connect();
        $this->query($query, "class_moduloUsuarioDAO.php: fn_obtenerUsuarios");
        $queryError = $this->conn->error;
        $this->close_db();
        if($queryError){
            throw new Exception('No fue posible obtener la información de los usuarios (c_mUD-oU-8AeciPv)');
        }else{
            $infoUsuarios = [];
            for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
                $infoUsuarios[] =  $row;
            }
            return $infoUsuarios;
        }
    }

    public function fn_registrarUsuario($documento, $tipoDocumento, $nombre, $apellido, $correo, $clave) {
        try {
            $query = "INSERT INTO usuario_web ";
            $query .= "(documento_usuario, tipodocumento, nombre, apellido, correo, clave, fecha_inscripcion) VALUES ";
            $query .= "($documento, '$tipoDocumento', '$nombre', '$apellido', '$correo', '$clave', NOW());";
            $this->connect();
            $this->query($query, "class_moduloUsuarioDAO.php: fn_registrarUsuario");	
            $this->close_db();
        } catch (Exception $e) {
            return array(json_encode($e), false);
        }
    }

}