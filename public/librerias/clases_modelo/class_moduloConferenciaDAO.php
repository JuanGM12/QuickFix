<?php

/*
 * Hecho en 01/08/2011
 * Actualizado en 01/03/2012
 * ----------------------------------------------
 * Clase de control de datos para modulos de conferencias
 * Copyright (c) Grupo Mide S.A
 * URL: http://www.grupomide.com
 * Proyecto: Aula Virtual
 * ----------------------------------------------
 */


class moduloConferenciaDAO extends base_datos {

	public function __construct() {
		$this->initial_database();
	}

	/*
	* Funciones de consultas tabla tprote_modulos
	*/
	//Funcion de lectura de modulos
	public function fn_traerUsuarios() {
		$query = "SELECT * FROM usuarios";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_traerUsuarios");
		$moduloConferencia = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[]  =  $row;
		}
		$this->close_db();
		return $moduloConferencia;
	}

	//Funcion de lectura de modulos por categorias
	public function fn_leerConferenciaPorCategorias($idconferencia) {
		//$categoriasConferencia = "";
		$query = "SELECT DISTINCT cc.idcategoria FROM conferencia_categoria AS cc ";
		$query .= "WHERE cc.idconferencia = $idconferencia;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerConferenciaPorCategorias");
		$categoriasConferencia = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$categoriasConferencia[$i] = $row['idcategoria'];
		} //Fin for
		$this->close_db();
		return $categoriasConferencia;
	} //Fin fn_leerModuloConferenciaPorCategorias

	//Funcion de lectura de modulos por categorias
	public function fn_leerModuloConferenciaPorCategorias($iidModuloConferencia) {
		$query = "";
		$query = "SELECT DISTINCT cc.idcategoria FROM conferencia_categoria AS cc, conferencia_modulo_conferencia AS cmc ";
		$query .= "WHERE cc.idconferencia = cmc.idconferencia AND cmc.idmodulo_conferencia = $iidModuloConferencia;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerModuloConferenciaPorCategorias");
		$categoriasConferencia=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$categoriasConferencia[$i] = $row['idcategoria'];
		} //Fin for
		$this->close_db();
		return $categoriasConferencia;
	} //Fin fn_leerModuloConferenciaPorCategorias


	//Funcion de lectura de modulos por grupo de usuario asociado
	public function fn_leerModuloConferenciaPorCategoriasGrupos($idconferencia) {
		$query = "";
		$query = "SELECT DISTINCT cc.idcategoria FROM conferencia_categoria AS cc, conferencia_modulo_conferencia AS cmc ";
		$query .= " WHERE cc.idconferencia = cmc.idconferencia AND cmc.idmodulo_conferencia=$idconferencia ORDER BY cc.idcategoria ;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerModuloConferenciaPorCategoriasGrupos");
		$categoriasConferenciaGrupos = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$categoriasConferenciaGrupos[$i] = $row['idcategoria'];
		} //Fin for
		$this->close_db();
		return $categoriasConferenciaGrupos;
	} //Fin fn_leerModuloConferenciaPorCategorias

	//Funcion de lectura de modulos por grupo de usuario asociado
	public function fn_leerModuloConferenciaPorCategoriasGruposUsuarios($idconferencia) {
		$query = "";
		$query = " SELECT DISTINCT gc.idgrupo FROM conferencia_categoria AS cc, conferencia_modulo_conferencia AS cmc, grupos_categorias AS gc ";
		$query .= " WHERE cc.idconferencia = cmc.idconferencia AND gc.idcategoria=cc.idcategoria AND cmc.idmodulo_conferencia=$idconferencia ORDER BY gc.idgrupo ;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerModuloConferenciaPorCategoriasGruposUsuarios");
		$categoriasConferenciaGrupos = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$categoriasConferenciaGrupos[$i] = $row['idgrupo'];
		} //Fin for
		$this->close_db();
		return $categoriasConferenciaGrupos;
	} //Fin fn_leerModuloConferenciaPorCategorias




	//Validar si existe un Modulo de conferencia existe
	public function fn_validarExistenciaModuloConferencia($iidModuloConferencia) {
		$query = "";
		$query = "SELECT idmodulo_conferencia FROM modulo_conferencia ";
		$query .= "WHERE idmodulo_conferencia = $iidModuloConferencia;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_validarExistenciaModuloConferencia");
		$row = $this->fetch_array($this->result);
		if ($row) {
			$oboolExiste = true;
		} //Fin if
		else {
			$oboolExiste = false;
		} //Fin else
		$this->close_db();
		return $oboolExiste;
	} //Fin fn_validarExistenciaModuloConferencia

	//Retornar todos los modulos de un canal
	public function fn_retornarTodosModulosCanal() {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT idmodulo_conferencia ";
		$query .= "FROM modulo_conferencia ";
		$query .= "WHERE idmodulo_padre IS NULL ";
		$query .= "AND fealta <= '$fechaActual' AND febaja >= '$fechaActual' ";
		$query .= " ORDER BY nmposicion_inicio, idmodulo_conferencia DESC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarTodosModulosCanal");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosModulosCanal[$i] = $row['idmodulo_conferencia'];
		} //Fin for
		$this->close_db();
		return $oCodigosModulosCanal;
	} //Fin fn_retornarModulosCanal

	//Retornar todos los modulos de un canal
	public function fn_retornarTodosModulosCanalOrdenAlfabetico($orden) {
		$fechaActual = date("Y-m-d");
		$query  = "SELECT mc.idmodulo_conferencia as idmodulo_conferencia, mc.dsnombre_modulo, mc.dsdescripcion_modulo, mc.dsruta_imagen_modulo, mci.textoinfo, mci.destacado, mci.composicion, mci.duracion, mci.parametros, mci.metas, mc.dstiene_diploma,mc.dsestado_menu_principal, mc.dsestado_inicio  ";
		$query .= "FROM modulo_conferencia AS mc, modulo_conferencia_informacion AS mci ";
		$query .= "WHERE mc.idmodulo_padre IS NULL AND mc.idmodulo_conferencia=mci.idmodulo ";
		$query .= "AND mc.fealta <= '$fechaActual' AND mc.febaja >= '$fechaActual' ";
		$query .= " ORDER BY mc." . $orden . " ASC;";
		//return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarTodosModulosCanal");
		$oCodigosModulosCanal = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosModulosCanal[] = $row;
		} //Fin for
		$this->close_db();
		return $oCodigosModulosCanal;
	} //Fin fn_retornarModulosCanal

	public function fn_retornarTodosModulosCanalOrden($idBuscado) {

		$fechaActual = date("Y-m-d");

		if ($idBuscado == "0") {
			$query = "SELECT * FROM modulo_conferencia ";
			$query .= "WHERE idmodulo_padre IS NULL ";
			$query .= "AND fealta <= '".$fechaActual."' AND febaja >= '".$fechaActual."' ";
			$query .= "ORDER BY nmposicion_inicio ASC;";
		} else {
			$query = "SELECT * FROM modulo_conferencia ";
			$query .= "WHERE idmodulo_padre= ".$idBuscado." ";
			$query .= "AND fealta <= '".$fechaActual."' AND febaja >= '".$fechaActual."' ";
			$query .= "ORDER BY idmodulo_padre, nmposicion_inicio ASC;";
		}
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarTodosModulosCanalOrden");

		$infoModulosCanal = array();
		$infoModulosCanal=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$infoModulosCanal[]	  = $row;
		}
		$this->close_db();
		return $infoModulosCanal;
	}

	//Retornar modulos activos de un canal
	public function fn_retornarModulosCanal() {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT idmodulo_conferencia ";
		$query .= "FROM modulo_conferencia ";
		$query .= "WHERE fealta <= '" . $fechaActual . "' AND febaja >= '" . $fechaActual . "';";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarModulosCanal");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosModulosCanal[$i] = $row['idmodulo_conferencia'];
		} //Fin for

		$this->close_db();
		return $oCodigosModulosCanal;
	} //Fin fn_retornarModulosCanal

	//Retornar submodulos de un modulo de conferencia.
	public function fn_retornarTotalSubModulosConferencia($iidModuloConferenciaPadre) {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT idmodulo_conferencia ";
		$query .= "FROM modulo_conferencia ";
		$query .= "WHERE idmodulo_padre = $iidModuloConferenciaPadre ";
		$query .= "AND fealta <= '$fechaActual' AND febaja >= '$fechaActual' ";
		$query .= "ORDER BY nmposicion_inicio ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarTotalSubModulosConferencia");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosSubModulos[$i] = $row['idmodulo_conferencia'];
		} //Fin for
		$this->close_db();
		return $oCodigosSubModulos;
	} //Fin fn_retornarTotalSubModulosConferencia


	//Retornar submodulos de un modulo de conferencia.
	public function fn_retornarTotalSubModulosConferenciaPerfil($iidModuloConferenciaPadre, $idUsuario) {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT DISTINCT(mc.idmodulo_conferencia) ";
		$query .= "FROM modulo_conferencia AS mc,  conferencia_modulo_conferencia AS cmc, conferencia_categoria AS cc, usuarios_administradores_categorias AS uac ";
		$query .= "WHERE mc.idmodulo_padre = $iidModuloConferenciaPadre AND cmc.idmodulo_conferencia=mc.idmodulo_conferencia AND cmc.idconferencia=cc.idconferencia ";
		$query .= " AND cc.idcategoria=uac.idcategoria AND uac.idadmin=$idUsuario  AND mc.fealta <= '$fechaActual' AND mc.febaja >= '$fechaActual' ";
		$query .= "ORDER BY mc.nmposicion_inicio ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarTotalSubModulosConferencia");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosSubModulos[$i] = $row['idmodulo_conferencia'];
			/*$oCodigosSubModulos[$i]['prueba'] = $fechaActual;*/
		} //Fin for

		$this->close_db();
		return $oCodigosSubModulos;
	} //Fin fn_retornarTotalSubModulosConferencia



	//Retornar submodulos de un modulo de conferencia.
	public function fn_retornarSubModulosConferencia($iidModuloConferenciaPadre) {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT idmodulo_conferencia ";
		$query .= "FROM modulo_conferencia ";
		$query .= "WHERE idmodulo_padre = $iidModuloConferenciaPadre ";
		$query .= "AND fealta <= '" . $fechaActual . "' AND febaja >= '" . $fechaActual . "' ";
		$query .= "ORDER BY nmposicion_inicio ASC;";

		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarSubModulosConferencia");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosSubModulos[$i] = $row['idmodulo_conferencia'];
		} //Fin for

		$this->close_db();
		return $oCodigosSubModulos;
	} //Fin fn_retornarSubModulosConferencia

	/*
 * Funciones de inserciones
 */

	//Funcion de insercion de un modulo conferencia
	public function fn_ingresarModulo($iidmoduloPadre, $idsNombreModulo, $idsDescipcionModulo, $idsRutaImagenModulo, $idsTipoVisualizacion, $idsTieneDipoma, $idsEvaluacionModulo, $ifealta, $ifebaja, $iidUsuarioModificador, $idioma = "", $titulotexto, $autor) {
		$idsNombreModulo     = ($idsNombreModulo);
		$idsDescipcionModulo = ($idsDescipcionModulo);
		if ($iidmoduloPadre == "" || $iidmoduloPadre == 0 || $iidmoduloPadre == NULL) {
			$query = "";
			$query = "INSERT INTO modulo_conferencia" . $idioma . " ";
			$query .= "(dsnombre_modulo, dsdescripcion_modulo, dsruta_imagen_modulo, dstipo_visualizacion, ";
			$query .= "dstiene_diploma, dsevaluacion_modulo, dsestado_menu_principal, dsestado_inicio, fealta, febaja, idusuario_modificador, femodificacion) VALUES ";
			$query .= "('$idsNombreModulo', '$idsDescipcionModulo', '$idsRutaImagenModulo', ";
			$query .= "'$idsTipoVisualizacion', '$idsTieneDipoma', '$idsEvaluacionModulo', '$autor', '$titulotexto', '$ifealta', '$ifebaja', $iidUsuarioModificador, NOW());";
		} //Fin if
		else {
			$query = "";
			$query = "INSERT INTO modulo_conferencia" . $idioma . " ";
			$query .= "(idmodulo_padre, dsnombre_modulo, dsdescripcion_modulo, dsruta_imagen_modulo, dstipo_visualizacion, ";
			$query .= "dstiene_diploma, dsevaluacion_modulo, dsestado_menu_principal, dsestado_inicio, fealta, febaja, idusuario_modificador, femodificacion) VALUES ";
			$query .= "($iidmoduloPadre, '$idsNombreModulo', '$idsDescipcionModulo', '$idsRutaImagenModulo', ";
			$query .= "'$idsTipoVisualizacion', '$idsTieneDipoma', '$idsEvaluacionModulo', '$autor', '$titulotexto', '$ifealta', '$ifebaja', $iidUsuarioModificador, NOW());";
		}
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarModulo");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} //Fin fn_ingresarModulo

	/** Actualizacion 2020   */

	public function fn_ingresarModulo_informacion($iidmodulo, $arrayInformacion, $iidUsuarioModificador, $idioma = "") {

		$query = "";
		$query = "INSERT INTO modulo_conferencia_informacion" . $idioma . " ";
		$query .= "(idmodulo, idadministrador, textoinfo, metas, temaodivi, destacado, idioma, composicion, duracion, notificar, parametros) VALUES ";
		$query .= "('$iidmodulo', '$iidUsuarioModificador', '" . $arrayInformacion['contenido'] . "', ";
		$query .= "'" . $arrayInformacion['metas'] . "', '" . $arrayInformacion['tema'] . "', '" . $arrayInformacion['destacado'] . "', 'ES', '" . $arrayInformacion['composicion'] . "', '" . $arrayInformacion['duracion']["duracion"] . '###' .$arrayInformacion['duracion']["descDuracion"]. "', '" . $arrayInformacion['notificar'] . "', '" . $arrayInformacion['parametros']["modalidad"].'###'. $arrayInformacion['parametros']["descModalidad"]  . "');";
		// return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarModulo_informacion");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} //Fin fn_ingresarModulo

	public function fn_ingresarModulo_perfil($iidmodulo, $arrayInformacion, $iidUsuarioModificador, $idioma = "") {

		$query = "";
		$query = "INSERT INTO modulo_conferencia_perfil" . $idioma . " ";
		$query .= "(idmodulo, idperfil, idadministrador, fecha) VALUES ";

		$auxiliar = 0;
		foreach ($arrayInformacion as $key => $value) {
			$auxiliar++;
			if (count($arrayInformacion) <= 1) {
				$query .= "('$iidmodulo', '$value', '$iidUsuarioModificador', NOW());";
			} elseif ($auxiliar == count($arrayInformacion)) {
				$query .= "('$iidmodulo', '$value', '$iidUsuarioModificador', NOW());";
			} else {
				$query .= "('$iidmodulo', '$value', '$iidUsuarioModificador', NOW()),";
			}
		}

		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarModulo_perfil");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} //Fin fn_ingresarModulo

	public function fn_ingresarModulo_segmento($iidmodulo, $arrayInformacion, $iidUsuarioModificador, $idioma = "") {
		try {
			$query = "INSERT INTO modulo_conferencia_segmento" . $idioma . " ";
			$query .= "(idmodulo, idsegmento, idadministrador, fecha) VALUES ";

			$auxiliar = 0;

			foreach ($arrayInformacion as $key => $value) {
				$auxiliar++;

				if (count($arrayInformacion) <= 1) {
					$query .= "('$iidmodulo', '$value', '$iidUsuarioModificador', NOW());";
				} elseif ($auxiliar == count($arrayInformacion)) {
					$query .= "('$iidmodulo', '$value', '$iidUsuarioModificador', NOW());";
				} else {
					$query .= "('$iidmodulo', '$value', '$iidUsuarioModificador', NOW()),";
				}
			}

			$this->connect();
			$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarModulo_perfil");

			$oidModuloConferencia = $this->last_insert();

			$this->close_db();

			return $oidModuloConferencia;
		} catch (Exception $e) {
			return array(json_encode($e), false);
		}
	}

	

	public function fn_ingresarCursoPreguntaFrecuente($arrayInformacion, $idAdministrador, $idPregunta) {
		try {
			$query = "INSERT INTO modulo_conferencia_preguntas_frecuentes_curso ";
			$query .= "(idmodulo_conferencia, idpregunta, idadministrador, fechamodificacion) VALUES ";

			$auxiliar = 0;

			foreach ($arrayInformacion as $key => $value) {
				$auxiliar++;

				if (count($arrayInformacion) <= 1) {
					$query .= "('$value', '$idPregunta', '$idAdministrador', NOW());";
				} elseif ($auxiliar == count($arrayInformacion)) {
					$query .= "('$value', '$idPregunta', '$idAdministrador', NOW());";
				} else {
					$query .= "('$value', '$idPregunta', '$idAdministrador', NOW()),";
				}
			}

			$this->connect();
			$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarCursoPreguntaFrecuente");

			$oidModuloConferencia = $this->last_insert();

			$this->close_db();

			return $oidModuloConferencia;
		} catch (Exception $e) {
			return array(json_encode($e), false);
		}
	}

	public function fn_ingresarPreguntaFrecuente($titulo, $descripcion, $idUsuarioModificador) {
		try {
			$query = "INSERT INTO modulo_conferencia_preguntas_frecuentes ";
			$query .= "(titulo_pregunta, descripcion_pregunta, estado, orden, idadministrador, fecha) VALUES ";
			$query .= "('$titulo', '$descripcion', '1', '0', $idUsuarioModificador, NOW());";

			$this->connect();
			$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarPreguntaFrecuente");

			$oidModuloConferencia = $this->last_insert();

			$this->close_db();

			return $oidModuloConferencia;
		} catch (Exception $e) {
			return array(json_encode($e), false);
		}
	}

	public function fn_ingresarNivelCurso($idModulo, $idNivel, $idUsuarioModificador) {
		try {
			$query = "INSERT INTO modulo_conferencia_nivel_rel ";
			$query .= "(idmodulo_conferencia, idnivel, idadministrador, fechamodificacion) VALUES ";
			$query .= "($idModulo, $idNivel, $idUsuarioModificador, NOW());";

			$this->connect();
			$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarNivelCurso");

			$oidModuloConferencia = $this->last_insert();

			$this->close_db();

			return $oidModuloConferencia;
		} catch (Exception $e) {
			return array(json_encode($e), false);
		}
	}

	/*public function fn_ingresarModulo($iidmoduloPadre, $idsNombreModulo, $idsDescipcionModulo, $idsRutaImagenModulo, $idsTipoVisualizacion, $idsTieneDipoma, $idsEvaluacionModulo, $ifealta, $ifebaja, $iidUsuarioModificador){
		$idsNombreModulo     = ($idsNombreModulo);
		$idsDescipcionModulo = ($idsDescipcionModulo);
		if($iidmoduloPadre == "" || $iidmoduloPadre == 0 || $iidmoduloPadre == NULL)
		{
			$query = "";
			$query = "INSERT INTO modulo_conferencia ";
			$query .= "(dsnombre_modulo, dsdescripcion_modulo, dsruta_imagen_modulo, dstipo_visualizacion, ";
			$query .= "dstiene_diploma, dsevaluacion_modulo, fealta, febaja, idusuario_modificador, femodificacion) VALUES ";
			$query .= "('$idsNombreModulo', '$idsDescipcionModulo', '$idsRutaImagenModulo', ";
			$query .= "'$idsTipoVisualizacion', '$idsTieneDipoma', '$idsEvaluacionModulo', '$ifealta', '$ifebaja', $iidUsuarioModificador, NOW());";
		}//Fin if
		else{
			$query = "";
			$query = "INSERT INTO modulo_conferencia ";
			$query .= "(idmodulo_padre, dsnombre_modulo, dsdescripcion_modulo, dsruta_imagen_modulo, dstipo_visualizacion, ";
			$query .= "dstiene_diploma, dsevaluacion_modulo, fealta, febaja, idusuario_modificador, femodificacion) VALUES ";
			$query .= "($iidmoduloPadre, '$idsNombreModulo', '$idsDescipcionModulo', '$idsRutaImagenModulo', ";
			$query .= "'$idsTipoVisualizacion', '$idsTieneDipoma', '$idsEvaluacionModulo', '$ifealta', '$ifebaja', $iidUsuarioModificador, NOW());";
		}
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarModulo");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	}//Fin fn_ingresarModulo

*/
	public function fn_ingresarDatosModuloCertificado($oidModuloConferencia, $id_certificado, $idAdmon, $idioma = "") {
		$query = "";
		$query = "INSERT INTO certificado_modulos" . $idioma . " ";
		$query .= "(idmodulo, idcertificado, idadmin, femodificacion) VALUES";
		$query .= "($oidModuloConferencia, $id_certificado, $idAdmon, NOW());";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarDatosModuloCertificado");
		$this->close_db();
	}

	/*
 * Funciones de inserciones de la tabla modulos
 */

	/*
 * Funciones de actualizaciones
 */

	public function fn_modificarModulo($iidmodulo, $iidmoduloPadre, $idsNombreModulo, $idsDescipcionModulo, $idsRutaImagenModulo, $idsTipoVisualizacion, $idsTieneDipoma, $idsEvaluacionModulo, $ifebaja, $iidUsuarioModificador, $tipoprograma, $horascert, $infoautor, $autor, $idioma = "") {
		$idsNombreModulo     = ($idsNombreModulo);
		$idsDescipcionModulo = ($idsDescipcionModulo);
		if ($iidmoduloPadre == "" || $iidmoduloPadre == 0 || $iidmoduloPadre == NULL) {
			$query = "";
			$query = "UPDATE modulo_conferencia" . $idioma . " ";
			$query .= "SET idmodulo_padre = NULL, dsnombre_modulo = '$idsNombreModulo', ";
			$query .= "dsdescripcion_modulo = '$idsDescipcionModulo', dsruta_imagen_modulo = '$idsRutaImagenModulo', ";
			$query .= "dstipo_visualizacion = '$idsTipoVisualizacion', dstiene_diploma = '$idsTieneDipoma', nmposicion_menu_superior = $horascert, dsestado_inicio = '$infoautor', dsestado_menu_principal = '$autor', ";
			$query .= "dsevaluacion_modulo = '$idsEvaluacionModulo', febaja = '$ifebaja', idusuario_modificador = $iidUsuarioModificador, dsestado_menu_superior='$tipoprograma', ";
			$query .= "femodificacion = NOW() WHERE idmodulo_conferencia = $iidmodulo;";
		} //Fin if
		else {
			$query = "";
			$query = "UPDATE modulo_conferencia" . $idioma . " ";
			$query .= "SET idmodulo_padre = $iidmoduloPadre, dsnombre_modulo = '$idsNombreModulo', ";
			$query .= "dsdescripcion_modulo = '$idsDescipcionModulo', dsruta_imagen_modulo = '$idsRutaImagenModulo', ";
			$query .= "dstipo_visualizacion = '$idsTipoVisualizacion', dstiene_diploma = '$idsTieneDipoma', nmposicion_menu_superior = $horascert, dsestado_inicio = '$infoautor', dsestado_menu_principal = '$autor', ";
			$query .= "dsevaluacion_modulo = '$idsEvaluacionModulo', febaja = '$ifebaja', idusuario_modificador = $iidUsuarioModificador, dsestado_menu_superior='$tipoprograma', ";
			$query .= "femodificacion = NOW() WHERE idmodulo_conferencia = $iidmodulo;";
		}
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_modificarModulo");
		$this->close_db();
		return $query;
	} //Fin fn_modificarModulo

	public function fn_modificarPregunta($titulo, $descripcion, $idadmin, $idpregunta) {
			$query = "";
			$query = "UPDATE modulo_conferencia_preguntas_frecuentes ";
			$query .= "SET titulo_pregunta = '$titulo', descripcion_pregunta = '$descripcion', ";
			$query .= "idadministrador = '$idadmin', fecha = NOW() ";
			$query .= "WHERE idpregunta = $idpregunta;";
		
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_modificarModulo");
		$this->close_db();
		return $query;
	}


	public function fn_modificarModulo2($iidmodulo, $iidmoduloPadre, $idsNombreModulo, $idsDescipcionModulo, $idsRutaImagenModulo, $idsTipoVisualizacion, $idsTieneDipoma, $idsEvaluacionModulo, $ifealta, $ifebaja, $iidUsuarioModificador, $tipoprograma, $horascert, $infoautor, $autor, $idioma = "") {

		$idsNombreModulo     = ($idsNombreModulo);
		$idsDescipcionModulo = ($idsDescipcionModulo);
		if ($iidmoduloPadre == "" || $iidmoduloPadre == 0 || $iidmoduloPadre == NULL) {
			$query = "";
			$query = "UPDATE modulo_conferencia" . $idioma . " ";
			$query .= "SET idmodulo_padre = NULL, dsnombre_modulo = '$idsNombreModulo', ";
			$query .= "dsdescripcion_modulo = '$idsDescipcionModulo', dsruta_imagen_modulo = '$idsRutaImagenModulo', ";
			$query .= "dstipo_visualizacion = '$idsTipoVisualizacion', dstiene_diploma = '$idsTieneDipoma', nmposicion_menu_superior = $horascert, dsestado_inicio = '$infoautor', dsestado_menu_principal = '$autor', ";
			$query .= "dsevaluacion_modulo = '$idsEvaluacionModulo', fealta = '$ifealta', febaja = '$ifebaja', idusuario_modificador = $iidUsuarioModificador, dsestado_menu_superior='$tipoprograma', ";
			$query .= "femodificacion = NOW() WHERE idmodulo_conferencia = $iidmodulo;";
		} //Fin if
		else {
			$query = "";
			$query = "UPDATE modulo_conferencia" . $idioma . " ";
			$query .= "SET idmodulo_padre = $iidmoduloPadre, dsnombre_modulo = '$idsNombreModulo', ";
			$query .= "dsdescripcion_modulo = '$idsDescipcionModulo', dsruta_imagen_modulo = '$idsRutaImagenModulo', ";
			$query .= "dstipo_visualizacion = '$idsTipoVisualizacion', dstiene_diploma = '$idsTieneDipoma', nmposicion_menu_superior = $horascert, dsestado_inicio = '$infoautor', dsestado_menu_principal = '$autor', ";
			$query .= "dsevaluacion_modulo = '$idsEvaluacionModulo', fealta = '$ifealta', febaja = '$ifebaja', idusuario_modificador = $iidUsuarioModificador, dsestado_menu_superior='$tipoprograma', ";
			$query .= "femodificacion = NOW() WHERE idmodulo_conferencia = $iidmodulo;";
		}
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_modificarModulo");
		$this->close_db();
		return $query;
	} //Fin fn_modificarModulo


	public function fn_cambiarOrdenModulos($iidmodulo, $nuevoOrden, $iidUsuarioModificador) {
		$query = "";
		$query = "UPDATE modulo_conferencia ";
		$query .= "SET nmposicion_inicio = '" . $nuevoOrden . "', idusuario_modificador = $iidUsuarioModificador, femodificacion = NOW() WHERE idmodulo_conferencia = $iidmodulo;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_cambiarOrdenModulos");
		$this->close_db();
		return $query;
	} //Fin fn_modificarModulo

	public function fn_cambiarOrdenPreguntas($idPregunta, $nuevoOrden, $iidUsuarioModificador) {
		$query = "";
		$query = "UPDATE modulo_conferencia_preguntas_frecuentes ";
		$query .= "SET orden = '" . $nuevoOrden . "', idadministrador = $iidUsuarioModificador, fecha = NOW() WHERE idpregunta = $idPregunta;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_cambiarOrdenPreguntas");
		$this->close_db();
		return $query;
	} //Fin fn_modificarModulo

	public function fn_cambiarOrdenMetodologias($idMetodologia, $nuevoOrden, $iidUsuarioModificador) {
		$query = "";
		$query = "UPDATE modulo_conferencia_metodologias ";
		$query .= "SET orden = '".$nuevoOrden."', idadministrador = $iidUsuarioModificador, fechamodificacion = NOW() WHERE idmetodologia = $idMetodologia;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_cambiarOrdenMetodologias");
		$this->close_db();
		return $query;
	} 

	public function fn_cambiarOrdenDestacados($idDestacado, $nuevoOrden, $iidUsuarioModificador) {
		$query = "";
		$query = "UPDATE modulo_conferencia_destacados ";
		$query .= "SET orden = '".$nuevoOrden."', idadministrador = $iidUsuarioModificador, fechamodificacion = NOW() WHERE iddestacado = $idDestacado;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_cambiarOrdenDestacados");
		$this->close_db();
		return $query;
	}

	public function fn_cambiarOrdenConferencia($iidmodulo, $nuevoOrden, $iidUsuarioModificador, $iidConferencia) {
		$query = "";
		$query = "UPDATE conferencia_modulo_conferencia ";
		$query .= "SET nmposicion = '" . $nuevoOrden . "', idusuario_modificacion = $iidUsuarioModificador, femodificacion = NOW() WHERE idmodulo_conferencia = $iidmodulo AND idconferencia = $iidConferencia;";
		// return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_cambiarOrdenModulos");
		$this->close_db();
		return $query;
	} //Fin fn_modificarModulo

	//Función que se encarga de validar si ha superado evaluación para generar certificado
	public function fn_validarAprobadoEvaluacionCurso($idModuloCurso, $idUsuario) {
		$query = "";
		$query = " SELECT COUNT(DISTINCT cer.idconferencia) AS aprobo FROM config_evaluaciones AS ce, conferencia_evaluacion_resultados AS cer ";
		$query .= " WHERE ce.porcentajeganar<=cer.dspuntuacion   AND ce.idconferencia=cer.idconferencia AND cer.idconferencia = '" . $idModuloCurso . "' AND cer.idusuario_web = '" . $idUsuario . "' ;";
		$this->connect();
		$validarAprobo = "0";
		$this->query($query, "class_moduloConferenciaDAO.php: fn_validarAprobadoEvaluacionCurso");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$validarAprobo = $row['aprobo'];
		} //Fin for
		/*if ($row){
			$validarAprobo = $row['aprobo'];
		}//Fin for*/
		$this->close_db();
		return $validarAprobo;
	}

	public function fn_validarFechaEvaluacionCurso($idModuloCurso, $idUsuario) {
		$query = "";
		$query = " SELECT DATE_FORMAT(cer.femodificacion, '%d %M %Y') as femodificacion FROM config_evaluaciones AS ce, conferencia_evaluacion_resultados AS cer ";
		$query .= " WHERE ce.porcentajeganar<=cer.dspuntuacion   AND ce.idconferencia=cer.idconferencia AND cer.idconferencia = $idModuloCurso AND cer.idusuario_web = $idUsuario ";

		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_validarFechaEvaluacionCurso");

		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$validarAprobo = $row['femodificacion'];
		} //Fin for
		$this->close_db();
		return $validarAprobo;
	}


	//Funcion de insercion de un modulo conferencia
	public function fn_ingresarIngresoConferenciaTecnico($idConferencia, $idUsuarioWeb, $country_code,  $country_name, $region_name, $city, $latitude,  $longitude, $ip, $agente, $navegador, $version, $platforma) {
		$navegador = $agente . ":::" . $navegador;
		$query = "INSERT INTO ingreso_conferencia_detalles_tecnicos VALUES ";
		$query .= "(NULL, " . $idUsuarioWeb . ", " . $idConferencia . ",'" . $ip . "','" . $country_code . "','" . $country_name . "','" . $region_name . "','" . $city . "','" . $latitude . "','" . $longitude . "','".$navegador."','" . $version . "','" . $platforma . "', NOW());";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarModulo");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} //Fin fn_ingresarModulo



	public function fn_ingresarRespuetaUsuarioPregunta($idconferencia, $idconferencia_evaluacion, $idconferencia_evaluacion_respuesta,  $idusuario) {
		$query = "INSERT INTO conferencia_evaluacion_respuestas_usuarios VALUES ";
		$query .= "(NULL, " .$idconferencia.",   " . $idconferencia_evaluacion . ", ".$idconferencia_evaluacion_respuesta.", ".$idusuario.", NOW());";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarRespuetaUsuarioPregunta");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} //Fin fn_ingresarModulo


	public function fn_validarNumeroEvaluacionesAprobadas($idUsuario) {
		$query = "";
		$query = " SELECT COUNT(*) AS total FROM conferencia_evaluacion_resultados WHERE idusuario_web=$idUsuario AND dspuntuacion>=90 AND (idconferencia=16 OR idconferencia=17 OR idconferencia=18 ) ";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_validarNumeroEvaluacionesAprobadas");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$validarAprobo = $row['total'];
		} //Fin for
		$this->close_db();
		return $validarAprobo;
	}


	public function fn_retornarUltimaEvaluacionConteo30($idConferencia, $idUsuario) {
		$query = "";
		$query = " SELECT COUNT(*)AS total
					FROM conferencia_evaluacion_resultados
					WHERE idconferencia=$idConferencia AND idusuario_web=$idUsuario AND femodificacion BETWEEN DATE_SUB(NOW(), INTERVAL 30 MINUTE) AND NOW() ";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarUltimaEvaluacionConteo30");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$validarAprobo = $row['total'];
		} //Fin for
		$this->close_db();
		return $validarAprobo;
	}






	public function fn_todasConferenciasModulosNiveles($idPadre, $idUsuario, $tipoUsuario, $nivel, $idioma = "") {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT idmodulo_conferencia,idmodulo_padre,dsnombre_modulo,dsdescripcion_modulo,dsruta_imagen_modulo,dstipo_visualizacion,dstiene_diploma,dsevaluacion_modulo,dsestado_menu_principal, nmposicion_menu_principal,dsestado_menu_superior,nmposicion_menu_superior,dsestado_inicio,nmposicion_inicio,fealta,febaja,idusuario_modificador,femodificacion ";
		$query .= "FROM modulo_conferencia" . $idioma . " ";
		if ($idPadre == "NULL") {
			$query .= "WHERE idmodulo_padre IS NULL ";
		} else {
			$nivel++;
			$query .= "WHERE idmodulo_padre = $idPadre ";
		}
		$query .= "AND fealta <= '" . $fechaActual . "' AND febaja >= '" . $fechaActual . "' ";
		$query .= "ORDER BY nmposicion_inicio ASC;";
		//return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_todasConferenciasModulosNiveles");
		$result = $this->result;
		for ($i = 0; $row = $this->fetch_array($result); $i++) {
			$moduloConferencia[$i]['idmodulo_conferencia']      =  $row['idmodulo_conferencia'];
			$moduloConferencia[$i]['idmodulo_padre']            =  $row['idmodulo_padre'];
			$moduloConferencia[$i]['dsnombre_modulo']           =  ($row['dsnombre_modulo']);
			$moduloConferencia[$i]['dsdescripcion_modulo']      =  ($row['dsdescripcion_modulo']);
			$moduloConferencia[$i]['dsruta_imagen_modulo']      =  $row['dsruta_imagen_modulo'];
			$moduloConferencia[$i]['dstipo_visualizacion']      =  $row['dstipo_visualizacion'];
			$moduloConferencia[$i]['dstiene_diploma']           =  $row['dstiene_diploma'];
			$moduloConferencia[$i]['dsevaluacion_modulo']       =  $row['dsevaluacion_modulo'];
			$moduloConferencia[$i]['dsestado_menu_principal']   =  $row['dsestado_menu_principal'];
			$moduloConferencia[$i]['nmposicion_menu_principal'] =  $row['nmposicion_menu_principal'];
			$moduloConferencia[$i]['dsestado_menu_superior']    =  $row['dsestado_menu_superior'];
			$moduloConferencia[$i]['nmposicion_menu_superior']  =  $row['nmposicion_menu_superior'];
			$moduloConferencia[$i]['dsestado_inicio']           =  $row['dsestado_inicio'];
			$moduloConferencia[$i]['nmposicion_inicio']         =  $row['nmposicion_inicio'];
			$moduloConferencia[$i]['fealta']                    =  $row['fealta'];
			$moduloConferencia[$i]['febaja']                    =  $row['febaja'];
			$moduloConferencia[$i]['idusuario_modificador']     =  $row['idusuario_modificador'];
			$moduloConferencia[$i]['femodificacion']            =  $row['femodificacion'];
			$moduloConferencia[$i]['nivel']					  =  $nivel;
			$moduloConferencia[$i]['hijos']            		  =  $this->fn_todasConferenciasModulosNiveles($row['idmodulo_conferencia'], $idUsuario, $tipoUsuario, $nivel);
			if ($tipoUsuario == "US") {
				$moduloConferencia[$i]['categorias']            =  $this->fn_leerModuloConferenciaCategoriaSegmento($row['idmodulo_conferencia']);
				$moduloConferencia[$i]['grupos']            	  =  $this->fn_leerModuloConferenciaPorCategoriasGruposUsuarios($row['idmodulo_conferencia']);
				$moduloConferencia[$i]['conferencias']          =  $this->fn_retornarConferenciasModulo($row['idmodulo_conferencia'], $idUsuario);
			}
		} //Fin if
		$this->close_db();
		return $moduloConferencia;
	}


	public function fn_retornarConferenciasModulo($iidModuloConferencia, $idUsuario) {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT cmc.idconferencia, c.dsnombre_conferencia, c.nmduracion_conferencia  ";
		$query .= "FROM conferencia_modulo_conferencia AS cmc, conferencia AS c ";
		$query .= "WHERE cmc.idmodulo_conferencia = $iidModuloConferencia AND c.idconferencia = cmc.idconferencia AND c.dsestado_conferencia='A' ";
		$query .= "AND feingreso <= '" . $fechaActual . "' AND febaja >= '" . $fechaActual . "' ";

		$query .= "ORDER BY cmc.nmposicion ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarConferenciasModulo");
		$this->close_db();
		$result = $this->result;
		$oidConferencias = [];
		for ($i = 0; $row = $this->fetch_array($result); $i++) {
			$oidConferencias[$i]['idconferencia'] = $row['idconferencia'];
			$oidConferencias[$i]['nmduracion_conferencia'] = $row['nmduracion_conferencia'];
			$oidConferencias[$i]['dsnombre_conferencia'] = ($row['dsnombre_conferencia']);
			$oidConferencias[$i]['visualizaciones'] = $this->fn_leerVisualizacionesConferencia($row['idconferencia'], $idUsuario);
			$oidConferencias[$i]['tieneeval'] = $this->fn_validarTieneEvaluacionCurso($row['idconferencia']);
			$oidConferencias[$i]['aprobo'] = $this->fn_validarAprobadoEvaluacionCurso($row['idconferencia'], $idUsuario);
			$oidConferencias[$i]['categorias'] = $this->fn_leerConferenciaPorCategorias($row['idconferencia']);
			$oidConferencias[$i]['ultimavista'] = $this->ultimaVisualizacionConferencia($row['idconferencia'], $idUsuario);
		} //Fin for
		return $oidConferencias;
	} //Fin fn_retornarConferenciasModulo

	public function fn_leerVisualizacionesConferencia($iidConferencia, $idUsuario) {
		$visualizaciones = 0;
		$query = "";
		$query = "SELECT count(*) as ingresos  FROM ingreso_conferencia ";
		$query .= "WHERE idconferencia = $iidConferencia AND idusuario_web = $idUsuario;";
		//return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerVisualizacionesConferencia");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$visualizaciones = $row['ingresos'];
		} //Fin for
		$this->close_db();
		return $visualizaciones;
	} //Fin fn_leerVisualizacionesConferencia


	// 20 abril
	public function fn_traerInformacionMensajesConeferencias($idconferencia) {
		$query = "";
		$query = "SELECT cm.idconferencia,cm.idmodulo,cm.idconferencia_sig,cm.idmodulo_sig,cm.idtema,cm.evaluacion,cm.momento ";
		$query .= "FROM conferencia_mensaje cm  ";
		$query .= "WHERE cm.idconferencia = $idconferencia;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_traerInformacionMensajesConeferencias");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia['idconferencia']     	=  $row['idconferencia'];
			$moduloConferencia['idmodulo']            =  $row['idmodulo'];
			$moduloConferencia['idconferencia_sig']   =  $row['idconferencia_sig'];
			$moduloConferencia['idmodulo_sig']      	=  $row['idmodulo_sig'];
			$moduloConferencia['idtema']           	=  $row['idtema'];
			$moduloConferencia['evaluacion']          =  $row['evaluacion'];
			$moduloConferencia['momento']       		=  $row['momento'];
		} //Fin for
		$this->close_db();
		return $moduloConferencia;
	} //Fin fn_traerInformacionMensajesConeferencias*/

	public function fn_traerInformacionModulosAnteriores($iidModuloConferencia) {
		$query = "";
		$query = "SELECT mc.dsnombre_modulo,mc.idmodulo_conferencia,mc.idmodulo_padre ";
		$query .= "FROM modulo_conferencia mc  ";
		$query .= "WHERE mc.idmodulo_conferencia = $iidModuloConferencia;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_traerInformacionMensajesConeferencias");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia['dsnombre_modulo']     =  ($row['dsnombre_modulo']);
			$moduloConferencia['idmodulo_conferencia'] =  $row['idmodulo_conferencia'];
			$moduloConferencia['idmodulo_padre']		=  $row['idmodulo_padre'];
			if ($row['idmodulo_padre'] != 0) {
				$moduloConferencia['hijos']         	=  $this->fn_traerInformacionModulosAnteriores($row['idmodulo_padre']);
			} else {
				$moduloConferencia['hijos'] 			= 0;
			}
		} //Fin for
		$this->close_db();
		return $moduloConferencia;
	} //Fin fn_traerInformacionModulosAnteriores


	function fn_traerInformacionModulosFecha($tipoOrden, $limite, $perfil, $segmento, $condicion, $idioma = "") {
		$fechaActual = date("Y-m-d");
		$query  = "SELECT DISTINCT mc.*, mci.*, mcn.*, uai.imagen, mcp.idperfil, mcs.idsegmento,count(ic.idingreso_conferencia) AS totalIng ";
		$query .= " FROM modulo_conferencia" . $idioma . " AS mc";
		$query .= " LEFT JOIN conferencia_modulo_conferencia AS cmc	ON mc.idmodulo_conferencia = cmc.idmodulo_conferencia";
		$query .= " LEFT JOIN conferencia AS c	ON c.idconferencia = cmc.idconferencia AND c.dsestado_conferencia='A' AND c.feingreso<= '$fechaActual' AND mc.febaja >= '$fechaActual'";
		$query .= " LEFT JOIN modulo_conferencia_informacion AS mci	ON mci.idmodulo = mc.idmodulo_conferencia  ";
		$query .= " LEFT JOIN usuarios_administradores AS ua ON ua.idusuario_administrador=mci.idadministrador";
		$query .= " LEFT JOIN usuarios_administradores_imagen AS uai ON uai.idusuario_administrador = mci.idadministrador ";
		$query .= "	LEFT JOIN modulo_conferencia_perfil AS mcp	ON mcp.idmodulo = mc.idmodulo_conferencia AND mcp.idperfil='$perfil' ";
		$query .= "	LEFT JOIN modulo_conferencia_segmento AS mcs ON mcs.idmodulo = mc.idmodulo_conferencia AND mcs.idsegmento='$segmento' ";
		$query .= " LEFT JOIN ingreso_conferencia AS ic ON ic.idconferencia = cmc.idconferencia";
		$query .= " LEFT JOIN modulo_conferencia_nivel_rel mcnr ON mc.idmodulo_conferencia = mcnr.idmodulo_conferencia";
		$query .= " LEFT JOIN modulo_conferencia_nivel mcn ON mcnr.idnivel = mcn.idnivel";
		$query .= " WHERE " . $condicion;
		$query .= " GROUP BY mc.idmodulo_conferencia ";
		if ($tipoOrden != "0") {
			$query .= "	ORDER BY " . $tipoOrden;
		}
		if ($limite != "0") {
			$query .= "	LIMIT 0," . $limite;
		}
		$this->connect();
	    $this->query($query, "class_moduloConferenciaDAO.php: fn_traerInformacionModulosFecha");
		$moduloConferencia = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[]   =  $row;
		} //Fin for
		$this->close_db();
		return $moduloConferencia;

	} //Fin fn_traerInformacionModulosAnteriores



	function fn_todasConferenciasModulosNivelesTipoVisualizacion($idPadre, $idUsuario, $tipoUsuario, $nivel, $idioma = "") {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT idmodulo_conferencia,idmodulo_padre,dsnombre_modulo,dsruta_imagen_modulo,dstipo_visualizacion,dstiene_diploma,dsevaluacion_modulo ";
		$query .= "FROM modulo_conferencia" . $idioma . " ";
		if ($idPadre == "NULL") {
			$query .= "WHERE idmodulo_padre IS NULL ";
		} else {
			$nivel++;
			$query .= "WHERE idmodulo_padre = $idPadre ";
		}
		$query .= "AND fealta <= '" . $fechaActual . "' AND febaja >= '" . $fechaActual . "' ";
		$query .= "ORDER BY nmposicion_inicio ASC;";
		//return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_todasConferenciasModulosNivelesTipoVisualizacion");
		$result = $this->result;
		for ($i = 0; $row = $this->fetch_array($result); $i++) {
			$moduloConferencia[$i]['idmodulo_conferencia']      =  $row['idmodulo_conferencia'];
			$moduloConferencia[$i]['idmodulo_padre']            =  $row['idmodulo_padre'];
			$moduloConferencia[$i]['dsnombre_modulo']           =  ($row['dsnombre_modulo']);
			$moduloConferencia[$i]['dsruta_imagen_modulo']      =  $row['dsruta_imagen_modulo'];
			$moduloConferencia[$i]['dstipo_visualizacion']      =  $row['dstipo_visualizacion'];
			$moduloConferencia[$i]['dstiene_diploma']           =  $row['dstiene_diploma'];
			$moduloConferencia[$i]['dsevaluacion_modulo']       =  $row['dsevaluacion_modulo'];
			$moduloConferencia[$i]['nivel']					  =  $nivel;
			$moduloConferencia[$i]['hijos']            		  =  $this->fn_todasConferenciasModulosNivelesTipoVisualizacion($row['idmodulo_conferencia'], $idUsuario, $tipoUsuario, $nivel, $idioma);
			if ($tipoUsuario == "US") {
				$moduloConferencia[$i]['categorias']            =  $this->fn_leerModuloConferenciaCategoriaSegmento($row['idmodulo_conferencia']);
				$moduloConferencia[$i]['grupos']            	  =  $this->fn_leerModuloConferenciaGrupoPerfil($row['idmodulo_conferencia']);
				$moduloConferencia[$i]['conferencias']          =  $this->fn_retornarInfoConferenciasModulo($row['idmodulo_conferencia'], $idUsuario, $idioma);
			}
		} //Fin if
		$this->close_db();
		return $moduloConferencia;
	}

	//Funcion de lectura de modulos por grupo de usuario asociado
	function fn_leerModuloConferenciaCategoriaSegmento($idmodulo) {
		$query = "";
		$query = "SELECT DISTINCT idsegmento FROM modulo_conferencia_segmento  ";
		$query .= " WHERE  	idmodulo = $idmodulo  ORDER BY idsegmento ;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerModuloConferenciaCategoriaSegmento");
		$categoriasConferenciaGrupos = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$categoriasConferenciaGrupos[$i] = $row['idsegmento'];
		} //Fin for
		$this->close_db();
		return $categoriasConferenciaGrupos;
	} //Fin fn_leerModuloConferenciaCategoriaSegmento

	function fn_leerModuloConferenciaCurso($idmodulo) {
		$query = "";
		$query = "SELECT idmodulo_conferencia FROM modulo_conferencia_preguntas_frecuentes_curso  ";
		$query .= " WHERE idpregunta = $idmodulo ORDER BY idpregunta;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerModuloConferenciaCurso");
		$categoriasConferenciaGrupos = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$categoriasConferenciaGrupos[$i]['idmodulo_conferencia'] = $row['idmodulo_conferencia'];
		} //Fin for
		$this->close_db();
		return $categoriasConferenciaGrupos;
	} //Fin fn_leerModuloConferenciaCurso

	//Funcion de lectura de modulos por grupo de usuario asociado
	function fn_leerModuloConferenciaGrupoPerfil($idmodulo) {
		$query = "";
		$query = "SELECT idperfil FROM  modulo_conferencia_perfil ";
		$query .= " WHERE  	idmodulo = $idmodulo  ORDER BY idperfil ;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerModuloConferenciaGrupoPerfil");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$categoriasConferenciaGrupos[$i] = $row['idperfil'];
		} //Fin for
		$this->close_db();
		return $categoriasConferenciaGrupos;
	} //Fin fn_leerModuloConferenciaGrupoPerfil




	function fn_retornarInfoConferenciasModulo($iidModuloConferencia, $idUsuario, $idioma = "") {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT cmc.idconferencia, c.dsnombre_conferencia , c.dsruta_imagen_conferencia, cr.ingreso, cr.evaluacion, cr.tarea, cr.ninguna  ";
		$query .= "FROM conferencia_modulo_conferencia AS cmc
		           LEFT JOIN conferencia" . $idioma . " AS c
		           ON c.idconferencia = cmc.idconferencia AND c.feingreso <= '" . $fechaActual . "' AND c.febaja >= '" . $fechaActual . "' AND c.dsestado_conferencia ='A'
		           LEFT JOIN conferencia_restricciones AS cr
		           ON cr.idconferencia = cmc.idconferencia ";
		$query .= "WHERE cmc.idmodulo_conferencia = $iidModuloConferencia ";
		$query .= "ORDER BY cmc.nmposicion, cmc.idconferencia DESC;";
		//return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarInfoConferenciasModulo");
		$result = $this->result;
		for ($i = 0; $row = $this->fetch_array($result); $i++) {
			$oidConferencias[$i]['idconferencia'] = $row['idconferencia'];
			$oidConferencias[$i]['dsnombre_conferencia'] = ($row['dsnombre_conferencia']);
			$oidConferencias[$i]['dsruta_imagen_conferencia'] = $row['dsruta_imagen_conferencia'];
			$oidConferencias[$i]['restriccion']['ingreso'] = "";
			$oidConferencias[$i]['restriccion']['evaluacion'] = "";
			$oidConferencias[$i]['restriccion']['tarea'] = "";
			$oidConferencias[$i]['restriccion']['ninguna'] = "S";
			if ($row['ninguna'] != "S") {
				$oidConferencias[$i]['restriccion']['ninguna'] = "N";
				if ($row['ingreso'] == "S") {
					$oidConferencias[$i]['restriccion']['ingreso']['obligatorio'] = "S";
					$oidConferencias[$i]['restriccion']['ingreso']['cumplido'] = $this->fn_leerVisualizacionesConferencia($row['idconferencia'], $idUsuario);
				}
				if ($row['evaluacion'] == "S") {
					$oidConferencias[$i]['restriccion']['evaluacion']['obligatorio'] = "S";
					$oidConferencias[$i]['restriccion']['evaluacion']['cumplido'] = $this->fn_validarAprobadoEvaluacionCurso($row['idconferencia'], $idUsuario);
				}

				if ($row['tarea'] == "S") {
					$oidConferencias[$i]['restriccion']['tarea']['obligatorio'] = "S";
					$oidConferencias[$i]['restriccion']['tarea']['cumplido'] = $this->fn_validarTareasConferenciaTerminada($row['idconferencia'], $idUsuario);
				}
			}
		} //Fin for
		$this->close_db();
		return $oidConferencias;
	} //Fin fn_retornarConferenciasModulo

	function fn_validarTareasConferenciaTerminada($idConferencia, $idUsuario) {
		$query = "";
		$query = "SELECT t.id_tarea, t.obligatorio,  tu.calificacion ";
		$query .= "FROM tarea t LEFT JOIN tareaxusuario tu ON t.id_tarea= tu.id_tarea AND tu.idusuario_web = $idUsuario ";
		$query .= "WHERE t.id_conferencia = $idConferencia; ";
		//return $query;
		$this->connect();
		$this->query($query, "class_tareasDAO.php: fn_validarTareasConferenciaTerminada");
		$result = $this->result;
		for ($i = 0; $row = $this->fetch_array($result); $i++) {
			$totalTareas[$i]['id_tarea'] = $row['id_tarea'];
			$totalTareas[$i]['obligatorio'] = $row['obligatorio'];
			$totalTareas[$i]['calificacion'] = $row['calificacion'];
		}
		$this->close_db();
		return $totalTareas;
	}

	function fn_porcentajeConferenciaSegmento($idPadre, $idUsuario, $tipoUsuario, $nivel, $orden, $segmento, $condicion) {
		$fechaActual = date("Y-m-d");
		$query = "SELECT mc.idmodulo_conferencia,mc.idmodulo_padre,mc.dsnombre_modulo,mc.dsdescripcion_modulo,mc.dsruta_imagen_modulo,mc.dstipo_visualizacion,mc.dstiene_diploma,mc.dsevaluacion_modulo,mc.dsestado_menu_principal,mc.nmposicion_menu_principal,mc.dsestado_menu_superior,mc.nmposicion_menu_superior,mc.dsestado_inicio,mc.nmposicion_inicio,mc.fealta,mc.febaja,mc.idusuario_modificador,mc.femodificacion, cm.idmodulo cmidmodulo, cm.idcertificado,cer.dspuntuacion cerdspuntuacion,ce.porcentajeganar ceporcentajeganar,cr.ingreso cringreso,cr.evaluacion crevaluacion, cr.tarea crtarea,t.notaxaprobar,t.id_conferencia tid_conferencia, mci.duracion, mci.parametros, mci.notificar, tu.calificacion tucalificacion ";
		//    $query = "SELECT mc.idmodulo_conferencia,mc.idmodulo_padre,mc.dsnombre_modulo,mc.dsdescripcion_modulo,mc.dsruta_imagen_modulo,mc.dstipo_visualizacion,mc.dstiene_diploma,mc.dsevaluacion_modulo,mc.dsestado_menu_principal,mc.nmposicion_menu_principal,mc.dsestado_menu_superior,mc.nmposicion_menu_superior,mc.dsestado_inicio,mc.nmposicion_inicio,mc.fealta,mc.febaja,mc.idusuario_modificador,mc.femodificacion, cm.idmodulo cmidmodulo, cm.idcertificado,cer.dspuntuacion cerdspuntuacion,ce.porcentajeganar ceporcentajeganar,cr.ingreso cringreso,cr.evaluacion crevaluacion, cr.tarea crtarea ";
		$query .= "FROM modulo_conferencia as mc ";
		$query .= " LEFT JOIN modulo_conferencia_informacion AS mci	ON mci.idmodulo = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN certificado_modulos AS cm ON cm.idmodulo = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN config_evaluaciones AS ce ON ce.idconferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN conferencia_evaluacion_resultados AS cer ON cer.idconferencia = ce.idconferencia ";
		$query .= "LEFT JOIN conferencia_restricciones AS cr ON cr.idconferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN conferencia_modulo_conferencia AS cmc ON cmc.idmodulo_conferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN modulo_conferencia_segmento AS mcs ON mcs.idmodulo = mc.idmodulo_conferencia AND mcs.idsegmento='$segmento' ";

		$query .= "LEFT JOIN tarea AS t ON t.id_conferencia = cmc.idconferencia ";
		$query .= "LEFT JOIN tareaxusuario AS tu ON tu.id_tarea = t.id_tarea ";
		if ($idPadre == "NULL") {
			$query .= " WHERE idmodulo_padre IS NULL " . $condicion;
		} else {
			$nivel++;
			$query .= " WHERE idmodulo_padre = $idPadre " . $condicion;
		}
		$query .= " GROUP BY mc.idmodulo_conferencia ";
		$query .= " ORDER BY " . $orden;
		//return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_porcentajeConferencia");
		$result = $this->result;
		$this->close_db();
		for ($i = 0; $row = $this->fetch_array($result); $i++) {
			$moduloConferencia[$i]['idmodulo_conferencia'] = $row['idmodulo_conferencia'];
			$moduloConferencia[$i]['idmodulo_padre'] = $row['idmodulo_padre'];
			$moduloConferencia[$i]['dsruta_imagen_modulo'] = $row['dsruta_imagen_modulo'];
			$moduloConferencia[$i]['duracion'] = $row['duracion'];
			$moduloConferencia[$i]['parametros'] = $row['parametros'];
			$moduloConferencia[$i]['dsnombre_modulo'] = ($row['dsnombre_modulo']);
			$moduloConferencia[$i]['idcerticado'] = ($row['idcertificado']);
			$moduloConferencia[$i]['ceporcentajeganar'] = ($row['ceporcentajeganar']);
			$moduloConferencia[$i]['cerdspuntuacion'] = ($row['cerdspuntuacion']);
			$moduloConferencia[$i]['cringreso'] = ($row['cringreso']);
			$moduloConferencia[$i]['crevaluacion'] = ($row['crevaluacion']);
			$moduloConferencia[$i]['crtarea'] = ($row['crtarea']);
			$moduloConferencia[$i]['notaxaprobar'] = ($row['notaxaprobar']);
			$moduloConferencia[$i]['notaxaprobar'] = ($row['tid_conferencia']);
			$moduloConferencia[$i]['notaxaprobar'] = ($row['tucalificacion']);
			$moduloConferencia[$i]['notificar'] = ($row['notificar']);
			$moduloConferencia[$i]['nivel'] = $nivel;
			$moduloConferencia[$i]['hijos'] = $this->fn_porcentajeConferencia($row['idmodulo_conferencia'], $idUsuario, $tipoUsuario, $nivel, $orden);
			if ($tipoUsuario == "US") {
				//        $moduloConferencia[$i]['categorias'] = $this->fn_leerModuloConferenciaPorCategoriasGrupos($row['idmodulo_conferencia']);
				//        $moduloConferencia[$i]['grupos'] = $this->fn_leerModuloConferenciaPorCategoriasGruposUsuarios($row['idmodulo_conferencia']);
				$moduloConferencia[$i]['conferencias'] = $this->fn_retornarConferenciasModulo($row['idmodulo_conferencia'], $idUsuario);
			}
		} //Fin if
		return $moduloConferencia;
	}


	function fn_porcentajeConferencia($idPadre, $idUsuario, $tipoUsuario, $nivel, $orden) {
		$fechaActual = date("Y-m-d");
		$query  = "SELECT mc.*, cm.idmodulo, cm.idcertificado, cer.dspuntuacion, ce.porcentajeganar, cr.ingreso, cr.evaluacion, cr.tarea, t.notaxaprobar, t.id_conferencia, mci.duracion, mci.parametros, mci.notificar, tu.calificacion ";
		$query .= "FROM modulo_conferencia as mc ";
		$query .= "LEFT JOIN modulo_conferencia_informacion AS mci	ON mci.idmodulo = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN certificado_modulos AS cm ON cm.idmodulo = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN config_evaluaciones AS ce ON ce.idconferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN conferencia_evaluacion_resultados AS cer ON cer.idconferencia = ce.idconferencia ";
		$query .= "LEFT JOIN conferencia_restricciones AS cr ON cr.idconferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN conferencia_modulo_conferencia AS cmc ON cmc.idmodulo_conferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN tarea AS t ON t.id_conferencia = cmc.idconferencia ";
		$query .= "LEFT JOIN tareaxusuario AS tu ON tu.id_tarea = t.id_tarea ";
		if ($idPadre == "NULL") {
			$query .= "WHERE idmodulo_padre IS NULL AND mci.notificar='CR' ";
		} else {
			$nivel++;
			$query .= "WHERE idmodulo_padre = $idPadre ";
		}
		$query .= "AND mc.fealta <= '" . $fechaActual . "' AND mc.febaja >= '" . $fechaActual . "' ";
		$query .= "GROUP BY mc.idmodulo_conferencia ";
		$query .= "ORDER BY " . $orden;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_porcentajeConferencia");
		$result = $this->result;
		$this->close_db();
		$moduloConferencia = [];
		for ($i = 0; $row = $this->fetch_array($result); $i++) {
			$moduloConferencia[$i]['idmodulo_conferencia'] 	= $row['idmodulo_conferencia'];
			$moduloConferencia[$i]['idmodulo_padre'] 		= $row['idmodulo_padre'];
			$moduloConferencia[$i]['dsruta_imagen_modulo'] 	= $row['dsruta_imagen_modulo'];
			$moduloConferencia[$i]['duracion'] 				= $row['duracion'];
			$moduloConferencia[$i]['precio'] 				= $row['precio'];
			$moduloConferencia[$i]['parametros'] 			= $row['parametros'];
			$moduloConferencia[$i]['notificar'] 			= $row['notificar'];
			$moduloConferencia[$i]['dsnombre_modulo'] 		= ($row['dsnombre_modulo']);
			$moduloConferencia[$i]['dsdescripcion_modulo'] 	= ($row['dsdescripcion_modulo']);
			$moduloConferencia[$i]['idcerticado'] 			= ($row['idcertificado']);
			$moduloConferencia[$i]['ceporcentajeganar'] 	= ($row['porcentajeganar']);
			$moduloConferencia[$i]['cerdspuntuacion'] 		= ($row['dspuntuacion']);
			$moduloConferencia[$i]['cringreso'] 			= ($row['ingreso']);
			$moduloConferencia[$i]['crevaluacion'] 			= ($row['evaluacion']);
			$moduloConferencia[$i]['crtarea'] 				= ($row['tarea']);
			$moduloConferencia[$i]['notaxaprobar'] 			= ($row['notaxaprobar']);
			$moduloConferencia[$i]['notaxaprobar'] 			= ($row['id_conferencia']);
			$moduloConferencia[$i]['notaxaprobar'] 			= ($row['calificacion']);
			$moduloConferencia[$i]['nivel'] 				= $nivel;
			$moduloConferencia[$i]['hijos'] 				= $this->fn_porcentajeConferencia($row['idmodulo_conferencia'], $idUsuario, $tipoUsuario, $nivel, $orden);
			if ($tipoUsuario == "US") {
				//        $moduloConferencia[$i]['categorias'] = $this->fn_leerModuloConferenciaPorCategoriasGrupos($row['idmodulo_conferencia']);
				//        $moduloConferencia[$i]['grupos'] = $this->fn_leerModuloConferenciaPorCategoriasGruposUsuarios($row['idmodulo_conferencia']);
				$moduloConferencia[$i]['conferencias'] = $this->fn_retornarConferenciasModulo($row['idmodulo_conferencia'], $idUsuario);
			}
		} //Fin if
		return $moduloConferencia;
	}

	function fn_porcentajeConferenciaSerie($idPadre, $idUsuario, $tipoUsuario, $nivel, $orden) {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT mc.idmodulo_conferencia,mc.idmodulo_padre,mc.dsnombre_modulo,mc.dsdescripcion_modulo,mc.dsruta_imagen_modulo,mc.dstipo_visualizacion,mc.dstiene_diploma,mc.dsevaluacion_modulo,mc.dsestado_menu_principal,mc.nmposicion_menu_principal,mc.dsestado_menu_superior,mc.nmposicion_menu_superior,mc.dsestado_inicio,mc.nmposicion_inicio,mc.fealta,mc.febaja,mc.idusuario_modificador,mc.femodificacion, cm.idmodulo cmidmodulo, cm.idcertificado,cer.dspuntuacion cerdspuntuacion,ce.porcentajeganar ceporcentajeganar,cr.ingreso cringreso,cr.evaluacion crevaluacion, cr.tarea crtarea,t.notaxaprobar,t.id_conferencia tid_conferencia, mci.duracion, mci.parametros, tu.calificacion tucalificacion ";
		$query .= "FROM modulo_conferencia as mc ";
		$query .= " LEFT JOIN modulo_conferencia_informacion AS mci	ON mci.idmodulo = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN certificado_modulos AS cm ON cm.idmodulo = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN config_evaluaciones AS ce ON ce.idconferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN conferencia_evaluacion_resultados AS cer ON cer.idconferencia = ce.idconferencia ";
		$query .= "LEFT JOIN conferencia_restricciones AS cr ON cr.idconferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN conferencia_modulo_conferencia AS cmc ON cmc.idmodulo_conferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN tarea AS t ON t.id_conferencia = cmc.idconferencia ";
		$query .= "LEFT JOIN tareaxusuario AS tu ON tu.id_tarea = t.id_tarea ";
		if ($idPadre == "NULL") {
			$query .= "WHERE idmodulo_padre IS NULL AND mci.notificar='SW' ";
		} else {
			$nivel++;
			$query .= "WHERE idmodulo_padre = $idPadre ";
		}
		$query .= "GROUP BY mc.idmodulo_conferencia ";
		$query .= "ORDER BY " . $orden;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_porcentajeConferenciaSerie");
		$result = $this->result;
		$queryError = $this->conn->error;
		$this->close_db();
		if($queryError){
			throw new Exception('No fue posible cargar las series WEB (c_mCD-QE-AWcQdY) '.$queryError);
		}else{
			$moduloConferencia = [];
			for ($i = 0; $row = $this->fetch_array($result); $i++) {
				$moduloConferencia[$i]['idmodulo_conferencia']  = $row['idmodulo_conferencia'];
				$moduloConferencia[$i]['idmodulo_padre'] 		= $row['idmodulo_padre'];
				$moduloConferencia[$i]['dsruta_imagen_modulo']  = $row['dsruta_imagen_modulo'];
				$moduloConferencia[$i]['duracion'] 				= $row['duracion'];
				$moduloConferencia[$i]['parametros'] 			= $row['parametros'];
				$moduloConferencia[$i]['dsnombre_modulo'] 		= ($row['dsnombre_modulo']);
				$moduloConferencia[$i]['idcerticado'] 			= ($row['idcertificado']);
				$moduloConferencia[$i]['ceporcentajeganar'] 	= ($row['ceporcentajeganar']);
				$moduloConferencia[$i]['cerdspuntuacion'] 		= ($row['cerdspuntuacion']);
				$moduloConferencia[$i]['cringreso'] 			= ($row['cringreso']);
				$moduloConferencia[$i]['crevaluacion'] 			= ($row['crevaluacion']);
				$moduloConferencia[$i]['crtarea'] 				= ($row['crtarea']);
				$moduloConferencia[$i]['notaxaprobar'] 			= ($row['notaxaprobar']);
				$moduloConferencia[$i]['notaxaprobar'] 			= ($row['tid_conferencia']);
				$moduloConferencia[$i]['notaxaprobar'] 			= ($row['tucalificacion']);
				$moduloConferencia[$i]['nivel'] 				= $nivel;
				$moduloConferencia[$i]['hijos'] = $this->fn_porcentajeConferencia($row['idmodulo_conferencia'], $idUsuario, $tipoUsuario, $nivel, $orden);
				if ($tipoUsuario == "US") {
					$moduloConferencia[$i]['conferencias'] = $this->fn_retornarConferenciasModulo($row['idmodulo_conferencia'], $idUsuario);
				}
			}//endfor
			return $moduloConferencia;
		}
	}


	function fn_porcentajeConferenciaVariable($idPadre, $idUsuario, $tipoUsuario, $nivel, $orden, $condicion) {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT mc.idmodulo_conferencia,mc.idmodulo_padre,mc.dsnombre_modulo,mc.dsdescripcion_modulo,mc.dsruta_imagen_modulo,mc.dstipo_visualizacion,mc.dstiene_diploma,mc.dsevaluacion_modulo,mc.dsestado_menu_principal,mc.nmposicion_menu_principal,mc.dsestado_menu_superior,mc.nmposicion_menu_superior,mc.dsestado_inicio,mc.nmposicion_inicio,mc.fealta,mc.febaja,mc.idusuario_modificador,mc.femodificacion, cm.idmodulo cmidmodulo, cm.idcertificado,cer.dspuntuacion cerdspuntuacion,ce.porcentajeganar ceporcentajeganar,cr.ingreso cringreso,cr.evaluacion crevaluacion, cr.tarea crtarea,t.notaxaprobar,t.id_conferencia tid_conferencia, mci.duracion, mci.parametros, tu.calificacion tucalificacion ";
		//    $query = "SELECT mc.idmodulo_conferencia,mc.idmodulo_padre,mc.dsnombre_modulo,mc.dsdescripcion_modulo,mc.dsruta_imagen_modulo,mc.dstipo_visualizacion,mc.dstiene_diploma,mc.dsevaluacion_modulo,mc.dsestado_menu_principal,mc.nmposicion_menu_principal,mc.dsestado_menu_superior,mc.nmposicion_menu_superior,mc.dsestado_inicio,mc.nmposicion_inicio,mc.fealta,mc.febaja,mc.idusuario_modificador,mc.femodificacion, cm.idmodulo cmidmodulo, cm.idcertificado,cer.dspuntuacion cerdspuntuacion,ce.porcentajeganar ceporcentajeganar,cr.ingreso cringreso,cr.evaluacion crevaluacion, cr.tarea crtarea ";
		$query .= "FROM modulo_conferencia as mc ";
		$query .= " LEFT JOIN modulo_conferencia_informacion AS mci	ON mci.idmodulo = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN certificado_modulos AS cm ON cm.idmodulo = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN config_evaluaciones AS ce ON ce.idconferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN conferencia_evaluacion_resultados AS cer ON cer.idconferencia = ce.idconferencia ";
		$query .= "LEFT JOIN conferencia_restricciones AS cr ON cr.idconferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN conferencia_modulo_conferencia AS cmc ON cmc.idmodulo_conferencia = mc.idmodulo_conferencia ";
		$query .= "LEFT JOIN tarea AS t ON t.id_conferencia = cmc.idconferencia ";
		$query .= "LEFT JOIN tareaxusuario AS tu ON tu.id_tarea = t.id_tarea ";
		if ($idPadre == "NULL") {
			$query .= "WHERE mc.idmodulo_padre IS NULL " . $condicion;
		} else {
			$nivel++;
			$query .= "WHERE mc.idmodulo_padre = $idPadre ";
		}
		$query .= "GROUP BY mc.idmodulo_conferencia ";
		$query .= "ORDER BY " . $orden;
		//return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_porcentajeConferencia");
		$result = $this->result;
		$this->close_db();
		$moduloConferencia = [];
		for ($i = 0; $row = $this->fetch_array($result); $i++) {
			$moduloConferencia[$i]['idmodulo_conferencia'] 	= $row['idmodulo_conferencia'];
			$moduloConferencia[$i]['idmodulo_padre'] 		= $row['idmodulo_padre'];
			$moduloConferencia[$i]['dsruta_imagen_modulo'] 	= $row['dsruta_imagen_modulo'];
			$moduloConferencia[$i]['duracion'] 				= $row['duracion'];
			$moduloConferencia[$i]['parametros'] 			= $row['parametros'];
			$moduloConferencia[$i]['dsnombre_modulo'] 		= $row['dsnombre_modulo'];
			$moduloConferencia[$i]['idcerticado'] 			= $row['idcertificado'];
			$moduloConferencia[$i]['ceporcentajeganar'] 	= $row['ceporcentajeganar'];
			$moduloConferencia[$i]['cerdspuntuacion'] 		= $row['cerdspuntuacion'];
			$moduloConferencia[$i]['cringreso'] 			= $row['cringreso'];
			$moduloConferencia[$i]['crevaluacion'] 			= $row['crevaluacion'];
			$moduloConferencia[$i]['crtarea'] 				= $row['crtarea'];
			$moduloConferencia[$i]['notaxaprobar'] 			= $row['notaxaprobar'];
			$moduloConferencia[$i]['notaxaprobar'] 			= $row['tid_conferencia'];
			$moduloConferencia[$i]['notaxaprobar'] 			= $row['tucalificacion'];
			$moduloConferencia[$i]['nivel'] 				= $nivel;
			$moduloConferencia[$i]['hijos'] = $this->fn_porcentajeConferencia($row['idmodulo_conferencia'], $idUsuario, $tipoUsuario, $nivel, $orden);
			if ($tipoUsuario == "US") {

				$moduloConferencia[$i]['conferencias'] = $this->fn_retornarConferenciasModulo($row['idmodulo_conferencia'], $idUsuario);
			}
		} //Fin if
		return $moduloConferencia;
	}


	function fn_porcentajeConferenciaVariablePadre($idPadre, $idUsuario, $tipoUsuario, $nivel, $orden, $condicion) {
		$fechaActual = date("Y-m-d");
		$query = "SELECT mc.*, cm.idmodulo, cm.idcertificado ";
		$query .= "FROM modulo_conferencia as mc ";
		$query .= "LEFT JOIN certificado_modulos AS cm ON cm.idmodulo = mc.idmodulo_conferencia ";
		if ($idPadre == "NULL") {
			$query .= "WHERE mc.idmodulo_padre IS NULL " . $condicion;
		} else {
			$nivel++;
			$query .= "WHERE mc.idmodulo_padre = $idPadre " . $condicion;
		}
		$query .= "GROUP BY mc.idmodulo_conferencia ";
		$query .= "ORDER BY " . $orden;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_porcentajeConferencia");
		$result = $this->result;
		$this->close_db();
		$moduloConferencia =[];
		for ($i = 0; $row = $this->fetch_array($result); $i++) {
			$moduloConferencia[$i]['idmodulo_conferencia'] 	= $row['idmodulo_conferencia'];
			$moduloConferencia[$i]['idmodulo_padre'] 		= $row['idmodulo_padre'];
			$moduloConferencia[$i]['dsruta_imagen_modulo'] 	= $row['dsruta_imagen_modulo'];
			$moduloConferencia[$i]['dsnombre_modulo'] 		= $row['dsnombre_modulo'];
			$moduloConferencia[$i]['idcerticado'] 			= $row['idcertificado'];
			$moduloConferencia[$i]['categoriasmodpadre'] = $this->fn_leerModuloConferenciaCategoriaSegmento($idPadre);
			$moduloConferencia[$i]['categoriasmodhijos'] = $this->fn_leerModuloConferenciaCategoriaSegmento($row['idmodulo_conferencia']);
			if ($tipoUsuario == "US") {
				$moduloConferencia[$i]['conferencias'] = $this->fn_retornarConferenciasModulo($row['idmodulo_conferencia'], $idUsuario);
			}
		} //Fin if
		return $moduloConferencia;
	}


	function fn_retornarConferenciasModulo2($iidModuloConferencia) {

		$query = "SELECT cmc.idconferencia, c.dsnombre_conferencia  ";
		$query .= "FROM conferencia_modulo_conferencia AS cmc, conferencia AS c ";
		$query .= "WHERE cmc.idmodulo_conferencia = $iidModuloConferencia AND c.idconferencia = cmc.idconferencia ";
		$query .= "ORDER BY cmc.nmposicion ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarConferenciasModulo2");
		$oidConferencias = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oidConferencias[$i]['idconferencia'] = $row['idconferencia'];
			$oidConferencias[$i]['dsnombre_conferencia'] = ($row['dsnombre_conferencia']);
		} //Fin for
		$this->close_db();
		return $oidConferencias;
	}

	function fn_contenidoFavorito($idModulo, $idUsuario) {
		$query = "";
		$query = "SELECT idContenido_favorito FROM contenido_favorito ";
		$query .= "WHERE idusuario_web = $idUsuario AND idmodulo_conferencia = $idModulo;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_contenidoFavorito");
		$row = $this->fetch_array($this->result);
		if ($row) {
			$favorito = true;
		} //Fin if
		else {
			$favorito = false;
		} //Fin else
		$this->close_db();
		return $favorito;
	}

	function add_contenidoFavorito($idModulo, $idUsuario) {

		$query = "";
		$query = "INSERT INTO contenido_favorito VALUES ";
		$query .= "('','" . $idUsuario . "', '" . $idModulo . "',NOW());";

		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: add_contenidoFavorito");
		$idFavoritoAdd = $this->last_insert();
		if ($idFavoritoAdd) {
			$favorito = true;
		} //Fin if
		else {
			$favorito = false;
		} //Fin else

		$this->close_db();
		return $idFavoritoAdd;
	}

	function remove_contenidoFavorito($idModulo, $idUsuario) {
		$query = "DELETE FROM contenido_favorito ";
		$query .= "WHERE idusuario_web = $idUsuario AND idmodulo_conferencia = $idModulo;";
		$this->connect();
		if ($this->query($query, "class_moduloConferenciaDAO.php: remove_contenidoFavorito")) {
			$favorito = true;
		} //Fin if
		else {
			$favorito = false;
		} //Fin else
		$this->close_db();
		return $favorito;
	}

	function fn_todasConferenciasModulosNivelesNotificaciones($idPadre, $idUsuario, $tipoUsuario, $nivel) {
		$fechaActual = date("Y-m-d");

		$query = "";
		$query = "SELECT DISTINCT idmodulo_conferencia,idmodulo_padre,dsnombre_modulo,dsdescripcion_modulo,dsruta_imagen_modulo,dstipo_visualizacion,dstiene_diploma,dsevaluacion_modulo,dsestado_menu_principal, nmposicion_menu_principal,dsestado_menu_superior,nmposicion_menu_superior,dsestado_inicio,nmposicion_inicio,fealta,febaja,idusuario_modificador,femodificacion,nc.idmodulo as modulo,ncc1.estado as estado1,ncc2.estado as estado2,ncc3.estado as estado3,ncc4.estado as estado4 ";
		$query .= "FROM modulo_conferencia ";
		$query .= "LEFT JOIN notificaciones_contenido nc ON(idmodulo_conferencia = nc.idmodulo) ";
		$query .= "LEFT JOIN notificaciones_contenido_configuracion ncc1 ON(nc.idnotificacion = ncc1.idnotificacion AND ncc1.tipo = 1) ";
		$query .= "LEFT JOIN notificaciones_contenido_configuracion ncc2 ON(nc.idnotificacion = ncc2.idnotificacion AND ncc2.tipo = 2) ";
		$query .= "LEFT JOIN notificaciones_contenido_configuracion ncc3 ON(nc.idnotificacion = ncc3.idnotificacion AND ncc3.tipo = 3) ";
		$query .= "LEFT JOIN notificaciones_contenido_configuracion ncc4 ON(nc.idnotificacion = ncc4.idnotificacion AND ncc4.tipo = 4) ";
		if ($idPadre == "NULL") {
			$query .= "WHERE idmodulo_padre IS NULL ";
		} else {
			$nivel++;
			$query .= "WHERE idmodulo_padre = $idPadre ";
		}
		$query .= "AND fealta <= '" . $fechaActual . "' AND febaja >= '" . $fechaActual . "' ";
		$query .= "GROUP BY idmodulo_conferencia ";
		$query .= "ORDER BY nmposicion_inicio ASC ";


		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_todasConferenciasModulosNiveles");
		$result = $this->result;
		for ($i = 0; $row = $this->fetch_array($result); $i++) {
			$moduloConferencia[$i]['idmodulo_conferencia']      =  $row['idmodulo_conferencia'];
			$moduloConferencia[$i]['idmodulo_padre']            =  $row['idmodulo_padre'];
			$moduloConferencia[$i]['dsnombre_modulo']           =  ($row['dsnombre_modulo']);
			$moduloConferencia[$i]['dsdescripcion_modulo']      =  ($row['dsdescripcion_modulo']);
			$moduloConferencia[$i]['dsruta_imagen_modulo']      =  $row['dsruta_imagen_modulo'];
			$moduloConferencia[$i]['dstipo_visualizacion']      =  $row['dstipo_visualizacion'];
			$moduloConferencia[$i]['dstiene_diploma']           =  $row['dstiene_diploma'];
			$moduloConferencia[$i]['dsevaluacion_modulo']       =  $row['dsevaluacion_modulo'];
			$moduloConferencia[$i]['dsestado_menu_principal']   =  $row['dsestado_menu_principal'];
			$moduloConferencia[$i]['nmposicion_menu_principal'] =  $row['nmposicion_menu_principal'];
			$moduloConferencia[$i]['dsestado_menu_superior']    =  $row['dsestado_menu_superior'];
			$moduloConferencia[$i]['nmposicion_menu_superior']  =  $row['nmposicion_menu_superior'];
			$moduloConferencia[$i]['dsestado_inicio']           =  $row['dsestado_inicio'];
			$moduloConferencia[$i]['nmposicion_inicio']         =  $row['nmposicion_inicio'];
			$moduloConferencia[$i]['fealta']                    =  $row['fealta'];
			$moduloConferencia[$i]['febaja']                    =  $row['febaja'];
			$moduloConferencia[$i]['idusuario_modificador']     =  $row['idusuario_modificador'];
			$moduloConferencia[$i]['femodificacion']            =  $row['femodificacion'];
			$moduloConferencia[$i]['configurado']               =  $row['modulo'];
			$moduloConferencia[$i]['estado1']                    =  $row['estado1'];
			$moduloConferencia[$i]['estado2']                    =  $row['estado2'];
			$moduloConferencia[$i]['estado3']                    =  $row['estado3'];
			$moduloConferencia[$i]['estado4']                    =  $row['estado4'];
			$moduloConferencia[$i]['configuraciones']           =  $this->fn_retornarConfiguracionModulo($row['idmodulo_conferencia']);
			$moduloConferencia[$i]['nivel']					  =  $nivel;
			$moduloConferencia[$i]['hijos']            		  =  $this->fn_todasConferenciasModulosNivelesNotificaciones($row['idmodulo_conferencia'], $idUsuario, $tipoUsuario, $nivel);
			if ($tipoUsuario == "US") {
				$moduloConferencia[$i]['categorias']            =  $this->fn_leerModuloConferenciaPorCategoriasGrupos($row['idmodulo_conferencia']);
				$moduloConferencia[$i]['grupos']            	  =  $this->fn_leerModuloConferenciaPorCategoriasGruposUsuarios($row['idmodulo_conferencia']);
				$moduloConferencia[$i]['conferencias']          =  $this->fn_retornarConferenciasModuloNombre($row['idmodulo_conferencia'], $idUsuario);
			}
		}
		//return "ai";
		//Fin if
		$this->close_db();
		return $moduloConferencia;
	}

	// Retornas los idnotificación del modulo correspondiente
	function fn_retornarConfiguracionModulo($idModulo) {
		$query = "";
		$query = "SELECT idnotificacion  ";
		$query .= "FROM notificaciones_contenido  ";
		$query .= "WHERE idmodulo = $idModulo ";

		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarConfiguracionModulo");
		$res = $this->result;
		for ($i = 0; $row = $this->fetch_array($res); $i++) {
			$oidConferencias[$i]['idnotificacion'] = $row['idnotificacion'];
		} //Fin for
		$this->close_db();
		return $oidConferencias;
	} //Fin fn_retornarConfiguracionModulo

	function fn_retornarConferenciasModuloNombre($iidModuloConferencia, $idUsuario) {
		$query = "";
		$query = "SELECT DISTINCT mc.idconferencia, c.dsnombre_conferencia as nombre, ce.idconferencia as eval, nc.idconferencia as notificacion,ncc1.estado as estado1,ncc2.estado as estado2,ncc3.estado as estado3,ncc4.estado as estado4 ";
		$query .= "FROM conferencia_modulo_conferencia mc ";
		$query .= "INNER JOIN conferencia c ON(c.idconferencia = mc.idconferencia)  ";
		$query .= "LEFT JOIN config_evaluaciones ce ON(ce.idconferencia = mc.idconferencia)  ";
		$query .= "LEFT JOIN notificaciones_contenido nc ON(nc.idconferencia = mc.idconferencia)  ";
		$query .= "LEFT JOIN notificaciones_contenido_configuracion ncc1 ON(nc.idnotificacion = ncc1.idnotificacion AND ncc1.tipo = 1) ";
		$query .= "LEFT JOIN notificaciones_contenido_configuracion ncc2 ON(nc.idnotificacion = ncc2.idnotificacion AND ncc2.tipo = 2) ";
		$query .= "LEFT JOIN notificaciones_contenido_configuracion ncc3 ON(nc.idnotificacion = ncc3.idnotificacion AND ncc3.tipo = 3) ";
		$query .= "LEFT JOIN notificaciones_contenido_configuracion ncc4 ON(nc.idnotificacion = ncc4.idnotificacion AND ncc4.tipo = 4) ";
		$query .= "WHERE idmodulo_conferencia = $iidModuloConferencia AND c.dsestado_conferencia = 'A' ";
		$query .= "GROUP BY mc.idconferencia ";
		$query .= "ORDER BY nmposicion ASC ";

		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarConferenciasModulo");
		$resu = $this->result;
		for ($i = 0; $row = $this->fetch_array($resu); $i++) {
			$oidConferencias[$i]['evaluacion']        = $row['eval'];
			$oidConferencias[$i]['configurado']       = $row['notificacion'];
			$oidConferencias[$i]['idconferencia']     = $row['idconferencia'];
			$oidConferencias[$i]['nombreConferencia'] = ($row['nombre']);
			$oidConferencias[$i]['estado1']         =  $row['estado1'];
			$oidConferencias[$i]['estado2']         =  $row['estado2'];
			$oidConferencias[$i]['estado3']         =  $row['estado3'];
			$oidConferencias[$i]['estado4']         =  $row['estado4'];
			$oidConferencias[$i]['configuraciones'] =  $this->fn_retornarConfiguracionConferencia($row['idconferencia']);
			//$oidConferencias[$i][eval] = $row['eval'];
			//$oidConferencias[$i]['visualizaciones'] = $this->fn_leerVisualizacionesConferencia2($row['idconferencia'], $idUsuario);
		} //Fin for
		$this->close_db();
		return $oidConferencias;
	} //Fin fn_retornarConferenciasModulo

	// Retornas los idnotificación del Conferencia correspondiente
	function fn_retornarConfiguracionConferencia($idconferencia) {
		$query = "";
		$query = "SELECT idnotificacion  ";
		$query .= "FROM notificaciones_contenido  ";
		$query .= "WHERE idconferencia = $idconferencia ";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarConfiguracionConferencia");
		$oidConferencias=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oidConferencias[$i]['idnotificacion'] = $row['idnotificacion'];
		} //Fin for
		$this->close_db();
		return $oidConferencias;
	} //Fin fn_retornarConfiguracionConferencia

	/*Funcion consultar partes del modulo*/
	function fn_cantidadPartes($idModuloConferencia) {
		$query = "";
		$query = "SELECT count(idconferencia) as cantidadPartes FROM conferencia_modulo_conferencia ";
		$query .= "WHERE idmodulo_conferencia = $idModuloConferencia;";
		// return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_cantidadPartes");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$cantidadPartes = $row['cantidadPartes'];
		} //Fin for
		$this->close_db();
		return $cantidadPartes;
	} //Fin fn_cantidadPartes


	/*Funcion consultar Restricciones*/
	function fn_consultarRestricciones($idModuloConferencia, $idRutaUser) {
		$query = "";
		$query = "SELECT restricciones as restricciones FROM ruta_datos ";
		$query .= "WHERE idmodulo_conferencia = $idModuloConferencia ";
		$query .= " AND idruta IN ($idRutaUser);";
		// return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_consultarRestricciones");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloRestricciones = $row['restricciones'];
		} //Fin for
		$this->close_db();
		return $moduloRestricciones;
	} //Fin fn_consultarRestricciones


	/*Funcion consultar Avanzar*/
	function fn_consultarAvanzar($idModuloConferencia, $idRutaUser) {
		$query = "";
		$query = "SELECT DISTINCT idmodulo_conferencia as siguiente FROM ruta_datos ";
		// $query .= "WHERE restricciones LIKE '%$idModuloConferencia%' ";
		$query .= "WHERE restricciones = '$idModuloConferencia' ";
		$query .= " AND idruta IN ($idRutaUser);";
		// return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_consultarAvanzar");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloRestricciones[$i] = $row['siguiente'];
		} //Fin for
		$this->close_db();
		return $moduloRestricciones;
	} //Fin Avanzar


	/*Funcion consultar Avanzar*/
	function fn_consultarModuloConferencia($idconferencia) {
		$query = "";
		$query = "SELECT mc.dsdescripcion_modulo as descripcion FROM modulo_conferencia as mc INNER JOIN conferencia_modulo_conferencia as cmc on mc.idmodulo_conferencia = cmc.idmodulo_conferencia ";
		$query .= "WHERE cmc.idconferencia = $idconferencia;";
		// return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_consultarModuloConferencia");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia = $row['descripcion'];
		} //Fin for
		$this->close_db();
		return $moduloConferencia;
	} //Fin Avanzar

	/*Funcion consultar Avanzar*/
	function fn_consultarModuloPerteneceConferencia($idconferencia) {
		$query = "";
		$query = "SELECT DISTINCT mc.idmodulo_conferencia, mc.idmodulo_padre, mc.dsdescripcion_modulo as descripcion, mc.dsnombre_modulo FROM modulo_conferencia as mc INNER JOIN conferencia_modulo_conferencia as cmc on mc.idmodulo_conferencia = cmc.idmodulo_conferencia ";
		$query .= "WHERE cmc.idconferencia = $idconferencia;";
		// return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_consultarModuloConferencia");
		$moduloConferencia = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia['idmodulo_conferencia'] = $row['idmodulo_conferencia'];
			$moduloConferencia['idmodulo_padre'] = $row['idmodulo_padre'];
			$moduloConferencia['dsnombre_modulo'] = ($row['dsnombre_modulo']);
		} //Fin for
		$this->close_db();
		return $moduloConferencia;
	} //Fin Avanzar



	function fn_leerPromediomeGustaConferencia($conferencia) {
		$query = "";
		$query = "SELECT AVG(estado) AS promedio ";
		$query .= " FROM usuarios_web_conferencias_megusta ";
		$query .= " WHERE idconferencia =" . $conferencia . " ";
		$query .= "GROUP BY idconferencia;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerPromediomeGustaConferencia");
		$row = $this->fetch_array($this->result);
		$promedio = null;
		if ($row) {
			$promedio = $row['promedio'];
		}
		$this->close_db();
		return $promedio;
	}

	function fn_leerPromediomeGustaConferenciaReview($conferencias) {
		$query = "SELECT estado, count(*) AS total FROM usuarios_web_conferencias_megusta
		WHERE idconferencia IN(" . $conferencias . ")
		GROUP BY estado ORDER BY estado DESC ";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerPromediomeGustaConferenciaReview");
		$resu = $this->result;
		$totalMegusta = [];
		for ($i = 0; $row = $this->fetch_array($resu); $i++) {
			$totalMegusta[$i]['estado'] = $row['estado'];
			$totalMegusta[$i]['total']  = $row['total'];
		} //Fin for
		$this->close_db();
		return $totalMegusta;
	}

	function fn_leerConferenciaReviewValoraciones($conferencias, $condicion) {
		$query = "SELECT mg.valoracion, mg.fecha, uw.idusuario_web, uw.dsnombre_completo, uwrs.imagen
				  FROM usuarios_web_conferencias_megusta_texto AS mg, usuarios_web AS uw, usuarios_web_vista_red_social AS uwrs
				  WHERE mg.idconferencia IN(" . $conferencias . ") " . $condicion . " AND mg.idusuario_web= uw.idusuario_web AND uwrs.idusuario_web= uw.idusuario_web
		          ORDER BY mg.fecha DESC
				 -- LIMIT 0,20
				 ";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerConferenciaReviewValoraciones");
		$resu = $this->result;
		$totalMegusta = [];
		for ($i = 0; $row = $this->fetch_array($resu); $i++) {
			$totalMegusta[$i]['idusuario_web'] 		= $row['idusuario_web'];
			$totalMegusta[$i]['imagen'] 			= $row['imagen'];
			$totalMegusta[$i]['dsnombre_completo']  = $row['dsnombre_completo'];
			$totalMegusta[$i]['valoracion'] 		= $row['valoracion'];
			$totalMegusta[$i]['fecha']  			= $row['fecha'];
		} //Fin for
		$this->close_db();
		return $totalMegusta;
	}

	function fn_ingresarOpinion_cursoCompletado($idConferencia, $idUsuario, $valoracion) {
		$query = "INSERT INTO usuarios_web_conferencias_megusta_texto  VALUES ('', '$idUsuario', '$idConferencia',  '$valoracion', '1', NOW());";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarOpinion_cursoCompletado");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} //Fin fn_ingresarModulo

	function fn_ingresarApunteConferencia($idConferencia, $idUsuario, $apunte) {
		$query = "";
		$query = "INSERT INTO usuarios_web_conferencias_apuntes  VALUES ('', '$idUsuario', '$idConferencia',  '$apunte', '1', '1', NOW());";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarApunteConferencia");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} //Fin fn_ingresarModulo

	function fn_leerConferenciaApuntesUsuario($conferencia, $idUsuario) {
		$query = "";
		$query = "SELECT apunte, param, fecha FROM usuarios_web_conferencias_apuntes
						WHERE idconferencia=" . $conferencia . " AND idusuario_web= " . $idUsuario . " AND activo=1 ";
		$query .= " ORDER BY fecha DESC  ";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerConferenciaApuntesUsuario");
		$totalMegusta=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$totalMegusta[$i]['apunte'] = ($row['apunte']);
			$totalMegusta[$i]['param'] = $row['param'];
			$totalMegusta[$i]['fecha'] = $row['fecha'];
		} //Fin for
		$this->close_db();
		return $totalMegusta;
	}


	//Función que se encarga de validar si ha superado evaluación para generar certificado
	function fn_validarTieneEvaluacionCurso($idConferencia) {
		$query = "";
		$query = " SELECT COUNT(id) AS tieneeval FROM config_evaluaciones ";
		$query .= " WHERE idconferencia='" . $idConferencia . "' AND numeropreguntas>0 GROUP BY idconferencia ;";
		$this->connect();
		$validarAprobo = 0;
		$this->query($query, "class_moduloConferenciaDAO.php: fn_validarTieneEvaluacionCurso");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$validarAprobo = $row['tieneeval'];
		}
		$this->close_db();
		return $validarAprobo;
	}

	//Funcion de lectura de modulos por grupo de usuario asociado
	function fn_leerModuloConferenciaInformacion($idmodulo) {
		$query = "SELECT * FROM  modulo_conferencia_informacion ";
		$query .= " WHERE idmodulo = $idmodulo";
		$this->connect();
		$this->query($query, "class_modulosDAO.php: fn_leerModuloConferenciaGrupoPerfil");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloInformacion['textoinfo']   = $row['textoinfo'];
			$moduloInformacion['temaodivi']   = $row['temaodivi'];
			$moduloInformacion['destacado']   = $row['destacado'];
			$moduloInformacion['composicion'] = $row['composicion'];
			$moduloInformacion['duracion']    = $row['duracion'];
			$moduloInformacion['notificar']   = $row['notificar'];
			$moduloInformacion['metas']   = $row['metas'];
			$moduloInformacion['parametros']   = $row['parametros'];
		} //Fin for
		$this->close_db();
		return $moduloInformacion;
	} //Fin fn_leerModuloConferenciaGrupoPerfil

	function fn_modificarModulo_informacion($iidmodulo, $arrayInformacion, $iidUsuarioModificador, $idioma = "") {

		$query = "";
		$query .= "UPDATE modulo_conferencia_informacion" . $idioma . " SET ";
		$query .= " idadministrador='$iidUsuarioModificador', textoinfo='" . $arrayInformacion['contenido'] . "', metas='" . $arrayInformacion['metas'] . "', ";
		$query .= " temaodivi='" . $arrayInformacion['tema'] . "', destacado='" . $arrayInformacion['destacado'] . "', composicion='" . $arrayInformacion['composicion'] . "', duracion='" . $arrayInformacion['duracion']["duracion"] . '###' . $arrayInformacion['duracion']["descDuracion"] . "', notificar='" . $arrayInformacion['notificar'] . "', parametros='" . $arrayInformacion['modalidad']["modalidad"] . '###' . $arrayInformacion['modalidad']["descModalidad"]."' ";
		$query .= " WHERE idmodulo=$iidmodulo";
		// return $query;
		$this->connect();
		$this->query($query, "class_modulosDAO.php: fn_ingresarModulo_informacion");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} //Fin fn_ingresarModulo

	function fn_eliminarModulo_perfil($idModulo) {
		$query = "";
		$query .= "DELETE FROM modulo_conferencia_perfil ";
		$query .= "WHERE idmodulo = $idModulo; ";
		$this->connect();
		$this->query($query, "class_usuariosDAO.php: fn_eliminarTodasCategoriasUsuario");
		$this->close_db();
	} //Fin fn_eliminarCategoriaUsuario

	function fn_eliminarModulo_segmento($idModulo) {
		$query = "";
		$query .= "DELETE FROM modulo_conferencia_segmento ";
		$query .= "WHERE idmodulo = $idModulo; ";
		$this->connect();
		$this->query($query, "class_usuariosDAO.php: fn_eliminarTodasCategoriasUsuario");
		$this->close_db();
	} //Fin fn_eliminarCategoriaUsuario

	function fn_eliminarPreguntaCurso($idPregunta) {
		$query = "";
		$query .= "DELETE FROM modulo_conferencia_preguntas_frecuentes_curso ";
		$query .= "WHERE idpregunta = $idPregunta;";
		$this->connect();
		$this->query($query, "class_usuariosDAO.php: fn_eliminarTodasCategoriasUsuario");
		$this->close_db();
	} //Fin fn_eliminarCategoriaUsuario


	function fn_traerInformacionBuscador($paramBusqueda, $orden = 0, $limite = 0) {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = " SELECT DISTINCT mc.idmodulo_conferencia, mc.idmodulo_padre, mc.dsnombre_modulo
					FROM modulo_conferencia AS mc
					LEFT JOIN conferencia_modulo_conferencia AS cmc ON mc.idmodulo_conferencia = cmc.idmodulo_conferencia
					LEFT JOIN conferencia AS c  ON c.idconferencia = cmc.idconferencia AND c.dsestado_conferencia='A' AND c.feingreso<= '$fechaActual' AND mc.febaja > '$fechaActual'
					LEFT JOIN modulo_conferencia_informacion AS mci ON mci.idmodulo = mc.idmodulo_conferencia
					WHERE mc.fealta<= '$fechaActual' AND mc.febaja > '$fechaActual' AND ( mc.dsnombre_modulo LIKE '%" . $paramBusqueda . "%'  OR mc.dsdescripcion_modulo LIKE '%" . $paramBusqueda . "%' OR mci.parametros  LIKE '%" . $paramBusqueda . "%' OR  mci.metas  LIKE '%" . $paramBusqueda . "%' OR c.dsnombre_conferencia LIKE '%" . $paramBusqueda . "%' OR c.dsautor_conferencia LIKE '%" . $paramBusqueda . "%' OR c.dscomentario_conferencia LIKE '%" . $paramBusqueda . "%') ";
		$query .= " GROUP BY mc.idmodulo_conferencia ";
		if ($orden != "0") {
			$query .= "	ORDER BY " . $orden;
		}
		if ($limite != "0") {
			$query .= "	LIMIT 0," . $limite;
		}
		//return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_traerInformacionModulosFecha");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[$i]['idmodulo_conferencia']     =  $row['idmodulo_conferencia'];
			$moduloConferencia[$i]['idmodulo_padre']     		 =  $row['idmodulo_padre'];
			$moduloConferencia[$i]['dsnombre_modulo']     	 =  ($row['dsnombre_modulo']);
		} //Fin for
		$this->close_db();
		//return $query;
		return $moduloConferencia;
	} //Fin fn_traerInformacionModulosAnteriores


	function ultimaVisualizacionConferencia($iidConferencia, $idUsuario) {
		$visualizaciones = 0;
		$query = "";
		$query = "SELECT feingreso FROM ingreso_conferencia WHERE idconferencia = $iidConferencia AND idusuario_web = $idUsuario ORDER BY ingreso_conferencia.feingreso DESC LIMIT 0,1 ;";
		//return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerVisualizacionesConferencia");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$visualizaciones = $row['feingreso'];
		} //Fin for
		$this->close_db();
		return $visualizaciones;
	} //Fin fn_leerVisualizacionesConferencia


	function fn_ingresarModulo_cursoCompletado($idModulo, $idUsuario, $certifica) {
		$query = "";
		$query = "INSERT INTO modulo_conferencia_completado  VALUES ('', '$idModulo', '$idUsuario', '$certifica', NOW());";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarModulo_cursoCompletado");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} //Fin fn_ingresarModulo


	function fn_ingresarInfo_navegacion($info, $var, $val, $param, $idUsuario) {
		$query = "INSERT INTO usuarios_web_visitanavegacion VALUES(NULL, '$info', '$var', '$val', '$param', $idUsuario, NOW());";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarInfo_navegacion");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} //Fin fn_ingresarModulo


	function ultimaVisualizacionConferenciasModulosCursos($idUsuario) {
		$query = "SELECT DISTINCT ic.idconferencia, cmc.idmodulo_conferencia, mc.idmodulo_padre
		FROM ingreso_conferencia AS ic,
		conferencia_modulo_conferencia AS cmc,
		modulo_conferencia AS mc,
		modulo_conferencia_informacion AS mci
		WHERE ic.idusuario_web= $idUsuario AND ic.idconferencia=cmc.idconferencia
		AND mc.idmodulo_conferencia=cmc.idmodulo_conferencia AND mc.idmodulo_conferencia=mci.idmodulo
		AND mci.notificar='CR' -- Seleccionar solo cursos
		ORDER BY ic.idingreso_conferencia DESC";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: ultimaVisualizacionConferenciasModulosCursos");
		$visualizaciones = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$visualizaciones['idconferencia'][$i] = $row['idconferencia'];
			$visualizaciones['idmodulo_conferencia'][$i] = $row['idmodulo_conferencia'];
			$visualizaciones['idmodulo_padre'][$i] = $row['idmodulo_padre'];
		} //Fin for
		$this->close_db();
		return $visualizaciones;
	} //Fin fn_leerVisualizacionesConferencia

	//Retornar todos los modulos de un canal
	function fn_retornarTodosModulosCanalPorFechaPublicacion() {
		$fechaActual = date("Y-m-d");
		$query = "";
		$query = "SELECT idmodulo_conferencia ";
		$query .= "FROM modulo_conferencia ";
		$query .= "WHERE idmodulo_padre IS NULL ";
		$query .= "AND fealta <= '$fechaActual' AND febaja >= '$fechaActual' ";
		$query .= " ORDER BY femodificacion, idmodulo_conferencia DESC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarTodosModulosCanalPorFechaPublicacion");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosModulosCanal[$i] = $row['idmodulo_conferencia'];
		} //Fin for
		$this->close_db();
		return $oCodigosModulosCanal;
	} //Fin

	function fn_retornarTodosModulosCanalDestacados($idCurso) {
		$query = "";
		$query = "SELECT DISTINCT mc.idmodulo_conferencia, mc.dsnombre_modulo, mc.dsdescripcion_modulo, mc.dsruta_imagen_modulo FROM modulo_conferencia mc 
		LEFT JOIN modulo_conferencia_informacion mci ON mc.idmodulo_conferencia = mci.idmodulo 
		LEFT JOIN modulo_conferencia_destacados_rel mcdr ON mc.idmodulo_conferencia = mcdr.idmodulo_conferencia
		WHERE mc.idmodulo_padre IS NULL ";
		if(is_numeric($idCurso)){
			$query .= "AND mcdr.iddestacado = $idCurso AND mcdr.iddestacado != mcdr.idmodulo_conferencia GROUP BY mc.idmodulo_conferencia ORDER BY mc.nmposicion_inicio;";
		}else{
			$query .= "GROUP BY mc.idmodulo_conferencia ORDER BY mc.nmposicion_inicio;";
		}
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarTodosModulosCanalDestacados");
		$queryError = $this->conn->error;
		$this->close_db();
		if($queryError){
		throw new Exception('No fue posible obtener la información de los destacados (c_mCSOUE-QF-8AeriHv)');
		}else{
		$oCodigosModulosCanal = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosModulosCanal[$i] = $row;
		}
		return $oCodigosModulosCanal;
	}
	} //Fin

	function fn_retornarTodosModulosCanalMasCompletados() {
		$query = "";
		$query = "SELECT idmodulo, count(*) as total FROM modulo_conferencia_completado group by idmodulo order by total DESC ";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarTodosModulosCanalMasCompletados");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosModulosCanal[$i] = $row['idmodulo'];
		} //Fin for
		$this->close_db();
		return $oCodigosModulosCanal;
	} //Fin

	function fn_retornarTodosModulosCanalMasCompletadosUsuario($idUsuario) {
		$query = "";
		$query = "SELECT idmodulo, count(*) as total FROM modulo_conferencia_completado where idusuario_web=$idUsuario group by idmodulo order by total DESC ";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarTodosModulosCanalMasCompletadosUsuario");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosModulosCanal[$i] = $row['idmodulo'];
		} //Fin for
		$this->close_db();
		return $oCodigosModulosCanal;
	} //Fin


	function fn_retornarTodosModulosCanalMasNavegados() {
		$query = "";
		$query = "SELECT valor, count(*) total FROM usuarios_web_visitanavegacion WHERE informacionget='curso' AND variable='idcurso' GROUP BY valor ORDER BY total DESC ";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarTodosModulosCanalMasNavegados");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosModulosCanal[$i] = $row['valor'];
		} //Fin for
		$this->close_db();
		return $oCodigosModulosCanal;
	} //Fin

	function fn_retornarTodosModulosCanalMasNavegadosUsuario($idUsuario) {
		$query = "";
		$query = "SELECT valor, count(*) total FROM usuarios_web_visitanavegacion WHERE informacionget='curso' AND variable='idcurso' AND idusuario_web=$idUsuario GROUP BY valor ORDER BY total DESC ";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarTodosModulosCanalMasNavegadosUsuario");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$oCodigosModulosCanal[$i] = $row['valor'];
		} //Fin for
		$this->close_db();
		return $oCodigosModulosCanal;
	} //Fin

	function informacionCapitulosModulosSeries($condicion = "") {
		$query = "";
		$query = "SELECT DISTINCT ccps.idconferencia, cmc.idmodulo_conferencia, mc.idmodulo_padre, ccps.idconferencia, ccps.embed, ccps.tipochat, ccps.chat, ccps.tiempominimo, ccps.fechavivo, ccps.horavivo, ccps.destacado, ccps.estado, ccps.param, c.dsnombre_conferencia, c.dsautor_conferencia, c.dsruta_imagen_conferencia FROM conferencia_capitulo_serie AS ccps
		INNER JOIN conferencia AS c
		ON c.idconferencia=ccps.idconferencia
		LEFT JOIN conferencia_modulo_conferencia AS cmc
		ON ccps.idconferencia=cmc.idconferencia
		LEFT JOIN modulo_conferencia AS mc
		ON mc.idmodulo_conferencia=cmc.idmodulo_conferencia  ";
		if ($condicion != "admin") {
			$query .= " WHERE  " . $condicion;
		}
		$query .= " ORDER BY ccps.idconferencia DESC";
		//return $query;
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: informacionCapitulosModulosSeries");
		$texto = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$texto[$i]['idconferencia'] = $row['idconferencia'];
			$texto[$i]['idmodulo_conferencia'] = $row['idmodulo_conferencia'];
			$texto[$i]['idmodulo_padre'] = $row['idmodulo_padre'];
			$texto[$i]['embed'] = $row['embed'];
			$texto[$i]['tipochat'] = $row['tipochat'];
			$texto[$i]['chat'] = $row['chat'];
			$texto[$i]['tiempominimo'] = $row['tiempominimo'];
			$texto[$i]['fechavivo'] = $row['fechavivo'];
			$texto[$i]['horavivo'] = ($row['horavivo']);
			$texto[$i]['destacado'] = $row['destacado'];
			$texto[$i]['estado'] = $row['estado'];
			$texto[$i]['param'] = ($row['param']);
			$texto[$i]['dsnombre_conferencia'] = ($row['dsnombre_conferencia']);
			$texto[$i]['dsautor_conferencia'] = ($row['dsautor_conferencia']);
			$texto[$i]['dsruta_imagen_conferencia'] = ($row['dsruta_imagen_conferencia']);
			if ($condicion != "admin") {
				$texto[$i]['categorias']   =  $this->fn_leerConferenciaPorCategorias($row['idconferencia']);
				if ($row['idmodulo_conferencia'] != 0) {
					$texto[$i]['infoModulo']   =  $this->fn_leerModuloConferencia($row['idmodulo_conferencia']);
					$texto[$i]['infoPadreM']   =  $this->fn_leerModuloConferencia($row['idmodulo_padre']);
				}
			}
		} //Fin for
		$this->close_db();
		return $texto;
	} //Fin fn_leerVisualizacionesConferencia

	/**
	 * @method obtener listado con id de los módulos hijos en consulta
	 * @return array
	 */
	function fn_obtenerIDModulosHijos($idModuloPadre) {
		$fechaActual = date("Y-m-d");
		$query = "SELECT idmodulo_conferencia, dsnombre_modulo
				  FROM  modulo_conferencia WHERE idmodulo_padre = $idModuloPadre
				  AND fealta <= '$fechaActual' AND febaja >= '$fechaActual' ";
		$this->connect();
		$this->query($query, "class_conferenciaDAO.php: fn_obtenerIDModulosHijos");
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$idModulos[$i]['idmodulo_conferencia'] =  $row['idmodulo_conferencia'];
			$idModulos[$i]['dsnombre_modulo'] =  ($row['dsnombre_modulo']);
		} //Fin for
		$this->close_db();
		return $idModulos;
	}

	/**
	 * @method obtener array con la información completa de cada curso y del comportamiento del usuario en el curso
	 *  	  * El campo likeAverage contiene el promedio de "me gusta" del curso
	 * 		  * El campo submodulos contiene los id de los módulos que componen al curso, separados por comas (,) --Esta info puede convertirse en array en la vista hacido uso de la función xplode()
	 * 		  * El campo conferencias contiene los id's de las conferencias separados por comas (,) ordenado por la posición de cada conferencia en el módulo que compone al curso --Esta info puede convertirse en array en la vista hacido uso de la función xplode()
	 * 		  * Los campos contenidos_vistos y curso_comprado se pondrán como "false" si el usario no ha iniciado sesión
	 * 		  * El campo contenidos_vistos se ordena por fechas de ingreso en forma descendente (desde la fecha más reciente hacia atrás)
	 * 		  * El campo contenidos_vistos contiene los id's de las conferencias completadas por el usuario separados por comas (,) 
	 * 		  * Los listados de conferencias y submodulos (modulos que componen al curso) se filtran con las categorías del usuario (cuando este ha iniciado sesión)
	 * 		  * Si el usuario inició sesión solo se listarán los cursos que hacen parte de las categorías del usuario
	 * 		  * Solo se listarán los cursos que tengan al menos una conferencia y módulo activo y con fecha vigente (fecha de alta y fecha de baja)
	 *		  * En conferencias se concatena el idconferencia con dsnombre_conferencia creando un pseudo-objeto. Dada la limitación en la sentencia en vez de comillas dobles se establece [*]. En el código se puede reemplazar esto por comillas para generar un objeto y posteriormente un array cuyos indices serán los idconferencias y los nombres serán sus valores
	 * @param $idusaurio => si el usuairo no ha iniciado sesión el dato será "false"
	 * @return array
	 * 03-02-2023-yl
	 */
	public function obtenerinfoCompletaCursos($idusuario, $numerolimitIni, $numerolimitFin){
		$fechaActual = date("Y-m-d");
		$query ="SELECT mcp.*, mci.*, 
				-- Promedio 'Me gusta' de cada curso
				(SELECT IFNULL(ROUND(AVG(uwcm.estado), 1), 0) 
					FROM usuarios_web_conferencias_megusta AS uwcm
					INNER JOIN conferencia_modulo_conferencia AS cmc ON uwcm.idconferencia = cmc.idconferencia
					INNER JOIN modulo_conferencia AS mc ON cmc.idmodulo_conferencia = mc.idmodulo_conferencia
					WHERE mc.idmodulo_padre = mcp.idmodulo_conferencia
				) AS likeAverage,
			
				-- Listado de id's de los modulos del curso
				(SELECT GROUP_CONCAT(sub.idmodulo_conferencia ORDER BY sub.idmodulo_conferencia ASC)
					FROM modulo_conferencia AS sub
					WHERE sub.idmodulo_padre = mcp.idmodulo_conferencia
					AND  sub.fealta <= '$fechaActual' AND sub.febaja >= '$fechaActual' ";
				
			if($idusuario){   
		$query .="## Usuario con sesión iniciada
				  ## Validar que los submodulos (modulos hijos) estén en la misma categoría del usuario
					AND (SELECT uwc.idcategoria FROM usuarios_web_categorias AS uwc
					INNER JOIN modulo_conferencia_segmento AS mcs ON uwc.idcategoria = mcs.idsegmento
					WHERE uwc.idusuario_web = $idusuario AND mcs.idmodulo = sub.idmodulo_conferencia LIMIT 1
					) IS NOT NULL ";
			}//endif			
		$query .=") AS submodulos, 
					
				  ## Listado de id's de las conferencias del curso
				  (SELECT CONCAT('[', GROUP_CONCAT(CONCAT('{[*]idconferencia[*]:[*]', c.idconferencia,'[*],[*]dsnombre_conferencia[*]:[*]',c.dsnombre_conferencia,'[*]}') ORDER BY mc.idmodulo_conferencia, mc.nmposicion_inicio, cmc.nmposicion ASC),']')
					FROM conferencia AS c
					INNER JOIN conferencia_modulo_conferencia AS cmc ON c.idconferencia = cmc.idconferencia 
					INNER JOIN modulo_conferencia AS mc ON cmc.idmodulo_conferencia = mc.idmodulo_conferencia
					WHERE c.dsestado_conferencia = 'A'
					AND c.feingreso <= '$fechaActual' AND c.febaja >= '$fechaActual'
					AND mc.fealta <= '$fechaActual' AND mc.febaja >= '$fechaActual'
					AND mc.idmodulo_padre = mcp.idmodulo_conferencia ";
			if($idusuario){ 
		$query .="## Usuario con sesión iniciada
				  ## Validar que las conferencias tengan las mismas categoría del usuario
				    AND (SELECT uwc.idcategoria FROM usuarios_web_categorias AS uwc
					    INNER JOIN conferencia_categoria AS cc ON uwc.idcategoria = cc.idcategoria
						WHERE uwc.idusuario_web = $idusuario AND cc.idconferencia = c.idconferencia LIMIT 1
					) IS NOT NULL ";
			}//endif
		$query .=") AS conferencias,

				## Listado de id's de las conferencias que tienen evaluación en el curso
				(SELECT GROUP_CONCAT(c.idconferencia ORDER BY mc.idmodulo_conferencia, mc.nmposicion_inicio, cmc.nmposicion ASC)
					FROM conferencia AS c
					INNER JOIN conferencia_modulo_conferencia AS cmc ON c.idconferencia = cmc.idconferencia 
					INNER JOIN modulo_conferencia AS mc ON cmc.idmodulo_conferencia = mc.idmodulo_conferencia
					INNER JOIN config_evaluaciones AS ce ON c.idconferencia = ce.idconferencia
					WHERE c.dsestado_conferencia = 'A'
					AND c.feingreso <= '$fechaActual' AND c.febaja >= '$fechaActual'
					AND mc.fealta <= '$fechaActual' AND mc.febaja >= '$fechaActual'
					AND mc.idmodulo_padre = mcp.idmodulo_conferencia ";
			if($idusuario){ 
		$query .="## Usuario con sesión iniciada
					## Validar que las conferencias tengan las mismas categoría del usuario
					AND (SELECT uwc.idcategoria FROM usuarios_web_categorias AS uwc
						INNER JOIN conferencia_categoria AS cc ON uwc.idcategoria = cc.idcategoria
						WHERE uwc.idusuario_web = $idusuario AND cc.idconferencia = c.idconferencia LIMIT 1
					) IS NOT NULL ";
			}//endif
		$query .=") AS conferencias_evaluaciones ";

	if($idusuario){ 			
		$query .="## Usuario con sesión iniciada
					,(SELECT GROUP_CONCAT(DISTINCT ic.idconferencia ORDER BY ic.feingreso DESC) FROM ingreso_conferencia AS ic
						INNER JOIN conferencia_modulo_conferencia AS cmc ON ic.idconferencia = cmc.idconferencia
						INNER JOIN modulo_conferencia AS mc ON cmc.idmodulo_conferencia = mc.idmodulo_conferencia
						WHERE ic.idusuario_web = $idusuario 
						AND (SELECT dsestado_conferencia FROM conferencia WHERE idconferencia = ic.idconferencia) = 'A'
						AND mc.fealta <= '$fechaActual' AND mc.febaja >= '$fechaActual'
						AND mc.idmodulo_padre = mcp.idmodulo_conferencia
					
						## Validar que los contenidos vistos pertenezcan a las categorías del usuario
						AND (SELECT uwc.idcategoria FROM usuarios_web_categorias AS uwc
							INNER JOIN conferencia_categoria AS cc ON uwc.idcategoria = cc.idcategoria
							WHERE uwc.idusuario_web = $idusuario AND cc.idconferencia = ic.idconferencia LIMIT 1
						) IS NOT NULL
					) AS contenidos_vistos,
			
					(SELECT GROUP_CONCAT(DISTINCT ic.idconferencia) FROM ingreso_conferencia AS ic
						INNER JOIN conferencia_modulo_conferencia AS cmc ON ic.idconferencia = cmc.idconferencia
						INNER JOIN modulo_conferencia AS mc ON cmc.idmodulo_conferencia = mc.idmodulo_conferencia
						INNER JOIN config_evaluaciones AS ce ON ic.idconferencia = ce.idconferencia
						INNER JOIN conferencia_evaluacion_resultados AS cer ON ic.idconferencia = cer.idconferencia AND cer.dspuntuacion >= ce.porcentajeganar
						WHERE ic.idusuario_web = $idusuario 
						AND (SELECT dsestado_conferencia FROM conferencia WHERE idconferencia = ic.idconferencia) = 'A'
						AND mc.fealta <= '$fechaActual' AND mc.febaja >= '$fechaActual'
						AND mc.idmodulo_padre = mcp.idmodulo_conferencia
					
						## Validar que los contenidos vistos  pertenezcan a las categorías del usuario
						AND (SELECT uwc.idcategoria FROM usuarios_web_categorias AS uwc
							INNER JOIN conferencia_categoria AS cc ON uwc.idcategoria = cc.idcategoria
							WHERE uwc.idusuario_web = $idusuario AND cc.idconferencia = ic.idconferencia LIMIT 1
						) IS NOT NULL
					) AS evaluaciones_realizadas,

					(SELECT ic.feingreso FROM ingreso_conferencia AS ic
						INNER JOIN conferencia_modulo_conferencia AS cmc ON ic.idconferencia = cmc.idconferencia
						INNER JOIN modulo_conferencia AS mc ON cmc.idmodulo_conferencia = mc.idmodulo_conferencia
						WHERE ic.idusuario_web = $idusuario 
						AND (SELECT dsestado_conferencia FROM conferencia WHERE idconferencia = ic.idconferencia) = 'A'
						AND mc.fealta <= '$fechaActual' AND mc.febaja >= '$fechaActual'
						AND mc.idmodulo_padre = mcp.idmodulo_conferencia
					
						## Validar que los contenidos vistos pertenezcan a las categorías del usuario
						AND (SELECT uwc.idcategoria FROM usuarios_web_categorias AS uwc
							INNER JOIN conferencia_categoria AS cc ON uwc.idcategoria = cc.idcategoria
							WHERE uwc.idusuario_web = $idusuario AND cc.idconferencia = ic.idconferencia LIMIT 1
						) IS NOT NULL
						ORDER BY ic.feingreso DESC LIMIT 1
				
					) AS ultima_fecha_visualizacion,

					## Usuario con sesión iniciada y ecomerce activo
					(SELECT idusuarios_web_compras FROM usuarios_web_compras
						WHERE idusuario_web = $idusuario AND idmodulo_conferencia = mcp.idmodulo_conferencia LIMIT 1
					) AS curso_comprado ";  
	}//endif
		$query .="FROM modulo_conferencia AS mcp
				  INNER JOIN modulo_conferencia_informacion AS mci ON mcp.idmodulo_conferencia = mci.idmodulo 
				  WHERE mcp.idmodulo_padre IS NULL AND mcp.fealta <= '$fechaActual' AND mcp.febaja >= '$fechaActual' ";
		
	if($idusuario){ 			
		$query .="## Usuario con sesión iniciada
				  ## Validar que los cursos tengan las mismas categorías del usuario
				  AND (SELECT uwc.idcategoria FROM usuarios_web_categorias AS uwc
					INNER JOIN modulo_conferencia_segmento AS mcs ON uwc.idcategoria = mcs.idsegmento
					WHERE uwc.idusuario_web = $idusuario AND mcs.idmodulo = mcp.idmodulo_conferencia LIMIT 1
				  ) IS NOT NULL ";
	}//endif	

		$query .="HAVING submodulos IS NOT NULL AND conferencias IS NOT NULL 
				  ORDER BY ";
				  if($idusuario){ 
					$query .= "ultima_fecha_visualizacion DESC, ";
				  }
				  $query .="mcp.fealta DESC ";
				  if(is_numeric($numerolimitIni) && is_numeric($numerolimitFin)){
					   $query .= " LIMIT " . $numerolimitIni . "," . $numerolimitFin;
				  }
		$this->connect();
		$this->query($query, "class_conferenciaDAO.php: obtenerinfoCompletaCursos");
	    $queryError = $this->conn->error;
		$this->close_db();
		if($queryError){
			
			throw new Exception('No fue posible obtener la información de los cursos (c_mCD-QE-8AyiHv)');
		}else{
			$infoCursos = [];
			for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
				$infoCursos[] =  $row;
			} //Fin for
			if(!$idusuario){
				for($i=0; $i<count($infoCursos); $i++){
					$infoCursos[$i]['contenidos_vistos']  = false;
					$infoCursos[$i]['curso_comprado']     = false;
				}
			}
			return $infoCursos;
		}
	}//end obtenerinfoCompletaCursos

	public function fn_obtenerMetaCursos($idCurso) {
		$query = " SELECT mc.idmodulo_conferencia, mc.dsnombre_modulo, mc.dsdescripcion_modulo, mci.metas FROM modulo_conferencia mc 
		LEFT JOIN modulo_conferencia_informacion mci ON mc.idmodulo_conferencia = mci.idmodulo WHERE mc.idmodulo_conferencia = $idCurso;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_obtenerMetaCursos");
		$idModulos = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$idModulos['idmodulo_conferencia']  =  $row['idmodulo_conferencia'];
			$idModulos['dsnombre_modulo']       =  $row['dsnombre_modulo'];
			$idModulos['dsdescripcion_modulo']  =  $row['dsdescripcion_modulo'];
			$idModulos['metas']                 =  $row['metas'];
		} //Fin for
		$this->close_db();
		return $idModulos;
	}

	public function fn_obtenerTotalCursos() {
		$query = " SELECT DISTINCT count(idmodulo_conferencia) as total FROM modulo_conferencia where idmodulo_padre IS NULL; ";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_obtenerTotalCursos");
		$totalPaginas = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$totalPaginas =  $row['total'];
		} //Fin for
		$this->close_db();
		return $totalPaginas;
	}


	public function fn_traerInformacionBuscadorArticulos($paramBusqueda) {
		$query = " SELECT idnoticia, dstitulo_noticia, dsresumen, dscontenido, dsruta_imagen_noticia, dsestado
		FROM noticias WHERE dstitulo_noticia LIKE '%" . $paramBusqueda . "%' OR dsresumen LIKE '%" . $paramBusqueda . "%' OR dscontenido LIKE '%" . $paramBusqueda . "%' AND dsestado = 'A' ORDER BY dstitulo_noticia ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_traerInformacionModulosFecha");
		$moduloConferencia=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[] = $row;
		}
		$this->close_db();
		return $moduloConferencia;
	}

	public function fn_traerPreguntasFrecuentesAdmin($idPregunta) {
		$query = " SELECT * FROM modulo_conferencia_preguntas_frecuentes WHERE idpregunta = $idPregunta;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_traerInformacionModulosFecha");
		$moduloConferencia=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[] = $row;
		}
		$this->close_db();
		return $moduloConferencia;
	}

	public function fn_retornarPreguntasTotal() {
		$query = " SELECT * FROM modulo_conferencia_preguntas_frecuentes ORDER BY orden ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarPreguntasTotal");
		$moduloConferencia=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[] = $row;
		}
		$this->close_db();
		return $moduloConferencia;
	}

	function fn_cambiarEstadoPregunta($idPregunta, $nuevoEstado){
		$query = " UPDATE modulo_conferencia_preguntas_frecuentes ";
		$query .= " SET estado = $nuevoEstado ";
		$query .= " WHERE idpregunta = '".$idPregunta."' ;";
		$this->connect();
		$this->query($query, "class_usuariosAdmonDAO.php: fn_cambiarEstadoPregunta");
		$resultado = "";
		if($this->affected_rows() != 0){ 
			$resultado = "S";
		}else{
			$resultado = "N";
		}
		$this->close_db();
		return $resultado;
	}

	function fn_cambiarEstadoConferencia($idConferencia, $nuevoEstado){
		$query = " UPDATE conferencia ";
		$query .= " SET dsestado_conferencia = '".$idConferencia."' ";
		$query .= " WHERE idconferencia = '".$idConferencia."' ;";
		$this->connect();
		$this->query($query, "class_usuariosAdmonDAO.php: fn_cambiarEstadoConferencia");
		$resultado = "";
		if($this->affected_rows() != 0){ 
			$resultado = "S";
		}else{
			$resultado = "N";
		}
		$this->close_db();
		return $resultado;
	}

	public function fn_traerPreguntasFrecuentes($idCurso) {
		$query = " SELECT DISTINCT mcp.idpregunta, mcpc.idmodulo_conferencia, mcp.titulo_pregunta, mcp.descripcion_pregunta, mcp.estado, mcp.orden, mcp.fecha 
		           FROM modulo_conferencia_preguntas_frecuentes mcp
		           LEFT JOIN modulo_conferencia_preguntas_frecuentes_curso mcpc ON mcp.idpregunta = mcpc.idpregunta "; 
		$query .= "WHERE mcp.estado = '1' ";
		if($idCurso){
			$query .= "AND mcpc.idmodulo_conferencia = $idCurso ";
		}else{
			$query .="GROUP BY mcp.idpregunta ";
		}
		$query .= "ORDER BY mcp.orden ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_traerInformacionModulosFecha");
		$moduloConferencia = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[] = $row;
		}
		$this->close_db();
		return $moduloConferencia;
	}

	public function fn_ingresarMetodologia($icono, $titulo, $descripcion, $idUsuarioModificador) {
		try {
			$query = "INSERT INTO modulo_conferencia_metodologias ";
			$query .= "(icono, titulo , descripcion, estado, orden, idadministrador, fechamodificacion) VALUES ";
			$query .= "('$icono', '$titulo', '$descripcion', '1', '0', $idUsuarioModificador, NOW());";

			$this->connect();
			$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarMetodologia");

			$oidModuloConferencia = $this->last_insert();

			$this->close_db();

			return $oidModuloConferencia;
		} catch (Exception $e) {
			return array(json_encode($e), false);
		}
	}

	public function fn_ingresarCursoMetodologia($arrayInformacion, $idAdministrador, $idMetodologia) {
		try {
			$query = "INSERT INTO modulo_conferencia_metodologias_rel ";
			$query .= "(idmodulo_conferencia, idmetodologia, idadministrador, fechamodificacion) VALUES ";

			$auxiliar = 0;
			

			foreach ($arrayInformacion as $key => $value) {
				$auxiliar++;
				if (count($arrayInformacion) <= 1) {
					$query .= "('$value', '$idMetodologia', '$idAdministrador', NOW());";
				} elseif ($auxiliar == count($arrayInformacion)) {
					$query .= "('$value', '$idMetodologia', '$idAdministrador', NOW());";
				} else {
					$query .= "('$value', '$idMetodologia', '$idAdministrador', NOW()),";
				}
			}

			$this->connect();
			$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarCursoMetodologia");

			$oidModuloConferencia = $this->last_insert();

			$this->close_db();

			return $oidModuloConferencia;
		} catch (Exception $e) {
			return array(json_encode($e), false);
		}
	}

	function fn_leerModuloConferenciaMetodologia($idmodulo) {
		$query = "";
		$query = "SELECT idmodulo_conferencia FROM modulo_conferencia_metodologias_rel ";
		$query .= " WHERE idmetodologia = $idmodulo ORDER BY idmetodologia ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerModuloConferenciaMetodologia");
		$categoriasConferenciaGrupos = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$categoriasConferenciaGrupos[$i]['idmodulo_conferencia'] = $row['idmodulo_conferencia'];
		} //Fin for
		$this->close_db();
		return $categoriasConferenciaGrupos;
	} //Fin fn_leerModuloConferenciaMetodologia

	function fn_leerModuloConferenciaDestacados($idmodulo) {
		$query = "";
		$query = "SELECT idmodulo_conferencia FROM modulo_conferencia_destacados_rel ";
		$query .= " WHERE iddestacado = $idmodulo ORDER BY iddestacado ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_leerModuloConferenciaDestacados");
		$categoriasConferenciaGrupos = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$categoriasConferenciaGrupos[$i]['idmodulo_conferencia'] = $row['idmodulo_conferencia'];
		} //Fin for
		$this->close_db();
		return $categoriasConferenciaGrupos;
	}

	public function fn_traerMetodologiasAdmin($idMetodologia) {
		$query = " SELECT * FROM modulo_conferencia_metodologias WHERE idmetodologia = $idMetodologia;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_traerMetodologiasAdmin");
		$moduloConferencia=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[] = $row;
		}
		$this->close_db();
		return $moduloConferencia;
	}

	public function fn_traerNivelesAdmin($idNivel) {
		$query = " SELECT * FROM modulo_conferencia_nivel WHERE idnivel = $idNivel;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_traerNivelesAdmin");
		$moduloConferencia=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[] = $row;
		}
		$this->close_db();
		return $moduloConferencia;
	}

	public function fn_traerDestacadosAdmin($idDestacado) {
		$query = " SELECT * FROM modulo_conferencia_destacados WHERE iddestacado = $idDestacado;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_traerDestacadosAdmin");
		$moduloConferencia=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[] = $row;
		}
		$this->close_db();
		return $moduloConferencia;
	}

	public function fn_retornarMetodologias() {
		$query = " SELECT * FROM modulo_conferencia_metodologias ORDER BY orden ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarMetodologias");
		$moduloConferencia=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[] = $row;
		}
		$this->close_db();
		return $moduloConferencia;
	}

	public function fn_retornarNiveles() {
		$query = " SELECT * FROM modulo_conferencia_nivel ORDER BY idnivel ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarNiveles");
		$moduloConferencia=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[] = $row;
		}
		$this->close_db();
		return $moduloConferencia;
	}

	public function fn_retornarDestacados() {
		$query = " SELECT * FROM modulo_conferencia_destacados ORDER BY orden ASC;";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_retornarDestacados");
		$moduloConferencia=[];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$moduloConferencia[] = $row;
		}
		$this->close_db();
		return $moduloConferencia;
	}

	public function fn_modificarMetodologia($icono, $titulo, $descripcion, $idadmin, $idMetodologia) {
		$query = "";
		$query = "UPDATE modulo_conferencia_metodologias ";
		$query .= "SET icono = '$icono', titulo = '$titulo', descripcion = '$descripcion', ";
		$query .= "idadministrador = '$idadmin', fechamodificacion = NOW() ";
		$query .= "WHERE idmetodologia = $idMetodologia;";
	
	$this->connect();
	$this->query($query, "class_moduloConferenciaDAO.php: fn_modificarMetodologia");
	$this->close_db();
	return $query;
}

public function fn_modificarNivel($titulo, $descripcion, $idadmin, $idNivel) {
	$query = "";
	$query = "UPDATE modulo_conferencia_nivel ";
	$query .= "SET titulo_nivel = '$titulo', descripcion_nivel = '$descripcion', ";
	$query .= "idadministrador = '$idadmin', fechamodificacion = NOW() ";
	$query .= "WHERE idnivel = $idNivel;";

$this->connect();
$this->query($query, "class_moduloConferenciaDAO.php: fn_modificarNivel");
$this->close_db();
return $query;
}

public function fn_modificarDestacado($titulo, $descripcion, $idadmin, $idDestacado) {
	$query = "";
	$query = "UPDATE modulo_conferencia_destacados ";
	$query .= "SET titulo = '$titulo', descripcion = '$descripcion', ";
	$query .= "idadministrador = '$idadmin', fechamodificacion = NOW() ";
	$query .= "WHERE iddestacado = $idDestacado;";

$this->connect();
$this->query($query, "class_moduloConferenciaDAO.php: fn_modificarDestacado");
$this->close_db();
return $query;
}

function fn_eliminarMetodologiaCurso($idMetodologia) {
	$query = "";
	$query .= "DELETE FROM modulo_conferencia_metodologias_rel ";
	$query .= "WHERE idmetodologia = $idMetodologia;";
	$this->connect();
	$this->query($query, "class_usuariosDAO.php: fn_eliminarTodasCategoriasUsuario");
	$this->close_db();
}

function fn_eliminarDestacadoCurso($idDestacado) {
	$query = "";
	$query .= "DELETE FROM modulo_conferencia_destacados_rel ";
	$query .= "WHERE iddestacado = $idDestacado;";
	$this->connect();
	$this->query($query, "class_usuariosDAO.php: fn_eliminarDestacadoCurso");
	$this->close_db();
}

function fn_cambiarEstadoMetodologia($idMetodologia, $nuevoEstado){
	$query = " UPDATE modulo_conferencia_metodologias ";
	$query .= "SET estado = $nuevoEstado ";
	$query .= "WHERE idmetodologia = '".$idMetodologia."' ;";
	$this->connect();
	$this->query($query, "class_usuariosAdmonDAO.php: fn_cambiarEstadoMetodologia");
	$resultado = "";
	if($this->affected_rows() != 0){ 
		$resultado = "S";
	}else{
		$resultado = "N";
	}
	$this->close_db();
	return $resultado;
}

function fn_cambiarEstadoNivel($idNivel, $nuevoEstado){
	$query = " UPDATE modulo_conferencia_nivel ";
	$query .= "SET estado = $nuevoEstado ";
	$query .= "WHERE idnivel = '".$idNivel."' ;";
	$this->connect();
	$this->query($query, "class_usuariosAdmonDAO.php: fn_cambiarEstadoNivel");
	$resultado = "";
	if($this->affected_rows() != 0){ 
		$resultado = "S";
	}else{
		$resultado = "N";
	}
	$this->close_db();
	return $resultado;
}

function fn_cambiarEstadoDestacado($idDestacado, $nuevoEstado){
	$query = " UPDATE modulo_conferencia_destacados ";
	$query .= "SET estado = $nuevoEstado ";
	$query .= "WHERE iddestacado = '".$idDestacado."' ;";
	$this->connect();
	$this->query($query, "class_usuariosAdmonDAO.php: fn_cambiarEstadoDestacado");
	$resultado = "";
	if($this->affected_rows() != 0){ 
		$resultado = "S";
	}else{
		$resultado = "N";
	}
	$this->close_db();
	return $resultado;
}

public function fn_obtenerMetodologias($idCurso){
	$fechaActual = date("Y-m-d");
	$query ="SELECT mcm.*, mcmr.* FROM modulo_conferencia_metodologias mcm ";
	$query .="LEFT JOIN modulo_conferencia_metodologias_rel mcmr ON mcm.idmetodologia = mcmr.idmetodologia ";
			if(is_numeric($idCurso)){
				$query .= " WHERE estado = 1 AND mcmr.idmodulo_conferencia = $idCurso ";
			}else{
				$query .= " WHERE estado = 1 AND mcmr.idmodulo_conferencia = 0 ";
			}
			$query .="ORDER BY mcm.orden ASC;";
	$this->connect();
	$this->query($query, "class_conferenciaDAO.php: fn_obtenerMetodologias");
	$queryError = $this->conn->error;
	$this->close_db();
	if($queryError){
		
		throw new Exception('No fue posible obtener la información de la metodología (c_mCSAD-QF-8AweiHv)');
	}else{
		$infoMetodologias = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$infoMetodologias[] =  $row;
		}
		return $infoMetodologias;
	}
}

public function fn_ingresarCursoDestacado($arrayInformacion, $idAdministrador, $idDestacado) {
	try {
		$query = "INSERT INTO modulo_conferencia_destacados_rel ";
		$query .= "(idmodulo_conferencia, iddestacado, idadministrador, fechamodificacion) VALUES ";

		$auxiliar = 0;
		

		foreach ($arrayInformacion as $key => $value) {
			$auxiliar++;
			if (count($arrayInformacion) <= 1) {
				$query .= "('$value', '$idDestacado', '$idAdministrador', NOW());";
			} elseif ($auxiliar == count($arrayInformacion)) {
				$query .= "('$value', '$idDestacado', '$idAdministrador', NOW());";
			} else {
				$query .= "('$value', '$idDestacado', '$idAdministrador', NOW()),";
			}
		}

		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarCursoDestacado");

		$oidModuloConferencia = $this->last_insert();

		$this->close_db();

		return $oidModuloConferencia;
	} catch (Exception $e) {
		return array(json_encode($e), false);
	}
}

public function fn_ingresarNivel($titulo, $descripcion, $idUsuarioModificador) {
	try {
		$query = "INSERT INTO modulo_conferencia_nivel ";
		$query .= "(titulo_nivel , descripcion_nivel, estado, idadministrador, fechamodificacion) VALUES ";
		$query .= "('$titulo', '$descripcion', '1', $idUsuarioModificador, NOW());";

		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarNivel");

		$oidModuloConferencia = $this->last_insert();

		$this->close_db();

		return $oidModuloConferencia;
	} catch (Exception $e) {
		return array(json_encode($e), false);
	}
}

function fn_eliminarModuloNivel($idModulo) {
	$query = "";
	$query .= "DELETE FROM modulo_conferencia_nivel_rel ";
	$query .= "WHERE idmodulo_conferencia = $idModulo; ";
	$this->connect();
	$this->query($query, "class_usuariosDAO.php: fn_eliminarTodasCategoriasUsuario");
	$this->close_db();
} //Fin fn_eliminarCategoriaUsuario

function fn_leerModuloConferenciaNivel($idNivel) {
	$query = "";
	$query = "SELECT idnivel FROM modulo_conferencia_nivel_rel  ";
	$query .= "WHERE idmodulo_conferencia = $idNivel ORDER BY id;";
	$this->connect();
	$this->query($query, "class_moduloConferenciaDAO.php: fn_leerModuloConferenciaNivel");
	$categoriasConferenciaGrupos = [];
	for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
		$categoriasConferenciaGrupos[$i]['idnivel'] = $row['idnivel'];
	} //Fin for
	$this->close_db();
	return $categoriasConferenciaGrupos;
} //Fin fn_leerModuloConferenciaNivel

function fn_leerModuloCursoDestacado($idDestacado) {
	$query = "";
	$query = "SELECT idmodulo_conferencia FROM modulo_conferencia_destacados_rel  ";
	$query .= " WHERE iddestacado = $idDestacado ORDER BY iddestacado;";
	$this->connect();
	$this->query($query, "class_moduloConferenciaDAO.php: fn_leerModuloCursoDestacado");
	$categoriasConferenciaGrupos = [];
	for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
		$categoriasConferenciaGrupos[$i]['idmodulo_conferencia'] = $row['idmodulo_conferencia'];
	} //Fin for
	$this->close_db();
	return $categoriasConferenciaGrupos;
} //Fin fn_leerModuloCursoDestacado

//GRUPOS

public function fn_obtenerGruposConferencia($idCurso){
	$query ="SELECT DISTINCT gmc.idgrupo, gmc.nombre_grupo, gmc.capacidad, gmc.estado, (SELECT count(idequipo) FROM equipos_grupo WHERE idgrupo = gmc.idgrupo GROUP BY idgrupo) as equipos, (SELECT count(idgrupo_conferencia) FROM usuarios_web_grupo_conferencia WHERE idgrupo = gmc.idgrupo GROUP BY idgrupo) as integrantes FROM grupos_modulo_conferencia gmc ";
	$query .="LEFT JOIN modulo_conferencia mc ON mc.idmodulo_conferencia = gmc.idmodulo_conferencia ";
	$query .= "WHERE gmc.idmodulo_conferencia = $idCurso;";
	$this->connect();
	$this->query($query, "class_conferenciaDAO.php: fn_obtenerGruposConferencia");
	$queryError = $this->conn->error;
	$this->close_db();
	if($queryError){
		throw new Exception('No fue posible obtener la información de los grupos (c_mCD-oGC-8AweeYv)');
	}else{
		$infoMetodologias = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$infoMetodologias[] =  $row;
		}
		return $infoMetodologias;
	}
}

function fn_cambiarEstadoGrupo($idGrupo, $nuevoEstado){
	$query = "UPDATE grupos_modulo_conferencia ";
	$query .= "SET estado = $nuevoEstado ";
	$query .= "WHERE idgrupo = '".$idGrupo."';";
	$this->connect();
	$this->query($query, "class_usuariosAdmonDAO.php: fn_cambiarEstadoGrupo");
	$resultado = "";
	if($this->affected_rows() != 0){ 
		$resultado = "S";
	}else{
		$resultado = "N";
	}
	$this->close_db();
	return $resultado;
}

public function fn_ingresarGrupo($nombre, $capacidad, $idModuloConferencia, $idUsuarioModificador, $fechaCorte, $fechaInicio, $fechaFin, $fechaExtra, $estudiantes, $duracion) {
	try {
		$query = "INSERT INTO grupos_modulo_conferencia ";
		$query .= "(idmodulo_conferencia, nombre_grupo, capacidad, estado, idadministrador, fechamodificacion, fecha_corte, fecha_inicio, fecha_fin, fecha_corte_final, estudiantes_equipo, duracion) VALUES ";
		$query .= "($idModuloConferencia, '$nombre', $capacidad, '1', $idUsuarioModificador, NOW(), '$fechaCorte', '$fechaInicio', '$fechaFin', '$fechaExtra', '$estudiantes', '$duracion');";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarGrupo");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} catch (Exception $e) {
		return array(json_encode($e), false);
	}
}

public function fn_traerGruposAdmin($idGrupo) {
	$query = "SELECT * FROM grupos_modulo_conferencia WHERE idgrupo = $idGrupo;";
	$this->connect();
	$this->query($query, "class_moduloConferenciaDAO.php: fn_traerGruposAdmin");
	$moduloConferencia=[];
	for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
		$moduloConferencia[] = $row;
	}
	$this->close_db();
	return $moduloConferencia;
}

public function fn_traerEquipoAdmin($idEquipo) {
	$query = "SELECT * FROM equipos_grupo WHERE idEquipo = $idEquipo;";
	$this->connect();
	$this->query($query, "class_moduloConferenciaDAO.php: fn_traerEquipoAdmin");
	$moduloConferencia=[];
	for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
		$moduloConferencia[] = $row;
	}
	$this->close_db();
	return $moduloConferencia;
}

public function fn_modificarGrupo($idGrupo, $nombre, $capacidad, $idadmin, $feCorte, $feInicio, $feFinal, $feExtra, $estudiantes, $duracion) {
	$query = "";
	$query = "UPDATE grupos_modulo_conferencia ";
	$query .= "SET nombre_grupo = '$nombre', capacidad = $capacidad, ";
	$query .= "idadministrador = $idadmin, fechamodificacion = NOW(), fecha_corte = '$feCorte', fecha_inicio = '$feInicio', fecha_fin = '$feFinal', fecha_corte_final = '$feExtra', estudiantes_equipo = $estudiantes, duracion = '$duracion' ";
	$query .= "WHERE idgrupo = $idGrupo;";
$this->connect();
$this->query($query, "class_moduloConferenciaDAO.php: fn_modificarGrupo");
$this->close_db();
return $query;
}

public function fn_modificarEquipo($idEquipo, $nombre, $idadmin) {
	$query = "";
	$query = "UPDATE equipos_grupo ";
	$query .= "SET nombre_equipo = '$nombre', idadministrador = $idadmin, fechamodificacion = NOW() ";
	$query .= "WHERE idequipo = $idEquipo;";
$this->connect();
$this->query($query, "class_moduloConferenciaDAO.php: fn_modificarEquipo");
$this->close_db();
return $query;
}

public function fn_obtenerEquiposGrupos($idGrupo){
	$query ="SELECT DISTINCT eg.idequipo, gmc.idgrupo, eg.fechamodificacion, eg.nombre_equipo, (SELECT COUNT(uwe.idusuario_web) FROM usuarios_web_equipo uwe WHERE idequipo = eg.idequipo) as integrantes FROM equipos_grupo eg ";
	$query .="LEFT JOIN grupos_modulo_conferencia gmc ON gmc.idgrupo = eg.idgrupo ";
	if(is_numeric($idGrupo)){
		$query .= "WHERE gmc.idgrupo = $idGrupo;";
	}
	$this->connect();
	$this->query($query, "class_conferenciaDAO.php: fn_obtenerEquiposGrupos");
	$queryError = $this->conn->error;
	$this->close_db();
	if($queryError){	
		throw new Exception('No fue posible obtener la información de los equipos (c_mCD-oEG-Streiop)');
	}else{
		$infoEquipos = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$infoEquipos[] =  $row;
		}
		return $infoEquipos;
	}
}

public function fn_obtenerEstudiantesConferencia($idCurso, $idListado){
	$query ="SELECT DISTINCT uw.idusuario_web, uwc.idmodulo_conferencia, uw.dsnombre_completo, uw.dscorreo_electronico, uwc.femodificacion FROM usuarios_web_compras uwc   ";
	$query .="LEFT JOIN usuarios_web uw ON uw.idusuario_web = uwc.idusuario_web ";
	$query .="LEFT JOIN usuarios_web_grupo_conferencia uwgc ON uwgc.idusuario_web = uwc.idusuario_web ";
	$query .="WHERE uwc.idmodulo_conferencia = $idCurso ";
	if($idListado != false){
		$query .="AND uw.idusuario_web NOT IN ($idListado) ";
	}
	$query .="ORDER BY uwc.femodificacion DESC;";
	$this->connect();
	$this->query($query, "class_conferenciaDAO.php: fn_obtenerEstudiantesConferencia");
	$queryError = $this->conn->error;
	$this->close_db();
	if($queryError){
		throw new Exception('No fue posible obtener la información de los estudiantes (c_mCD-oEC-exMar9y)');
	}else{
		$infoEstudiantes = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$infoEstudiantes[] =  $row;
		}
		return $infoEstudiantes;
	}
}

public function fn_traerEstudianteAdmin($idEstudiante, $idConferencia, $idGrupo) {
	if(is_numeric($idConferencia)){
	$query = "SELECT DISTINCT uw.idusuario_web, uw.dsnombre_completo, uw.dscorreo_electronico, gmc.idmodulo_conferencia, uwgc.idgrupo, gmc.nombre_grupo FROM usuarios_web uw ";
	$query .= "LEFT JOIN usuarios_web_grupo_conferencia uwgc ON uwgc.idusuario_web = uw.idusuario_web ";
	$query .= "LEFT JOIN usuarios_web_compras uwc ON uwc.idusuario_web = uw.idusuario_web ";
	$query .= "LEFT JOIN grupos_modulo_conferencia gmc ON gmc.idgrupo = uwgc.idgrupo ";
	$query .= "WHERE uwc.idusuario_web = $idEstudiante AND uwc.idmodulo_conferencia = $idConferencia GROUP BY uwgc.idgrupo;";
	}
	if(is_numeric($idGrupo)){
	$query = "SELECT DISTINCT uw.idusuario_web, uw.dsnombre_completo, uw.dscorreo_electronico, gmc.idmodulo_conferencia, uwgc.idgrupo, gmc.nombre_grupo FROM usuarios_web uw ";
	$query .= "LEFT JOIN usuarios_web_grupo_conferencia uwgc ON uwgc.idusuario_web = uw.idusuario_web ";
	$query .= "LEFT JOIN usuarios_web_compras uwc ON uwc.idusuario_web = uw.idusuario_web ";
	$query .= "LEFT JOIN grupos_modulo_conferencia gmc ON gmc.idgrupo = uwgc.idgrupo ";
	$query .= "WHERE uwc.idusuario_web = $idEstudiante AND uwc.idmodulo_conferencia = $idConferencia GROUP BY uwgc.idgrupo;";
	}
	$this->connect();
	$this->query($query, "class_moduloConferenciaDAO.php: fn_traerEstudianteAdmin");
	$infoEstudiantes=[];
	for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
		$infoEstudiantes[] = $row;
	}
	$this->close_db();
	return $infoEstudiantes;
}

public function fn_traerGrupoActualEstudiante($idEstudiante, $idConferencia) {
	$query = "SELECT gmc.idgrupo, gmc.nombre_grupo FROM usuarios_web_grupo_conferencia uwgc  ";
	$query .= "LEFT JOIN grupos_modulo_conferencia gmc ON gmc.idgrupo = uwgc.idgrupo ";
	$query .= "WHERE uwgc.idusuario_web = $idEstudiante AND gmc.idmodulo_conferencia = $idConferencia;";
	$this->connect();
	$this->query($query, "class_moduloConferenciaDAO.php: fn_traerGrupoActualEstudiante");
	$infoEstudiantes=[];
	for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
		$infoEstudiantes[] = $row;
	}
	$this->close_db();
	return $infoEstudiantes;
}

public function fn_agregarEstudianteCurso($arrayInformacion, $idCurso) {
	try {
		$query = "INSERT INTO usuarios_web_compras ";
		$query .= "(idusuario_web, idmodulo_conferencia, referencia, id_transaccion, precio, femodificacion) VALUES ";
		$auxiliar = 0;
		foreach ($arrayInformacion as $key => $value) {
			$auxiliar++;
			if (count($arrayInformacion) <= 1) {
				$query .= "('$value', '$idCurso', 'Agregado', 'Agregado', '0', NOW());";
			} elseif ($auxiliar == count($arrayInformacion)) {
				$query .= "('$value', '$idCurso', 'Agregado', 'Agregado', '0', NOW());";
			} else {
				$query .= "('$value', '$idCurso', 'Agregado', 'Agregado', '0', NOW()),";
			}
		}
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_agregarEstudianteCurso");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} catch (Exception $e) {
		return array(json_encode($e), false);
	}
}

public function fn_agregarEstudianteGrupo($arrayInformacion, $idGrupo, $idAdmin) {
	try {
		$query = "INSERT INTO usuarios_web_grupo_conferencia ";
		$query .= "(idusuario_web, idgrupo, idadministrador, fechamodificacion) VALUES ";
		$auxiliar = 0;
		foreach ($arrayInformacion as $key => $value) {
			$auxiliar++;
			if (count($arrayInformacion) <= 1) {
				$query .= "('$value', '$idGrupo', '$idAdmin', NOW());";
			} elseif ($auxiliar == count($arrayInformacion)) {
				$query .= "('$value', '$idGrupo', '$idAdmin', NOW());";
			} else {
				$query .= "('$value', '$idGrupo', '$idAdmin', NOW()),";
			}
		}
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_agregarEstudianteGrupo");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} catch (Exception $e) {
		return array(json_encode($e), false);
	}
}

public function fn_agregarEstudianteEquipo($arrayInformacion, $idEquipo, $idAdmin) {
	try {
		$query = "INSERT INTO usuarios_web_equipo ";
		$query .= "(idusuario_web, idequipo, idadministrador, fechamodificacion) VALUES ";
		$auxiliar = 0;
		foreach ($arrayInformacion as $key => $value) {
			$auxiliar++;
			if (count($arrayInformacion) <= 1) {
				$query .= "('$value', '$idEquipo', '$idAdmin', NOW());";
			} elseif ($auxiliar == count($arrayInformacion)) {
				$query .= "('$value', '$idEquipo', '$idAdmin', NOW());";
			} else {
				$query .= "('$value', '$idEquipo', '$idAdmin', NOW()),";
			}
		}
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_agregarEstudianteEquipo");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} catch (Exception $e) {
		return array(json_encode($e), false);
	}
}

function fn_eliminarEstudianteGrupo($idEstudiante, $grupoActual) {
	$query = "DELETE FROM usuarios_web_grupo_conferencia ";
	$query .= "WHERE idusuario_web = $idEstudiante AND idgrupo = $grupoActual;";
	$this->connect();
	$this->query($query, "class_usuariosDAO.php: fn_eliminarEstudianteGrupo");
	$this->close_db();
}

public function fn_ingresarEstudianteAGrupo($idEstudiante, $idGrupo, $idAdmin) {
	try {
		$query = "INSERT INTO usuarios_web_grupo_conferencia ";
		$query .= "(idusuario_web, idgrupo, idadministrador, fechamodificacion) VALUES ";
		$query .= "('$idEstudiante', '$idGrupo', '$idAdmin', NOW());";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarEstudianteAGrupo");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} catch (Exception $e) {
		return array(json_encode($e), false);
	}
}

public function fn_obtenerEstudiantesGrupo($idGrupo, $idListado){
	$query ="SELECT DISTINCT uwgc.idusuario_web, uwgc.fechamodificacion, uw.dsnombre_completo, uw.dscorreo_electronico FROM usuarios_web_grupo_conferencia uwgc ";
	$query .="LEFT JOIN usuarios_web uw ON uw.idusuario_web = uwgc.idusuario_web ";
	$query .="WHERE uwgc.idgrupo = $idGrupo ";
	if($idListado != false){
		$query .="AND uw.idusuario_web NOT IN ($idListado) ";
	}
	$query .="ORDER BY uwgc.fechamodificacion DESC;";
	$this->connect();
	$this->query($query, "class_conferenciaDAO.php: fn_obtenerEstudiantesGrupo");
	$queryError = $this->conn->error;
	$this->close_db();
	if($queryError){
		throw new Exception('No fue posible obtener la información de los estudiantes (c_mCD-oEG-exMar9y)');
	}else{
		$infoEstudiantes = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$infoEstudiantes[] =  $row;
		}
		return $infoEstudiantes;
	}
}

public function fn_traerEquipoActualEstudiante($idEstudiante, $idGrupo) {
	$query = "SELECT DISTINCT eg.idequipo, eg.nombre_equipo FROM usuarios_web_equipo uwe ";
	$query .= "LEFT JOIN equipos_grupo eg ON eg.idequipo = uwe.idequipo ";
	$query .= "WHERE uwe.idusuario_web = $idEstudiante AND eg.idgrupo = $idGrupo;";
	$this->connect();
	$this->query($query, "class_moduloConferenciaDAO.php: fn_traerEquipoActualEstudiante");
	$infoEstudiantes=[];
	for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
		$infoEstudiantes[] = $row;
	}
	$this->close_db();
	return $infoEstudiantes;
}

public function fn_obtenerEquiposGrupo($idCurso){
	$query ="SELECT DISTINCT gmc.idgrupo, gmc.nombre_grupo, gmc.capacidad, gmc.estado, ua.dsnombre_completo_usuario, (SELECT count(idequipo) FROM equipos_grupo WHERE idgrupo = gmc.idgrupo GROUP BY idgrupo) as equipos, (SELECT count(idgrupo_conferencia) FROM usuarios_web_grupo_conferencia WHERE idgrupo = gmc.idgrupo GROUP BY idgrupo) as integrantes FROM grupos_modulo_conferencia gmc ";
	$query .="LEFT JOIN modulo_conferencia mc ON mc.idmodulo_conferencia = gmc.idmodulo_conferencia ";
	$query .="LEFT JOIN usuarios_administradores ua ON ua.idusuario_administrador = gmc.idusuario_administrador ";
	$query .= "WHERE gmc.idmodulo_conferencia = $idCurso;";
	$this->connect();
	$this->query($query, "class_conferenciaDAO.php: fn_obtenerEquiposGrupo");
	$queryError = $this->conn->error;
	$this->close_db();
	if($queryError){
		
		throw new Exception('No fue posible obtener la información de los grupos (c_mCD-oGC-8AweeYv)');
	}else{
		$infoMetodologias = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$infoMetodologias[] =  $row;
		}
		return $infoMetodologias;
	}
}

public function fn_ingresarEquipo($nombre, $idGrupo, $idUsuarioModificador) {
	try {
		$query = "INSERT INTO equipos_grupo ";
		$query .= "(idgrupo, nombre_equipo, idadministrador, fechamodificacion) VALUES ";
		$query .= "($idGrupo, '$nombre', $idUsuarioModificador, NOW());";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarEquipo");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} catch (Exception $e) {
		return array(json_encode($e), false);
	}
}

function fn_eliminarEstudianteEquipo($idEstudiante, $equipoActual) {
	$query = "DELETE FROM usuarios_web_equipo ";
	$query .= "WHERE idusuario_web = $idEstudiante AND idequipo = $equipoActual;";
	$this->connect();
	$this->query($query, "class_usuariosDAO.php: fn_eliminarEstudianteEquipo");
	$this->close_db();
}

public function fn_ingresarEstudianteAEquipo($idEstudiante, $idEquipo, $idAdmin) {
	try {
		$query = "INSERT INTO usuarios_web_equipo ";
		$query .= "(idusuario_web, idequipo, idadministrador, fechamodificacion) VALUES ";
		$query .= "('$idEstudiante', '$idEquipo', '$idAdmin', NOW());";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarEstudianteAEquipo");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} catch (Exception $e) {
		return array(json_encode($e), false);
	}
}

public function fn_ingresarTutorGrupo($arrayInformacion, $idGrupo, $idAdministrador) {
	try {
		$query = "INSERT INTO tutores_grupo ";
		$query .= "(idusuario_administrador, idgrupo, idadministrador, fechamodificacion) VALUES ";

		$auxiliar = 0;

		foreach ($arrayInformacion as $key => $value) {
			$auxiliar++;
			if (count($arrayInformacion) <= 1) {
				$query .= "('$value', '$idGrupo', '$idAdministrador', NOW());";
			} elseif ($auxiliar == count($arrayInformacion)) {
				$query .= "('$value', '$idGrupo', '$idAdministrador', NOW());";
			} else {
				$query .= "('$value', '$idGrupo', '$idAdministrador', NOW()),";
			}
		}
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_ingresarTutorGrupo");
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} catch (Exception $e) {
		return array(json_encode($e), false);
	}
}

public function fn_obtenerUsuarios(){
	$query ="SELECT * FROM usuarios ";
	$this->connect();
	$this->query($query, "class_conferenciaDAO.php: fn_obtenerUsuarios");
	$queryError = $this->conn->error;
	$this->close_db();
	if($queryError){
		throw new Exception('No fue posible obtener la información de los tutores (c_mCD-oTG-8AeciPv)');
	}else{
		$infoTutores = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$infoTutores[] =  $row;
		}
		return $infoTutores;
	}
}

function fn_eliminarTutorGrupo($idGrupo) {
	$query = "";
	$query .= "DELETE FROM tutores_grupo ";
	$query .= "WHERE idgrupo = $idGrupo;";
	$this->connect();
	$this->query($query, "class_usuariosDAO.php: fn_eliminarTutorGrupo");
	$this->close_db();
}

public function fn_obtenerEstudiantesEquipo($idEquipo){
	$query ="SELECT DISTINCT uwe.idusuario_web, uwe.fechamodificacion, uw.dsnombre_completo, uw.dscorreo_electronico FROM usuarios_web_equipo uwe ";
	$query .="LEFT JOIN usuarios_web uw ON uw.idusuario_web = uwe.idusuario_web ";
	$query .="WHERE uwe.idequipo = $idEquipo ORDER BY uwe.fechamodificacion DESC;";
	$this->connect();
	$this->query($query, "class_conferenciaDAO.php: fn_obtenerEstudiantesEquipo");
	$queryError = $this->conn->error;
	$this->close_db();
	if($queryError){
		throw new Exception('No fue posible obtener la información de los estudiantes (c_mCD-oEE-xxESary)');
	}else{
		$infoEstudiantes = [];
		for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
			$infoEstudiantes[] =  $row;
		}
		return $infoEstudiantes;
	}
}

public function fn_traerIntensidadCurso($idCurso, $idGrupo) {
	$query = "SELECT * FROM intensidad_modulo_conferencia imc  ";
	if(is_numeric($idCurso)) {
		$query .= "WHERE imc.idmodulo_conferencia = $idCurso ";
	}
	if(is_numeric($idGrupo)){
		$query .= "LEFT JOIN intensidad_grupos_modulo_conferencia igmc ON igmc.idintensidad = imc.idintensidad ";
		$query .= "WHERE igmc.idgrupo = $idGrupo;";
	}
	$this->connect();
	$this->query($query, "class_moduloConferenciaDAO.php: fn_traerIntensidadCurso");
	$infoCurso=[];
	for ($i = 0; $row = $this->fetch_array($this->result); $i++) {
		$infoCurso[] = $row;
	}
	$this->close_db();
	return $infoCurso;
}

public function fn_insertarIntensidadGrupo($intensidad, $idGrupo, $idAdmin) {
	try {
		$query = "INSERT INTO intensidad_grupos_modulo_conferencia ";
		$query .= "(idintensidad, idgrupo, idadministrador, fechamodificacion) VALUES ";
		$query .= "('$intensidad', '$idGrupo', '$idAdmin', NOW());";
		$this->connect();
		$this->query($query, "class_moduloConferenciaDAO.php: fn_insertarIntensidadGrupo");	
		$oidModuloConferencia = $this->last_insert();
		$this->close_db();
		return $oidModuloConferencia;
	} catch (Exception $e) {
		return array(json_encode($e), false);
	}
}
}//Fin Clase moduloConferenciaDAO