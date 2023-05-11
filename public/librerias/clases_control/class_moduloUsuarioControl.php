<?php

require_once PATH_REQUIRES;

class moduloUsuarioControl {

    public function fn_registrarUsuario($datosIngreso) {
        $moduloUsuarioDAO = new moduloUsuarioDAO();
		$registro = $moduloUsuarioDAO->fn_registrarUsuario($datosIngreso['numeroDocumento'], $datosIngreso['tipoDocumento'], $datosIngreso['nombre'], $datosIngreso['apellidos'], $datosIngreso['correo'], $datosIngreso['contra']);
		return $registro;
    }

    public function fn_obtenerUsuarios() {
        $moduloUsuarioDAO = new moduloUsuarioDAO();
		$usuarios = $moduloUsuarioDAO->fn_obtenerUsuarios();
		return $usuarios;
    }

}