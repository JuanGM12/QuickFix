<?php

require_once PATH_REQUIRES;

class moduloUsuarioControl {

    public function fn_registrarUsuario () {
        $moduloUsuarioDAO = new moduloUsuarioDAO();
		$registro = $moduloUsuarioDAO->fn_obtenerUsuarios();
		return $registro;
    }

}