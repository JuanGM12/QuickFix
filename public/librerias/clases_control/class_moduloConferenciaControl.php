<?php

require_once PATH_REQUIRES;

class moduloConferenciaControl {

	//Constructor de la clase moduloConferenciaControl
	public function __construct() {
	} //Fin moduloConferenciaControl

	public function fn_obtenerUsuarios(){
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoEstudiantes = $moduloConferenciaDAO->fn_obtenerUsuarios();
		return $infoEstudiantes;
	}

	//Retornar los submodulos del modulo de conferencias
	public function fn_retornarSubModulosConferencia($iidModuloConferencia) {
		$idModulos = 0;
		if ($iidModuloConferencia == "" || $iidModuloConferencia == NULL) {
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo del modulo para poder cargar la informacion.');
		} //Fin if
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$idModulos = $moduloConferenciaDAO->fn_retornarSubModulosConferencia($iidModuloConferencia);
		if ($idModulos == 0) {
			$datosModulo = "NO DATOS";
		} //Fin if
		else {
			for ($i = 0; $i < count($idModulos); $i++) {
				$datosModulo[$i] = $moduloConferenciaDAO->fn_leerModuloConferencia($idModulos[$i]);
			} //Fin for
		} //fin else
		return $datosModulo;
	} //Fin fn_retornarSubModulosConferencia
	public function fn_retornarConferenciasModulo($datosIngresos, $idioma = "") {
		$iidModuloConferencia = $datosIngresos['idModuloConferencia'];
		$idsTipoVisualizacion = $datosIngresos['idsTipoVisualizacion'];
		$idCategoria          = $datosIngresos['idCategoria'];
		$idUsuario            = $datosIngresos['idUsuario'];
		$grupo            	  = $datosIngresos['grupo'];

		$iidCategorias		  = $datosIngresos['categorias'];
		$categoriass = "";
		for ($i = 0; $i < count($iidCategorias); $i++) {
			$categoriass .= $iidCategorias[$i]['idcategoria'] . ",";
		}
		$categoriasIds = substr($categoriass, 0, -1);


		if ($iidModuloConferencia == "" || $iidModuloConferencia == NULL) {
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo del modulo para poder cargar la informacion.');
		} //Fin if
		if ($idsTipoVisualizacion == "" || $idsTipoVisualizacion == NULL) {
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo del tipo de visualizacion para poder cargar la informacion.');
		} //Fin if
		$conferenciaDAO = new conferenciaDAO();
		$oidConferencias = $conferenciaDAO->fn_retornarConferenciasModuloActivos($iidModuloConferencia, $idsTipoVisualizacion, $categoriasIds);
		$j = 0;
		for ($i = 0; $i < count($oidConferencias); $i++) {
			/*if($conferenciaDAO->fn_validarExistenciaConferencia($oidConferencias[$i])){
				$conferencias[$j] = $conferenciaDAO->fn_leerConferencia($oidConferencias[$i]);
				$conferencias[$j]['visualizaciones'] = $conferenciaDAO->fn_leerVisualizacionesConferencia($oidConferencias[$i], $idUsuario);
				$conferencias[$j]['ganoEvaluacion']  = $conferenciaDAO->fn_validarAprobacionConferencia($oidConferencias[$i], $idUsuario);
				$conferencias[$j]['ingresoEvaluacion']  = $conferenciaDAO->fn_validarIngresoConferencia($oidConferencias[$i], $idUsuario);
				$j++;				
			}//Fin if*/

			if ($conferenciaDAO->fn_validarExistenciaConferencia($oidConferencias[$i])) {
				$conferencias[$j] = $conferenciaDAO->fn_leerConferencia($oidConferencias[$i], $idioma);
				$conferencias[$j]['visualizaciones'] = $conferenciaDAO->fn_leerVisualizacionesConferencia($oidConferencias[$i], $idUsuario);
				$conferencias[$j]['ingresoEvaluacion']  = $conferenciaDAO->fn_validarIngresoConferencia($oidConferencias[$i], $idUsuario);
				$conferencias[$j]['validarEvaluacion'] =  $conferenciaDAO->fn_leerInformacionPorcentajeCantidadPreguntas($oidConferencias[$i]);
				$numerosPrg = (int)$conferencias[$j]['validarEvaluacion']['numeropreguntas'];
				if ($numerosPrg > 0) {
					$conferencias[$j]['ganoEvaluacion']  = $conferenciaDAO->fn_validarAprobacionConferencia($oidConferencias[$i], $idUsuario);
					$ganoEval = (int)$conferencias[$j]['ganoEvaluacion'];
					if ($ganoEval > 0) {
						$conferencias[$j]['ganoEvaluacion']  = $ganoEval;
					} else {
						$conferencias[$j]['ganoEvaluacion']  = 0;
					}
					$conferencias[$j]['validarEvaluacion'] = 1;
				} else {
					$conferencias[$j]['ganoEvaluacion']  = 0;
					$conferencias[$j]['validarEvaluacion'] = 0;
				}
				//fn_validarAprobacionConferencia($iidConferencia, $idUsuario)
				$j++;
			} //Fin if
		} //Fin for
		return $conferencias;
	} //Fin fn_retornarConferenciasModulo

	public function fn_retornarSiUsuarioVisitoConferencia($idUsuario, $idConferencia) {
		$conferenciaDAO = new conferenciaDAO();
		$conferencias = $conferenciaDAO->fn_leerVisualizacionesConferencia($idConferencia, $idUsuario);
		return $conferencias;
	}

	/*
	public function fn_retornarConferenciasModulo($datosIngresos){
		$iidModuloConferencia = $datosIngresos['idModuloConferencia'];
		$idsTipoVisualizacion = $datosIngresos['idsTipoVisualizacion'];
		$idCategoria          = $datosIngresos['idCategoria'];
		$idUsuario            = $datosIngresos['idUsuario'];
		if($iidModuloConferencia == "" || $iidModuloConferencia == NULL){
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo del modulo para poder cargar la informacion.');
		}//Fin if
		if($idsTipoVisualizacion == "" || $idsTipoVisualizacion == NULL){
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo del tipo de visualizacion para poder cargar la informacion.');
		}//Fin if
		$conferenciaDAO = new conferenciaDAO();
		for($ct=0; $ct < count($categoriaUsuario); $ct++){
		
			$oidConferencias = $conferenciaDAO->fn_retornarConferenciasModuloActivos($iidModuloConferencia, $idsTipoVisualizacion, $categoriaUsuario[$ct]['idcategoria']);
			$j=0;
			for($i=0; $i < count($oidConferencias); $i++){
				if($conferenciaDAO->fn_validarExistenciaConferencia($oidConferencias[$i])){
					$conferencias[$j] = $conferenciaDAO->fn_leerConferencia($oidConferencias[$i]);
					$conferencias[$j]['visualizaciones'] = $conferenciaDAO->fn_leerVisualizacionesConferencia($oidConferencias[$i], $idUsuario);
					$conferencias[$j]['ganoEvaluacion']  = $conferenciaDAO->fn_validarAprobacionConferencia($oidConferencias[$i], $idUsuario);
					$j++;				
				}//Fin if
			}//Fin for
		}
		return $conferencias;
	}//Fin fn_retornarConferenciasModulo 
	*/

	//Funcion leer encuesta
	public function fn_leerEncuestaPresentacion($idconferencia, $idioma = "") {
		$conferenciaDAO = new conferenciaDAO();

		if ($conferenciaDAO->fn_existeEncuestaConferencia($idconferencia, $idioma)) {
			$datosEncuesta = $conferenciaDAO->fn_leerEncuestaConferencia($idconferencia, $idioma);
		} //Fin if
		return $datosEncuesta;
	} //Fin fn_leerEncuestaPresentacion


	//Funcion consulta si Usuario ha realizado encuesta
	public function fn_consultarEncuestaUsuarioPresentacion($idconferencia, $idUsuario, $idRespuesta) {
		$conferenciaDAO = new conferenciaDAO();
		$datosEncuesta = $conferenciaDAO->fn_encuestaUsuarioAnteriorConferencia($idconferencia, $idUsuario, $idRespuesta);
		return $datosEncuesta;
	} //Fin fn_consultarEncuestaUsuarioPresentacion


	//Funcion actualizar votos Encuesta
	public function fn_actualizarVotosEncuesta($idconferenciaEncuestaRespuesta, $idioma = "") {
		$conferenciaDAO = new conferenciaDAO();
		$conferenciaDAO->fn_actualizarVotosEncuesta($idconferenciaEncuestaRespuesta, $idioma);
	}



	//Funcion que retorna las conferencias en un modulo de conferencia
	public function fn_retornarModulosConferenciasCanal() {

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$conferenciaDAO = new conferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_retornarTodosModulosCanal();
		for ($i = 0; $i < count($oModulosCanal); $i++) {
			$totalConferencias = 0;
			$oTotalModulosCanal[$i][0] = $moduloConferenciaDAO->fn_leerModuloConferencia($oModulosCanal[$i]);
			$oTotalModulosCanal[$i][1] = $moduloConferenciaDAO->fn_retornarTotalSubModulosConferencia($oModulosCanal[$i]);
			$oTotalModulosCanal[$i][2] = $moduloConferenciaDAO->fn_leerModuloConferenciaPorCategorias($oModulosCanal[$i]);
			$contadorArray = 0;
			for ($k = 0; $k < count($oTotalModulosCanal[$i][2]); $k++) {
				if ($moduloConferenciaDAO->fn_leerModuloConferenciaPorCategoriasGrupos($oTotalModulosCanal[$i][2][$k]) != null) {
					$oTotalModulosCanal[$i][3][$contadorArray] = $moduloConferenciaDAO->fn_leerModuloConferenciaPorCategoriasGrupos($oTotalModulosCanal[$i][2][$k]);
					$contadorArray++;
				}
			}

			if (count($oTotalModulosCanal[$i][1]) > 0) {
				for ($j = 0; $j < count($oTotalModulosCanal[$i][1]); $j++) {
					$oTotalModulosCanal[$i][1][$j] = $moduloConferenciaDAO->fn_leerModuloConferencia($oTotalModulosCanal[$i][1][$j]);
					$oTotalModulosCanal[$i][1][$j]['totalConferencias'] = $conferenciaDAO->fn_retornarNumeroConferenciasModulo($oTotalModulosCanal[$i][1][$j]['idmodulo_conferencia']);
					$oTotalModulosCanal[$i][1][$j]['categorias'] = $moduloConferenciaDAO->fn_leerModuloConferenciaPorCategoriasGrupos($oTotalModulosCanal[$i][1][$j]['idmodulo_conferencia']);
					$oTotalModulosCanal[$i][1][$j]['grupos'] = $moduloConferenciaDAO->fn_leerModuloConferenciaPorCategoriasGruposUsuarios($oTotalModulosCanal[$i][1][$j]['idmodulo_conferencia']);
					$totalConferencias = $totalConferencias + $conferenciaDAO->fn_retornarNumeroConferenciasModulo($oTotalModulosCanal[$i][1][$j]['idmodulo_conferencia']);
					$oTotalModulosCanal[$i][2] = $moduloConferenciaDAO->fn_leerModuloConferenciaPorCategorias($oTotalModulosCanal[$i][1][$j]['idmodulo_conferencia']);
					//$oTotalModulosCanal[$i][3] = $moduloConferenciaDAO->fn_leerModuloConferenciaPorCategoriasGrupos($oTotalModulosCanal[$i][2]);
					/*$contadorArray = 0;
					for($k=0; $k<count($oTotalModulosCanal[$i][2]); $k++){
						if($moduloConferenciaDAO->fn_leerModuloConferenciaPorCategoriasGrupos($oTotalModulosCanal[$i][2][$k])!=null){
							$oTotalModulosCanal[$i][3][$contadorArray] = $moduloConferenciaDAO->fn_leerModuloConferenciaPorCategoriasGrupos($oTotalModulosCanal[$i][2][$k]);							
							$contadorArray++;
						}						
					}*/
				} //Fin for
			} //Fin if
			else {
				$totalConferencias = $totalConferencias + $conferenciaDAO->fn_retornarNumeroConferenciasModulo($oTotalModulosCanal[$i][0]['idmodulo_conferencia']);
			}
			$oTotalModulosCanal[$i][0]['totalConferencias'] = $totalConferencias;
		} //Fin for
		return $oTotalModulosCanal;
	} //Fin fn_retornarModulosConferenciasCanal


	public function fn_retornarModulosConferenciasCanalTotal() {

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_retornarTodosModulosCanalOrden("0");
		for ($i = 0; $i < count($oModulosCanal); $i++) {
			$oModulosCanal[$i]['hijos'] = $moduloConferenciaDAO->fn_retornarTodosModulosCanalOrden($oModulosCanal[$i]['idmodulo_conferencia']);
			for ($j = 0; $j < count($oModulosCanal[$i]['hijos']); $j++) {
				$oModulosCanal[$i]['hijos'][$j]['hijos'] = $moduloConferenciaDAO->fn_retornarTodosModulosCanalOrden($oModulosCanal[$i]['hijos'][$j]['idmodulo_conferencia']);
			}
		}
		return $oModulosCanal;
	} //Fin fn_retornarModulosConferenciasCanal


	public function fn_cambiarOrdenModulos($iidmodulo, $nuevoOrden, $iidUsuarioModificador) {

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_cambiarOrdenModulos($iidmodulo, $nuevoOrden, $iidUsuarioModificador);

		return $oModulosCanal;
	} //Fin fn_retornarModulosConferenciasCanal

	public function fn_cambiarOrdenPreguntas($idPregunta, $nuevoOrden, $iidUsuarioModificador) {

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_cambiarOrdenPreguntas($idPregunta, $nuevoOrden, $iidUsuarioModificador);

		return $oModulosCanal;
	} //Fin fn_retornarModulosConferenciasCanal

	public function fn_cambiarOrdenMetodologias($idMetodologia, $nuevoOrden, $iidUsuarioModificador) {

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_cambiarOrdenMetodologias($idMetodologia, $nuevoOrden, $iidUsuarioModificador);

		return $oModulosCanal;
	}

	public function fn_cambiarOrdenDestacados($idDestacado, $nuevoOrden, $iidUsuarioModificador) {

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_cambiarOrdenDestacados($idDestacado, $nuevoOrden, $iidUsuarioModificador);

		return $oModulosCanal;
	}

	public function fn_cambiarOrdenConferencia($iidmodulo, $nuevoOrden, $iidUsuarioModificador, $iidConferencia) {

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_cambiarOrdenConferencia($iidmodulo, $nuevoOrden, $iidUsuarioModificador, $iidConferencia);

		return $oModulosCanal;
	} //Fin fn_retornarModulosConferenciasCanal

	//Funcion que retorna las conferencias en un modulo de conferencia
	public function fn_retornarModulosConferenciasCanalPerfil($perfil, $idUsuario) {

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$conferenciaDAO = new conferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_retornarTodosModulosCanal();
		for ($i = 0; $i < count($oModulosCanal); $i++) {
			$totalConferencias = 0;
			$oTotalModulosCanal[$i][0] = $moduloConferenciaDAO->fn_leerModuloConferencia($oModulosCanal[$i]);
			$oTotalModulosCanal[$i][3] = $moduloConferenciaDAO->fn_retornarTotalSubModulosConferencia($oModulosCanal[$i]);
			$oTotalModulosCanal[$i][1] = $moduloConferenciaDAO->fn_retornarTotalSubModulosConferenciaPerfil($oModulosCanal[$i], $idUsuario);
			$oTotalModulosCanal[$i][2] = $moduloConferenciaDAO->fn_leerModuloConferenciaPorCategorias($oModulosCanal[$i]);

			if (count($oTotalModulosCanal[$i][1]) > 0) {
				for ($j = 0; $j < count($oTotalModulosCanal[$i][1]); $j++) {
					$oTotalModulosCanal[$i][1][$j] = $moduloConferenciaDAO->fn_leerModuloConferencia($oTotalModulosCanal[$i][1][$j]);
					$oTotalModulosCanal[$i][1][$j]['totalConferencias'] = $conferenciaDAO->fn_retornarNumeroConferenciasModulo($oTotalModulosCanal[$i][1][$j]['idmodulo_conferencia']);
					$totalConferencias = $totalConferencias + $conferenciaDAO->fn_retornarNumeroConferenciasModulo($oTotalModulosCanal[$i][1][$j]['idmodulo_conferencia']);
					$oTotalModulosCanal[$i][2] = $moduloConferenciaDAO->fn_leerModuloConferenciaPorCategorias($oTotalModulosCanal[$i][1][$j]['idmodulo_conferencia']);
				} //Fin for
			} //Fin if
			else {
				$totalConferencias = $totalConferencias + $conferenciaDAO->fn_retornarNumeroConferenciasModulo($oTotalModulosCanal[$i][0]['idmodulo_conferencia']);
			}
			$oTotalModulosCanal[$i][0]['totalConferencias'] = $totalConferencias;
		} //Fin for
		return $oTotalModulosCanal;
	} //Fin fn_retornarModulosConferenciasCanal




	//Retornar presentaciones del modulo de conferencia.
	public function fn_retornarDatosPresentacionesModulos($iidmodulo) {
		$conferenciaDAO = new conferenciaDAO();
		$datosPresentaciones = $conferenciaDAO->fn_retornarConferenciasModulo($iidmodulo);
		for ($i = 0; $i < count($datosPresentaciones); $i++) {
			$datosPresentaciones[$i] = $conferenciaDAO->fn_leerConferencia($datosPresentaciones[$i]);
		}
		return $datosPresentaciones;
	} //Fin fn_retornarDatosPresentacionesModulos


	//Retornar presentaciones asociadas a un administrador - Tutor.
	public function fn_retornarDatosPresentacionesModulosTutor($idUsuarioAdmin) {
		$conferenciaDAO = new conferenciaDAO();
		$datosPresentaciones = $conferenciaDAO->fn_retornarConferenciasModuloTutor($idUsuarioAdmin);
		for ($i = 0; $i < count($datosPresentaciones); $i++) {
			$datosPresentaciones[$i] = $conferenciaDAO->fn_leerConferencia($datosPresentaciones[$i]);
		}
		return $datosPresentaciones;
	} //Fin fn_retornarDatosPresentacionesModulos

	//Retornar la fecha de la ultima evaluacion de conferencia Para validar hayan pasado 10 minutos
	public function fn_retornarUltimaFechaEvaluacion($idConferencia, $idUsuario) {
		$conferenciaDAO = new conferenciaDAO();
		$datosPresentaciones = $conferenciaDAO->fn_retornarFechaEvaluacion($idConferencia, $idUsuario);
		return $datosPresentaciones;
	} //Fin fn_retornarDatosPresentacionesModulos


	//Funcion que retorna toda la información de la presentación
	public function fn_retornarDatosPresentacionCompleta($iidConferencia, $idUsuario, $idioma = "") {
		if ($iidConferencia == "" || $iidConferencia == NULL) {
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo de la conferencia para poder cargar la informacion...');
		} //Fin if
		$conferenciaDAO = new conferenciaDAO();
		$conferencia['datosConferencia'] = $conferenciaDAO->fn_leerConferencia($iidConferencia, $idioma);
		$conferencia['datosConferencia']['nombreConferenciaGral'] = $conferenciaDAO->fn_traerNombreModuloConferencia($iidConferencia, $idioma);
		$conferencia['datosConferencia']['nmposicion_inicio'] = $conferenciaDAO->fn_traerPosicionInicioPadre($iidConferencia);
		$conferencia['datosConferencia']['idmodulo_padre'] = $conferenciaDAO->fn_traerIdModuloPadre($iidConferencia);

		if ($conferenciaDAO->fn_existeDiapositivasConferencia($iidConferencia)) {
			$conferencia['datosDiapositivas'] = $conferenciaDAO->fn_leerDiapositivasConferencia($iidConferencia, $idioma);
			$conferencia['datosDiapositivas']['tieneDiapositivas'] = true;
		} //Fin if
		else {
			$conferencia['datosDiapositivas']['tieneDiapositivas'] = false;
		} //Fin else
		if ($conferenciaDAO->fn_existeArchivosConferencia($iidConferencia)) {
			$conferencia['datosArchivos'] = $conferenciaDAO->fn_leerArchivosConferencia($iidConferencia, $idioma);
			$conferencia['datosArchivos']['tieneArchivos'] = true;
		} //Fin if
		else {
			$conferencia['datosArchivos']['tieneArchivos'] = false;
		} //Fin else
		$conferencia['conEvaluacion'] = $conferenciaDAO->fn_conferenciaConEvaluacion($iidConferencia, $idioma);
		$conferencia['ganoEvaluacion'] = $conferenciaDAO->fn_validarAprobacionConferencia($iidConferencia, $idUsuario);
		$conferencia['puntajeGamificacion'] = $conferenciaDAO->fn_validarUsuarioConferenciaGame($iidConferencia, $idUsuario);
		$conferencia['tipoConferencia'] = $conferenciaDAO->fn_traerTipoConferenciaConferencia($iidConferencia);
		$conferencia['tracks'] = $conferenciaDAO->fn_traerTracksConferenciaConferencia($iidConferencia);
		$conferencia['html'] = $conferenciaDAO->fn_retornarHtml($iidConferencia, $idioma);
		$conferencia['texto_html'] = $conferenciaDAO->fn_traerTexto($iidConferencia, $idioma);

		return $conferencia;
	} //Fin fn_retornarDatosPresentacionCompleta

	
	public function fn_leerConferencia2($idconferencia, $idUsuario) {
		$conferenciaDAO = new conferenciaDAO();
		$datosPresentaciones = $conferenciaDAO->fn_leerConferencia2($idconferencia, $idUsuario);
		return $datosPresentaciones;
	}

	public function fn_retornarDatosPresentacionCompletaVivo($iidConferencia, $idUsuario, $idioma = "") {
		if ($iidConferencia == "" || $iidConferencia == NULL) {
			throw new Exception('ERROR: Se necesita el codigo de la conferencia para poder cargar la informacion...');
		}
		$conferenciaDAO = new conferenciaDAO();
		$conferencia['datosConferencia'] = $conferenciaDAO->fn_leerConferencia($iidConferencia, $idioma);
		if ($conferenciaDAO->fn_existeArchivosConferencia($iidConferencia)) {
			$conferencia['datosArchivos'] = $conferenciaDAO->fn_leerArchivosConferencia($iidConferencia, $idioma);
			$conferencia['datosArchivos']['tieneArchivos'] = true;
		} else {
			$conferencia['datosArchivos']['tieneArchivos'] = false;
		}
		return $conferencia;
	}

	public function fn_traerModuloSiguientePosicion($iiMooduloo, $posModulo) {
		$conferenciaDAO = new conferenciaDAO();
		$datosPresentaciones['datosModulosNom']['nombremodulo'] = $conferenciaDAO->fn_traerModuloSiguientePosicion($iiMooduloo, $posModulo);
		$datosPresentaciones['datosModulosNom']['nombremoduloPadre'] = $conferenciaDAO->fn_traerNombreModuloPadre($iiMooduloo);
		$datosPresentaciones['datosModulosNom']['idPadrePrincipal'] = $conferenciaDAO->fn_traerIdModuloPadrePrincipal($iiMooduloo);
		$id = $datosPresentaciones['datosModulosNom']['idPadrePrincipal'];
		$datosPresentaciones['datosModulosNom']['nombremoduloPadrePrincipal'] = $conferenciaDAO->fn_traerNombreModuloPadrePrincipal($id);
		return $datosPresentaciones;
	}

	//Retornar Total Diapositivas presentaciones del modulo de conferencia.
	public function fn_retornarTotalDatosDiapositivaPresentacionesModulos($iidConferencia) {
		$conferenciaDAO = new conferenciaDAO();
		$datosDiapositivasPresentacion = NULL;
		if ($conferenciaDAO->fn_existeDiapositivasConferencia($iidConferencia)) {
			$datosDiapositivasPresentacion = $conferenciaDAO->fn_leerTotalDiapositivasConferencia($iidConferencia);
		}
		return $datosDiapositivasPresentacion;
	} //Fin fn_retornarTotalDatosDiapositivaPresentacionesModulos

	//Retornar Total archivos presentaciones del modulo de conferencia.
	public function fn_retornarDatosArchivoPresentacionesModulos($iidConferenciaArchivo) {
		$conferenciaDAO = new conferenciaDAO();
		$datosArchivosPresentacion = NULL;
		$datosArchivosPresentacion = $conferenciaDAO->fn_leerArchivoConferenciaModulos($iidConferenciaArchivo);
		return $datosArchivosPresentacion;
	} //Fin fn_retornarDatosarchivosPresentacionesModulos

	//Retornar Total Diapositivas presentaciones del modulo de conferencia.
	public function fn_retornarDatosDiapositivaPresentacionesModulos($idConferenciaDiapositiva) {
		$conferenciaDAO = new conferenciaDAO();
		$datosDiapositivasPresentacion = NULL;
		$datosDiapositivasPresentacion = $conferenciaDAO->fn_leerDiapositivasConferencias($idConferenciaDiapositiva);
		return $datosDiapositivasPresentacion;
	} //Fin fn_retornarDatosarchivosPresentacionesModulos

	//Retornar Total Archivos presentaciones del modulo de conferencia.
	public function fn_retornarTotalDatosArchivosPresentacionesModulos($iidConferencia) {
		$conferenciaDAO = new conferenciaDAO();
		$datosArchivosPresentacion = NULL;
		if ($conferenciaDAO->fn_existeArchivosConferencia($iidConferencia)) {
			$datosArchivosPresentacion = $conferenciaDAO->fn_leerTotalArchivosConferencia($iidConferencia);
		}
		return $datosArchivosPresentacion;
	} //Fin fn_retornarTotalDatosArchivosPresentacionesModulos

	//Retornar Total categorias del modulo de conferencia.
	public function fn_retornarTotalDatosCategoriasPresentacionesModulos($iidConferencia) {
		$conferenciaDAO = new conferenciaDAO();
		$datosCategoriasPresentacion = NULL;
		if ($conferenciaDAO->fn_existeCategoriasConferencia($iidConferencia)) {
			$datosCategoriasPresentacion = $conferenciaDAO->fn_leerTotalCategoriasConferencia($iidConferencia);
		}
		return $datosCategoriasPresentacion;
	} //Fin fn_retornarTotalDatosCategoriasPresentacionesModulos

	//Retornar Total categorias.
	public function fn_retornarTotalDatosCategorias() {
		$conferenciaDAO = new conferenciaDAO();
		$datosCategorias = NULL;
		$datosCategorias = $conferenciaDAO->fn_leerTotalCategorias();
		return $datosCategorias;
	} //Fin fn_retornarTotalDatosCategorias

	//Retornar Total categorias.
	public function fn_retornarTotalDatosCategoriasPerfil($idUsuarioAdmin, $perfil) {
		$conferenciaDAO = new conferenciaDAO();
		$datosCategorias = NULL;
		$datosCategorias = $conferenciaDAO->fn_leerTotalCategoriasPerfil($idUsuarioAdmin, $perfil);
		return $datosCategorias;
	} //Fin fn_retornarTotalDatosCategorias

	//Funcion cargar todas las preguntas de una presentacion.
	public function fn_cargarTotalPreguntasPresentacion($idconferencia) {
		if ($idconferencia == "" || $idconferencia == NULL) {
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo de la conferencia para poder leer las preguntas.');
		} //Fin if
		$conferenciaDAO = new conferenciaDAO();
		$datosPreguntas = $conferenciaDAO->fn_leerTotalPreguntasPresentacion($idconferencia);
		for ($i = 0; $i < count($datosPreguntas); $i++) {
			$datosPreguntas[$i]['respuestas'] = $conferenciaDAO->fn_leerTotalRespuestasPregunta($datosPreguntas[$i]['idconferencia_evaluacion']);
		} //Fin for
		$datosPreguntas['preguntasPorcentaje'] = $conferenciaDAO->fn_leerInformacionPorcentajeCantidadPreguntas($idconferencia);
		return $datosPreguntas;
	} //Fin fn_cargarTotalPreguntasPresentacion

	//Funcion cargar preguntas random de una presentacion.
	public function fn_cargarRandomPreguntasPresentacion($idconferencia, $idioma = "") {
		if ($idconferencia == "" || $idconferencia == NULL) {
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo de la conferencia para poder leer las preguntas.');
		} //Fin if
		$conferenciaDAO = new conferenciaDAO();
		$datosPreguntas2['preguntasPorcentaje'] = $conferenciaDAO->fn_leerInformacionPorcentajeCantidadPreguntas($idconferencia);
		$cantidadPreguntas = $datosPreguntas2['preguntasPorcentaje']['numeropreguntas'];
		if ($cantidadPreguntas > 0) {
			$datosPreguntas = $conferenciaDAO->fn_leerRandomPreguntasPresentacion($idconferencia, $idioma);
			for ($i = 0; $i < $cantidadPreguntas; $i++) {
				$datosPreguntas[$i]['respuestas'] = $conferenciaDAO->fn_leerTotalRespuestasPregunta($datosPreguntas[$i]['idconferencia_evaluacion'], $idioma);
			} //Fin for
		}
		$porcentajeGanarE = $datosPreguntas2['preguntasPorcentaje']['porcentajeganar'];
		$datosPreguntas['cantidadPreguntas'] = $cantidadPreguntas;
		$datosPreguntas['porcentajeganar'] = $porcentajeGanarE;
		return $datosPreguntas;
	} //Fin fn_cargarRandomPreguntasPresentacion

	//Funcion calificar preguntas de una presentacion.
	public function fn_calificarPreguntasPresentacion($respuestas, $totalPreguntas, $idUsuario, $idConferencia, $idioma = "") {
		$correctas = 0;
		$conferenciaDAO = new conferenciaDAO();
		for ($i = 0; $i < count($respuestas); $i++) {
			if ($conferenciaDAO->fn_esCorrectaRespuesta($respuestas[$i], $idioma)) {
				$correctas++;
			} //Fin if
		} //Fin for

		$calificacion = ($correctas * 100) / $totalPreguntas;
		$calificacion = number_format($calificacion, 0);
		$infoEvaluacion = false;
		$infoEvaluacion = $conferenciaDAO->fn_validarAprobacionConferencia($idConferencia, $idUsuario);
		if ($infoEvaluacion == false) {
			$conferenciaDAO->fn_ingresarEvaluacionPresentacion($calificacion, $idUsuario, $idConferencia);
		}
		return $calificacion;
	} //Fin fn_cargarRandomPreguntasPresentacion

	//Funcion traer la respuesta correcta de una pregunta.
	public function fn_consultarRespuestaCorrecta($evaluacion, $idioma = "") {
		$conferenciaDAO = new conferenciaDAO();
		$respuestaCorrecta = $conferenciaDAO->fn_traerCorrectaRespuesta($evaluacion, $idioma);
		return $respuestaCorrecta;
	} //Fin fn_consultarRespuestaCorrecta




	//Funcion de ingreso de archivo
	public function fn_ingresarDatosArchivoPresentacionModulos($archivo) {
		$ingreso = false;
		$conferenciaDAO = new conferenciaDAO();
		$conferenciaDAO->fn_insertarArchivoConferencia($archivo['idconferencia'], $archivo['dsnombre_archivo'], $archivo['dsdescripcion_archivo'], $archivo['dsruta_archivo'], $archivo['dsestado'], $archivo['idusuario_modificacion']);
		$ingreso = true;
		return $ingreso;
	} //Fin fn_ingresarDatosArchivoPresentacionModulos

	//Funcion que ingresa las categorias de una presentacion
	public function fn_ingresarDatosCategoriasPresentacionModulos($categorias) {
		$ingreso = false;
		$conferenciaDAO = new conferenciaDAO();
		$conferenciaDAO->fn_insertarCategoriasConferencia($categorias['idconferencia'], $categorias['idcategoria'], $categorias['idusuario_modificacion']);
		$ingreso = true;
		return $ingreso;
	} //Fin fn_ingresarDatosArchivoPresentacionModulos


	//Funcion de ingreso de presentacion
	public function fn_ingresarDatosPresentacionModulos($archivo, $idioma = "") {
		$ingreso = false;
		$conferenciaDAO = new conferenciaDAO();
		$scormDAO = new scormDAO();
		$idConferencia = $conferenciaDAO->fn_ingresarConferencia($archivo['dsnombre_conferencia'], $archivo['dsautor_conferencia'], $archivo['dsservidor_streaming'], $archivo['dsnombre_archivo'], $archivo['nmduracion_conferencia'], $archivo['dsruta_imagen_conferencia'], $archivo['dscomentario_conferencia'], $archivo['dsdiploma_conferencia'], $archivo['febaja'], $archivo['dsestado_conferencia'], $archivo['idusuario_modificacion'], $idioma);

		if ($archivo['tipoconf'] == "7") {
			$rutaScorm   = $idioma . "/" . $archivo['rutaScorm'];
			$idScorm     = $scormDAO->fn_ingresarScorm($idConferencia, $archivo['dsnombre_conferencia'], $idioma);
			$idScormN    = $scormDAO->fn_ingresarScormNegativo(-$idScorm, -$idConferencia, $archivo['dsnombre_conferencia'], $idioma);
			$scormScoes  = $scormDAO->fn_ingresarScormScoes($idScorm, $rutaScorm, $archivo['dsnombre_conferencia'], $idioma);
			$scormScoesN = $scormDAO->fn_ingresarScormScoesNegativo(-$idScorm, $rutaScorm, $archivo['dsnombre_conferencia'], $idioma);
		} else if ($archivo['tipoconf'] == "8") {
			$ingresarCapSerie = $conferenciaDAO->ingresarCapituloSerie($idConferencia, $archivo['videoEmbed'], $archivo['tipoChat'], $archivo['chat'], $archivo['tiempomin'], $archivo['fechav'], $archivo['horav'], $archivo['destac'], $archivo['estadoMomento'], $archivo['param']);
		}

		if ($idioma == '') {
			//Validar para insertar SCORM	
			$conferenciaDAO->fn_ingresarRelacionConferenciaModulo($archivo['modconferencia'], $idConferencia, $archivo['idusuario_modificacion']);
			//$limpiarCategorias = $conferenciaDAO->fn_eliminarTodasCategoriasConferencia($idConferencia);
			$idTipoconf = $conferenciaDAO->fn_ingresarTipoConferencia($idConferencia, $archivo['idusuario_modificacion'], $archivo['tipoconf']);
			if ($archivo['tutores'] != null) {
				$tutor = array_values($archivo['tutores']);
				for ($i = 0; $i < count($tutor); $i++) {
					$conferenciaDAO->fn_ingresarConferenciaModuloTutor($tutor[$i], $idConferencia, $archivo['idusuario_modificacion']);
				}
			}
			$ingreso = true;
			$this->fn_ingresoEncuestaConferencia($archivo['idusuario_modificacion']);
		}
		return $idConferencia;
	} //Fin fn_ingresarDatosPresentacionModulos

	//Funcion de ingreso de diapositivas
	public function fn_ingresarDatosDiapositivasPresentacionModulos($diapositivas, $idioma = "") {
		$ingreso = false;
		$conferenciaDAO = new conferenciaDAO();
		for ($i = 0; $i < count($diapositivas); $i++) {
			$conferenciaDAO->fn_insertarDiapositivaConferencia($diapositivas[$i]['idconferencia'], $diapositivas[$i]['dsnombre_diapositiva'], $diapositivas[$i]['nmtiempo_inicia_diapositiva'], $diapositivas[$i]['dsruta_imagen_diapositiva'], $diapositivas[$i]['dsestado'], $diapositivas[$i]['idusuario_modificacion'], $idioma);
			$ingreso = true;
		} //Fin for
		return $ingreso;
	} //Fin fn_ingresarDatosDiapositivasPresentacionModulos

	//Funcion de ingreso de una pregunta.
	public function fn_ingresarUnaPreguntaPresentacionModulos($pregunta, $respuestas) {
		$idioma = "";
		$conferenciaDAO = new conferenciaDAO();
		$idConferenciaEvaluacion = $conferenciaDAO->fn_insertarPreguntaConferencia($pregunta['idconferencia'], $pregunta['dsdescripcion_pregunta'], $pregunta['idusuario_modificacion']);
		for ($i = 0; $i < count($respuestas); $i++) {
			$conferenciaDAO->fn_insertarRespuestaPregunta($idConferenciaEvaluacion, $respuestas[$i]['dsdescripcion_respuesta'], $respuestas[$i]['dscorrecta'], $respuestas[$i]['idusuario_modificacion']);
		} //Fin for
		return $idConferenciaEvaluacion;
	} //Fin fn_ingresarUnaPreguntaPresentacionModulos

	//Fincion ingreso de estadisticas a una conferencia.
	public function fn_ingresoConferencia($idConferencia, $idUsuarioWeb) {
		$ingresoConferencia = new ingresosConferenciaDAO();
		$ingresoConferencia->fn_ingresarIngresoConferencia($idConferencia, $idUsuarioWeb);
	} //Fin fn_ingresoConferencia



	//Funcion ingreso encuesta a las conferencias que faltan.
	public function fn_ingresoEncuestaConferencia($idUsuarioAdministrador) {
		$conferenciaDAO = new conferenciaDAO();
		$idConferencias = $conferenciaDAO->fn_retornarConferenciasCanal();
		for ($i = 0; $i < count($idConferencias); $i++) {
			if (!$conferenciaDAO->fn_existeEncuestaConferencia($idConferencias[$i])) {
				$conferenciaDAO->fn_ingresarEncuestaPresentacion($idConferencias[$i], $idUsuarioAdministrador);
			} //Fin if
		} //Fin for
	} //Fin fn_ingresoEncuestaConferencia


	//Funcion que edita los datos de una presentacion
	public function fn_editarDatosPresentacionModulos($archivo, $idioma = "") {
		$ingreso = false;
		$conferenciaDAO = new conferenciaDAO();
		$idConferencia = $conferenciaDAO->fn_editarConferencia($archivo['idconferencia'], $archivo['dsnombre_conferencia'], $archivo['dsautor_conferencia'], $archivo['dsservidor_streaming'], $archivo['dsnombre_archivo'], $archivo['nmduracion_conferencia'], $archivo['dscomentario_conferencia'], $archivo['dsdiploma_conferencia'], $archivo['febaja'], $archivo['dsestado_conferencia'], $archivo['idusuario_modificacion'], $idioma);
		$limpiarCategorias = $conferenciaDAO->fn_eliminarTodasCategoriasConferenciaUsuarios($archivo['idconferencia']);
		$tutor = array_values($archivo['tutores']);
		for ($i = 0; $i < count($tutor); $i++) {
			$conferenciaDAO->fn_ingresarConferenciaModuloTutor($tutor[$i], $archivo['idconferencia'], $archivo['idusuario_modificacion']);
		}

		$ingreso = true;
		return $ingreso;
	} //Fin fn_editarDatosPresentacionModulos

	public function fn_modificarModulo_perfil($datosIngreso, $idioma) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$moduloConferenciaDAO->fn_eliminarModulo_perfil($datosIngreso['modConferencia']);
		$moduloConferenciaDAO->fn_ingresarModulo_perfil($datosIngreso['modConferencia'], $datosIngreso['perfil'], $datosIngreso['iidUsuarioModificador'], $idioma);
	}

	public function fn_modificarModuloNivel($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$moduloConferenciaDAO->fn_eliminarModuloNivel($datosIngreso['modConferencia']);
		$moduloConferenciaDAO->fn_ingresarNivelCurso($datosIngreso['modConferencia'], $datosIngreso['iidNivel'], $datosIngreso['iidUsuarioModificador']);
	}

	public function fn_modificarModulo_segmento($datosIngreso, $idioma) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$moduloConferenciaDAO->fn_eliminarModulo_segmento($datosIngreso['modConferencia']);

		$moduloConferenciaDAO->fn_ingresarModulo_segmento($datosIngreso['modConferencia'], $datosIngreso['segmento'], $datosIngreso['iidUsuarioModificador'], $idioma);
	}

	/**
	 * modificarContenidoEtiquetas
	 *
	 * @param  int $idContenido
	 * @param  array $etiquetas
	 * @param  int $idUsuario
	 * @return void
	 */
	public function modificarContenidoEtiquetas($idContenido, $etiquetas, $idUsuario) {
		$etiquetasDAO = new etiquetaDAO();

		$etiquetasDAO->eliminarEtiquetasContenido($idContenido);

		$etiquetasDAO->agregarEtiquetaConferencia($idContenido, $etiquetas, $idUsuario);
	}

	/**
	 * modificarContenidoTematicas
	 *
	 * @param  int $idContenido
	 * @param  array $etiquetas
	 * @param  int $idUsuario
	 * @return void
	 */
	public function modificarContenidoTematicas($idContenido, $etiquetas, $idUsuario) {
		$tematicasDAO = new tematicaDAO();

		$tematicasDAO->eliminarTematicasContenido($idContenido);

		$tematicasDAO->agregarTematicaConferencia($idContenido, $etiquetas, $idUsuario);
	}

	//Editar un modulo de conferencia
	public function fn_editarModuloConferencia($datosIngreso, $idioma = "") {
		if ($datosIngreso['modConferencia'] == "" || $datosIngreso['modConferencia'] == NULL) {
			throw new Exception('ERROR: Se require el id del Modulo que se quiere editar');
		} //Fin if
		if ($datosIngreso['idsNombreModulo'] == "" || $datosIngreso['idsNombreModulo'] == NULL) {
			throw new Exception('ERROR: Se require el hombre del modulo conferencia');
		} //Fin if
		if ($datosIngreso['idsDescipcionModulo'] == "" || $datosIngreso['idsDescipcionModulo'] == NULL) {
			throw new Exception('ERROR: Se require la descripcion');
		} //Fin if
		if ($datosIngreso['idsRutaImagenModulo'] == "" || $datosIngreso['idsRutaImagenModulo'] == NULL) {
			throw new Exception('ERROR: Se require la ruta de la imagen');
		} //Fin if
		if ($datosIngreso['idsTipoVisualizacion'] == "" || $datosIngreso['idsTipoVisualizacion'] == NULL) {
			throw new Exception('ERROR: Se require el typo de visualization del modulo');
		} //Fin if
		if ($datosIngreso['idsTieneDipoma'] == "" || $datosIngreso['idsTieneDipoma'] == NULL) {
			$datosIngreso['idsTieneDipoma'] = 'N';
		} //Fin if
		if ($datosIngreso['idsEvaluacionModulo'] == "" || $datosIngreso['idsEvaluacionModulo'] == NULL) {
			$datosIngreso['idsEvaluacionModulo'] = 'N';
		} //Fin if
		if ($datosIngreso['ifebaja'] == "" || $datosIngreso['ifebaja'] == NULL) {
			throw new Exception('ERROR: Se requiere la fecha de finalizacion');
		} //Fin if
		if ($datosIngreso['iidUsuarioModificador'] == "" || $datosIngreso['iidUsuarioModificador'] == NULL) {
			throw new Exception('ERROR: Se requiere el código del usuario que esta agregando este modulo');
		} //Fin if

		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$datos = $moduloConferenciaDAO->fn_modificarModulo($datosIngreso['modConferencia'], $datosIngreso['iidmoduloPadre'], $datosIngreso['idsNombreModulo'], $datosIngreso['idsDescipcionModulo'], $datosIngreso['idsRutaImagenModulo'], $datosIngreso['idsTipoVisualizacion'], $datosIngreso['idsTieneDipoma'], $datosIngreso['idsEvaluacionModulo'], $datosIngreso['ifebaja'], $datosIngreso['iidUsuarioModificador'], $datosIngreso['tipoprograma'], $datosIngreso['horascert'], $datosIngreso['infoautor'], $datosIngreso['autor'], $idioma);

		/** informacion adicional(segmento, perfil, informacion) */

		$datos22 = $moduloConferenciaDAO->fn_modificarModulo_informacion($datosIngreso['modConferencia'], $datosIngreso['informacion'], $datosIngreso['iidUsuarioModificador'], $idioma);

		$this->fn_modificarModulo_perfil($datosIngreso, $idioma);
		$this->fn_modificarModulo_segmento($datosIngreso, $idioma);
		$this->fn_modificarModuloNivel($datosIngreso);
		$this->fn_modificarDestacadoCurso($datosIngreso);
		//Etiquetas y tematicas
		$this->modificarContenidoEtiquetas($datosIngreso['modConferencia'], $datosIngreso['etiquetas'], $datosIngreso['iidUsuarioModificador']);
		$this->modificarContenidoTematicas($datosIngreso['modConferencia'], $datosIngreso['tematicas'], $datosIngreso['iidUsuarioModificador']);

		return $datos;
	}


	//Editar un modulo de conferencia
	public function fn_editarModuloConferencia2($datosIngreso, $idioma = "") {
		if ($datosIngreso['modConferencia'] == "" || $datosIngreso['modConferencia'] == NULL) {
			throw new Exception('ERROR: Se require el id del Modulo que se quiere editar');
		} //Fin if
		if ($datosIngreso['idsNombreModulo'] == "" || $datosIngreso['idsNombreModulo'] == NULL) {
			throw new Exception('ERROR: Se require el hombre del modulo conferencia');
		} //Fin if
		if ($datosIngreso['idsDescipcionModulo'] == "" || $datosIngreso['idsDescipcionModulo'] == NULL) {
			throw new Exception('ERROR: Se require la descripcion');
		} //Fin if
		if ($datosIngreso['idsRutaImagenModulo'] == "" || $datosIngreso['idsRutaImagenModulo'] == NULL) {
			throw new Exception('ERROR: Se require la ruta de la imagen');
		} //Fin if
		if ($datosIngreso['idsTipoVisualizacion'] == "" || $datosIngreso['idsTipoVisualizacion'] == NULL) {
			throw new Exception('ERROR: Se require el typo de visualization del modulo');
		} //Fin if
		if ($datosIngreso['idsTieneDipoma'] == "" || $datosIngreso['idsTieneDipoma'] == NULL) {
			$datosIngreso['idsTieneDipoma'] = 'N';
		} //Fin if
		if ($datosIngreso['idsEvaluacionModulo'] == "" || $datosIngreso['idsEvaluacionModulo'] == NULL) {
			$datosIngreso['idsEvaluacionModulo'] = 'N';
		} //Fin if
		if ($datosIngreso['ifebaja'] == "" || $datosIngreso['ifebaja'] == NULL) {
			throw new Exception('ERROR: Se requiere la fecha de finalizacion');
		} //Fin if
		if ($datosIngreso['iidUsuarioModificador'] == "" || $datosIngreso['iidUsuarioModificador'] == NULL) {
			throw new Exception('ERROR: Se requiere el código del usuario que esta agregando este modulo');
		} //Fin if
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datos = $moduloConferenciaDAO->fn_modificarModulo2($datosIngreso['modConferencia'], $datosIngreso['iidmoduloPadre'], $datosIngreso['idsNombreModulo'], $datosIngreso['idsDescipcionModulo'], $datosIngreso['idsRutaImagenModulo'], $datosIngreso['idsTipoVisualizacion'], $datosIngreso['idsTieneDipoma'], $datosIngreso['idsEvaluacionModulo'], $datosIngreso['ifealta'], $datosIngreso['ifebaja'], $datosIngreso['iidUsuarioModificador'], $datosIngreso['tipoprograma'], $datosIngreso['horascert'], $datosIngreso['infoautor'], $datosIngreso['autor'], $idioma);
		return $datos;
	} //Fin fn_editarModuloConferencia


	//Funcion que edita los datos de Archivo
	public function fn_editarArchivoConferenciaModulos($archivo) {
		$ingreso = false;
		$conferenciaDAO = new conferenciaDAO();
		$ingreso = $conferenciaDAO->fn_editarArchivo($archivo['idconferencia_archivo'], $archivo['dsnombre_archivo'], $archivo['dsdescripcion_archivo'], $archivo['dsestado'],  $archivo['idusuario_modificacion']);
		return true;
	} //Fin fn_editarArchivoConferenciaModulos

	//Funcion que edita los datos de Diapositiva
	public function fn_editarDiapositivasPresentacionModulos($archivo) {
		$ingreso = false;
		$conferenciaDAO = new conferenciaDAO();
		$ingreso = $conferenciaDAO->fn_editarDiapositiva($archivo['idconferencia_diapositiva'], $archivo['dsnombre_diapositiva'], $archivo['nmtiempo_inicia_diapositiva'], $archivo['dsruta_imagen_diapositiva'],  $archivo['dsestado'],  $archivo['idusuario_modificacion']);
		return $ingreso;
	} //Fin fn_editarDiapositivasPresentacionModulos

	//Funcion que elimina todas las diapositivas de una presentacion.
	public function fn_eliminarDiapositivasConferenciaModulos($idconferencia) {
		if ($idconferencia == "" || $idconferencia == NULL) {
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo de la conferencia para poder eliminar la informacion.');
		} //Fin if
		$conferenciaDAO = new conferenciaDAO();
		$eliminar = $conferenciaDAO->fn_eliminarDiapositivasConferencia($idconferencia);
		return $eliminar;
	} //Fin fn_eliminarDiapositivasPresentacionModulos

	//Funcion que elimina todas las archivos de una presentacion.
	public function fn_borrarArchivosConferenciaModulos($idConferenciaArchivo) {
		if ($idConferenciaArchivo == "" || $idConferenciaArchivo == NULL) {
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo de la conferencia para poderborrar la informacion.');
		} //Fin if
		$conferenciaDAO = new conferenciaDAO();
		$eliminar = $conferenciaDAO->fn_borrarArchivosConferencia($idConferenciaArchivo);
		return $eliminar;
	} //Fin fn_eliminarDiapositivasPresentacionModulos

	//Funcion que elimina todas las categorias de una presentacion.
	public function fn_borrarCategoriasConferenciaModulos($idConferenciaCategoria) {
		if ($idConferenciaCategoria == "" || $idConferenciaCategoria == NULL) {
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo de la id de la categoria conferencia para poder borrar la informacion.');
		} //Fin if
		$conferenciaDAO = new conferenciaDAO();
		$eliminar = $conferenciaDAO->fn_borrarCategoriasConferencia($idConferenciaCategoria);
		return $eliminar;
	} //Fin fn_borrarCategoriasConferencia

	//Funcion que elimina una pregunta de una presentacion.
	public function fn_borrarUnaPreguntaPresentacion($idconferenciaEvaluacion) {
		if ($idconferenciaEvaluacion == "" || $idconferenciaEvaluacion == NULL) {
			//Muestra el error del codigo del canal ya que es obligatorio para hacer la busqueda.
			throw new Exception('ERROR: Se necesita el codigo de la id de la pregunta para poder ser borrada.');
		} //Fin if
		$conferenciaDAO = new conferenciaDAO();
		$eliminar = $conferenciaDAO->fn_borrarPreguntaConferencia($idconferenciaEvaluacion);
		return $eliminar;
	} //Fin fn_borrarUnaPreguntaPresentacion

	//funcion retorna todas las conferencias que existen, en orden de ID
	public function fn_retornarTotalConferencias() {
		$conferenciaDAO = new conferenciaDAO();
		$datosConferencia = $conferenciaDAO->fn_retornarTotalConferencias();
		return $datosConferencia;
	} //Fin fn_retornarTotalConferencias


	//funcion retorna todas las conferencias que existen asociadas a una perfil SuperTutor
	public function fn_retornarTotalConferenciasPerfiladoSuperTutor($idAdministrador) {
		$conferenciaDAO = new conferenciaDAO();
		$datosConferencia = $conferenciaDAO->fn_retornarTotalConferenciasPerfiladoSuperTutor($idAdministrador);
		return $datosConferencia;
	} //Fin fn_retornarTotalConferenciasPerfilado

	//funcion retorna todas las conferencias que existen asociadas a una perfil Tutor
	public function fn_retornarTotalConferenciasPerfiladoTutor($idAdministrador) {
		$conferenciaDAO = new conferenciaDAO();
		$datosConferencia = $conferenciaDAO->fn_retornarTotalConferenciasPerfiladoTutor($idAdministrador);
		return $datosConferencia;
	} //Fin fn_retornarTotalConferenciasPerfilado


	public function fn_retornarDatosConferencias($idconferencia) {
		$conferenciaDAO = new conferenciaDAO();
		$datosConferencia = $conferenciaDAO->fn_leerConferencia($idconferencia);
		return $datosConferencia;
	} //Fin fn_retornarTotalConferencias

	public function fn_validarConferenciaPermitidaAusuario($idconferencia, $idsCategoriaUsuario) {
		$conferenciaDAO = new conferenciaDAO();

		for ($ct = 0; $ct < count($idsCategoriaUsuario); $ct++) {
			$datosConferencia = $conferenciaDAO->fn_validarConferenciaPermitidaAusuario($idconferencia, $idsCategoriaUsuario[$ct]['idcategoria']);

			if ($datosConferencia != 0) {
				return $datosConferencia;
			}
		}
		return $datosConferencia;
	} //Fin fn_retornarTotalConferencias	


	public function fn_guardarConfiguracionPreguntasProcentaje($idPresentacion, $numPreguntas, $porcentajeGanar) {
		$conferenciaDAO = new conferenciaDAO();
		$datosConferencia = $conferenciaDAO->fn_guardarConfiguracionPreguntasProcentaje($idPresentacion, $numPreguntas, $porcentajeGanar);
		return $datosConferencia;
	}

	//Retorna los datos de la plantilla activa de un canal
	public function fn_retornarDatosConferenciasCategoriasGrupos($idConferencia) {
		$omoduloConferencia = 0;
		if ($idConferencia == "" || $idConferencia == NULL) {
			throw new Exception('ERROR: Se necesita el codigo de la conferencia para poder cargar la informacion*');
		} //Fin if
		$conferenciaDAO = new conferenciaDAO();
		$conferenciaCtGr['categorias'] = $conferenciaDAO->fn_leerConferenciaPorCategoriasGrupos($idConferencia);
		$conferenciaCtGr['grupos'] = $conferenciaDAO->fn_leerConferenciaPorCategoriasGruposUsuarios($idConferencia);
		return $conferenciaCtGr;
	} //Fin fn_retornarDatosIntroduccionCanal



	//Retornar los ids de los submodulos del modulo de conferencias
	public function fn_retornarIdSubModulosConferencia($iidModuloConferencia) {
		$moduloConferenciaDAO = new conferenciaDAO();
		$idModulos = $moduloConferenciaDAO->fn_retornarConferenciasModulo($iidModuloConferencia);
		return $idModulos;
	} //Fin fn_retornarIdSubModulosConferencia

	//Funcion cargar todas las preguntas de una presentacion.
	public function fn_cargarTotalPreguntasPresentacionCurso($idModulo) {
		$conferenciaDAO = new conferenciaDAO();
		$datosPreguntas = $conferenciaDAO->fn_leerTotalPreguntasPresentacion($idModulo);
		for ($i = 0; $i < count($datosPreguntas); $i++) {
			$datosPreguntas[$i]['respuestas'] = $conferenciaDAO->fn_leerTotalRespuestasPregunta($datosPreguntas[$i]['idconferencia_evaluacion']);
		} //Fin for
		$datosPreguntas['preguntasPorcentaje'] = $conferenciaDAO->fn_leerInformacionPorcentajeCantidadPreguntas($idModulo);
		return $datosPreguntas;
	} //Fin fn_cargarTotalPreguntasPresentacion



	public function fn_leerInformacionPorcentajeCantidadPreguntas($idConferencia) {
		$conferenciaDAO = new conferenciaDAO();
		$datosPreguntas = $conferenciaDAO->fn_leerInformacionPorcentajeCantidadPreguntas($idConferencia);
		return $datosPreguntas;
	} //Fin fn_leerInformacionPorcentajeCantidadPreguntas





	//Funcion que verifica si una presentacion ya fue aprobada (CURSO)
	public function fn_validarAprobacionConferenciaCurso($idModulo, $idUsuario) {
		$conferenciaDAO = new conferenciaDAO();
		$infoEvaluacion = $conferenciaDAO->fn_validarAprobacionConferencia($idModulo, $idUsuario);
		return $infoEvaluacion;
	} //Fin fn_cargarTotalPreguntasPresentacion


	public function fn_retornarInformacionModuloEspecifico($iidModuloConferencia, $idioma = "") {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$omoduloConferencia = $moduloConferenciaDAO->fn_leerModuloConferencia($iidModuloConferencia, $idioma);
		return $omoduloConferencia;
	}

	public function fn_validarAprobadoEvaluacionCurso($idModuloCurso, $idUsuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$omoduloConferencia = $moduloConferenciaDAO->fn_validarAprobadoEvaluacionCurso($idModuloCurso, $idUsuario);
		return $omoduloConferencia;
	}

	public function fn_validarFechaEvaluacionCurso($idModuloCurso, $idUsuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$omoduloConferencia = $moduloConferenciaDAO->fn_validarFechaEvaluacionCurso($idModuloCurso, $idUsuario);
		$fechaEvaluacionSuperada = $this->traductor($omoduloConferencia);
		return $fechaEvaluacionSuperada;
	}

	public function traductor($fecha) {

		$porciones = explode(" ", $fecha);
		$año = $porciones[2];
		$meses = array(
			"Enero" => "January",
			"Febrero" => "February",
			"Marzo" => "March",
			"Abril" => "April",
			"Mayo" => "May",
			"Junio" => "June",
			"Julio" => "July",
			"Agosto" => "August",
			"Septiembre" => "September",
			"Octubre" => "October",
			"Noviembre" => "November",
			"Diciembre" => "December"
		);

		foreach ($meses as $nombre_espanol => $nombre_ingles) {
			$mes = array_search($porciones[1], $meses); // busqueda de la posición con ayuda de una función php                                            
		}

		return $porciones[0] . " " . $mes . " " . $año;
	}

	public function fn_leerDatosModuloPorPadre($idConsultar) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$omoduloConferencia = $moduloConferenciaDAO->fn_leerModuloConferencia($idConsultar);
		return $omoduloConferencia;
	}

	//Fincion ingreso de estadisticas de detalles tecnicos.
	public function fn_ingresoConferenciaTecnicos($idConferencia, $idUsuarioWeb) {
		$ip = "";
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if (isset($_SERVER['HTTP_VIA'])) {
			$ip = $_SERVER['HTTP_VIA'];
		} else if (isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		/*$meta = unserialize(file_get_contents('https://www.geoplugin.net/php.gp?ip='.$ip));

		$latitude = $meta['geoplugin_latitude'];
		$longitude = $meta['geoplugin_longitude'];
		$country_code = $meta['geoplugin_countryCode'];
		$country_name = $meta['geoplugin_countryName'];
		$region_name = $meta['geoplugin_regionName'];
		$ciudad = $meta['geoplugin_city'];*/

		$latitude = $_SERVER['REQUEST_URI'];
		isset($_SERVER['HTTP_REFERER']) ? $longitude = $_SERVER['HTTP_REFERER'] : $longitude = 'local';
		$country_code = $_SERVER['PHP_SELF'];
		$country_name = $_SERVER['DOCUMENT_ROOT'];
		$region_name = $_SERVER['REQUEST_TIME'];
		$city = $_SERVER['SCRIPT_FILENAME'];

		$agente = $_SERVER['HTTP_USER_AGENT'];
		$navegador = 'Unknown';
		$platforma = 'Unknown';
		$version = "";

		//Obtenemos la Plataforma
		if (preg_match('/linux/i', $agente)) {
			$platforma = 'linux';
		} elseif (preg_match('/macintosh|mac os x/i', $agente)) {
			$platforma = 'mac';
		} elseif (preg_match('/windows|win32/i', $agente)) {
			$platforma = 'windows';
		}

		//Obtener el UserAgente
		/*if(preg_match('/MSIE/i',$agente) && !preg_match('/Opera/i',$agente)){
			$navegador = 'Internet Explorer';
			$navegador_corto = "MSIE";
		}elseif(preg_match('/Firefox/i',$agente)){
			$navegador = 'Mozilla Firefox';
			$navegador_corto = "Firefox";
		}elseif(preg_match('/Chrome/i',$agente)){
			$navegador = 'Google Chrome';
			$navegador_corto = "Chrome";
		}elseif(preg_match('/Safari/i',$agente)){
			$navegador = 'Apple Safari';
			$navegador_corto = "Safari";
		}elseif(preg_match('/Opera/i',$agente)){
			$navegador = 'Opera';
			$navegador_corto = "Opera";
		}elseif(preg_match('/Netscape/i',$agente)){
			$navegador = 'Netscape';
			$navegador_corto = "Netscape";
		}

		// Obtenemos la Version
		$known = array('Version', $navegador_corto, 'other');
		$pattern = '#(?' . join('|', $known) .
		')[/ ]+(?[0-9.|a-zA-Z.]*)#';

		$i = count($matches['browser']);
		if ($i != 1) {
			if (strripos($agente,"Version") < strripos($agente,$navegador_corto)){
				$version= $matches['version'][0]; 
			}else{ 
				$version= $matches['version'][1]; 
			} 
		}else{
			$version= $matches['version'][0]; 
		} 
		if ($version==null || $version=="") {
			$version="?";
		}*/
        $version=="" ? $version = "-" : '';
		$ingresoConferencia = new moduloConferenciaDAO();
		$ingresoConferencia->fn_ingresarIngresoConferenciaTecnico($idConferencia, $idUsuarioWeb, $country_code,  $country_name, $region_name, $city, $latitude,  $longitude, $ip, $agente, $navegador, $version, $platforma);
	} //Fin fn_ingresoConferencia

	//Funcion calificar preguntas de una presentacion.
	public function fn_guardarEvaluacionPresentacion($usuario, $respuestasBuenas, $tiempo, $intentos, $intentosErroneos, $intentosExitosos, $idConferencia, $preguntasJuego) {
		$conferenciaDAO = new conferenciaDAO();
		$preguntasJuego = (int)$preguntasJuego;
		$intentosExitosos = (int)$intentosExitosos;
		if ($preguntasJuego == $intentosExitosos) {
			$resultado[1] = $conferenciaDAO->fn_ingresarEvaluacionPresentacion(100, $usuario, $idConferencia);
			$resultado[0] = $conferenciaDAO->fn_ingresarEvaluacionPresentacionJuego($usuario, $respuestasBuenas, $tiempo, $intentos, $intentosErroneos, $intentosExitosos, $idConferencia, $preguntasJuego);
		} else {
			$resultado[0] = $conferenciaDAO->fn_ingresarEvaluacionPresentacionJuego($usuario, $respuestasBuenas, $tiempo, $intentos, $intentosErroneos, $intentosExitosos, $idConferencia, $preguntasJuego);
		}
		return $resultado[0];
	} //Fin fn_cargarRandomPreguntasPresentacion

	//Funcion calificar preguntas de una presentacion.
	public function actualizarNombreAudio($idConferencia, $nombreArchivo, $idioma = "") {
		$conferenciaDAO = new conferenciaDAO();

		$resultado = $conferenciaDAO->actualizarNombreAudio($idConferencia, $nombreArchivo, $idioma);

		return $resultado;
	} //Fin fn_cargarRandomPreguntasPresentacion


	public function fn_agregarModuloConferencia($datosIngreso, $id_certificado, $idAdmon, $idioma = "") {
		if ($datosIngreso['idsNombreModulo'] == "" || $datosIngreso['idsNombreModulo'] == NULL) {
			throw new Exception('ERROR: Se require el hombre del modulo conferencia');
		} //Fin if
		if ($datosIngreso['idsDescipcionModulo'] == "" || $datosIngreso['idsDescipcionModulo'] == NULL) {
			throw new Exception('ERROR: Se require la descripcion');
		} //Fin if
		if ($datosIngreso['idsRutaImagenModulo'] == "" || $datosIngreso['idsRutaImagenModulo'] == NULL) {
			throw new Exception('ERROR: Se require la ruta de la imagen');
		} //Fin if
		if ($datosIngreso['idsTipoVisualizacion'] == "" || $datosIngreso['idsTipoVisualizacion'] == NULL) {
			throw new Exception('ERROR: Se require el tipo de visualization del modulo');
		} //Fin if
		if ($datosIngreso['idsTieneDipoma'] == "" || $datosIngreso['idsTieneDipoma'] == NULL) {
			$datosIngreso['idsTieneDipoma'] = 'N';
		} //Fin if
		if ($datosIngreso['idsEvaluacionModulo'] == "" || $datosIngreso['idsEvaluacionModulo'] == NULL) {
			$datosIngreso['idsEvaluacionModulo'] = 'N';
		} //Fin if
		if ($datosIngreso['ifealta'] == "" || $datosIngreso['ifealta'] == NULL) {
			throw new Exception('ERROR: Se require la fecha de inicio');
		} //Fin if
		if ($datosIngreso['ifebaja'] == "" || $datosIngreso['ifebaja'] == NULL) {
			throw new Exception('ERROR: Se requiere la fecha de finalizacion');
		} //Fin if
		if ($datosIngreso['iidUsuarioModificador'] == "" || $datosIngreso['iidUsuarioModificador'] == NULL) {
			throw new Exception('ERROR: Se requiere el código del usuario que esta agregando este modulo');
		} //Fin if
		if ($datosIngreso['iidNivel'] == "" || $datosIngreso['iidNivel'] == NULL) {
			throw new Exception('ERROR: Se requiere el código del nivel');
		}

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$etiquetaDao = new etiquetaDAO();
		$tematicaDao = new tematicaDAO();

		$oidModuloConferencia = $moduloConferenciaDAO->fn_ingresarModulo($datosIngreso['iidmoduloPadre'], $datosIngreso['idsNombreModulo'], $datosIngreso['idsDescipcionModulo'], $datosIngreso['idsRutaImagenModulo'], $datosIngreso['idsTipoVisualizacion'], $datosIngreso['idsTieneDipoma'], $datosIngreso['idsEvaluacionModulo'], $datosIngreso['ifealta'], $datosIngreso['ifebaja'], $datosIngreso['iidUsuarioModificador'], $idioma, $datosIngreso['titulotexto'], $datosIngreso['autor']);
		$moduloConferenciaDAO->fn_ingresarNivelCurso($oidModuloConferencia, $datosIngreso['iidNivel'], $datosIngreso['iidUsuarioModificador']);
		/** informacion adicional(segmento, perfil, informacion) */
		$moduloConferenciaDAO->fn_ingresarModulo_informacion($oidModuloConferencia, $datosIngreso['informacion'], $datosIngreso['iidUsuarioModificador'], $idioma);
		$moduloConferenciaDAO->fn_ingresarModulo_perfil($oidModuloConferencia, $datosIngreso['perfil'], $datosIngreso['iidUsuarioModificador'], $idioma);
		$moduloConferenciaDAO->fn_ingresarModulo_segmento($oidModuloConferencia, $datosIngreso['segmento'], $datosIngreso['iidUsuarioModificador'], $idioma);
		$moduloConferenciaDAO->fn_ingresarCursoDestacado($datosIngreso['cursos'], $datosIngreso['iidUsuarioModificador'], $oidModuloConferencia);

		// $etiquetaDao->agregarEtiquetaConferencia($oidModuloConferencia, $datosIngreso['etiquetas'], $datosIngreso['iidUsuarioModificador']);
		// $tematicaDao->agregarTematicaConferencia($oidModuloConferencia, $datosIngreso['tematicas'], $datosIngreso['iidUsuarioModificador']);

		if ($id_certificado != 0) {
			$insertarDatos = $moduloConferenciaDAO->fn_ingresarDatosModuloCertificado($oidModuloConferencia, $id_certificado, $idAdmon, $idioma);
		}

		return $oidModuloConferencia;
	}


	public function fn_informacionConferenciaHtml($idconferencia, $idadmin, $html, $idioma = "") {
		$conferenciaHtml = new conferenciaDAO();
		$informacionConferencia = $conferenciaHtml->fn_informacionConferenciaHtml($idconferencia, $idadmin, $html, $idioma);
		return $informacionConferencia;
	}

	public function fn_retornarHtml($idconferencia, $idioma = "") {

		$conferenciaDAO = new conferenciaDAO();
		$retornarHtml = $conferenciaDAO->fn_retornarHtml($idconferencia, $idioma);
		return $retornarHtml;
	}

	public function fn_modificarHtml($idconferencia, $idusuarioadmon, $contenido, $idioma = "") {
		$conferenciaDAO = new conferenciaDAO();
		$modificarHtml = $conferenciaDAO->fn_modificarHtml($idconferencia, $idusuarioadmon, $contenido, $idioma);
		return $modificarHtml;
	}

	public function fn_traerTexto($idConferencia) {
		$conferenciaDAO = new conferenciaDAO();
		$texto = $conferenciaDAO->fn_traerTexto($idConferencia);
		return $texto;
	}

	public function fn_agregar_editarTexto($idconferencia, $contenido, $idusuarioadmon) {
		$conferenciaDAO = new conferenciaDAO();
		$texto = $conferenciaDAO->fn_agregar_editarTexto($idconferencia, $contenido, $idusuarioadmon);
		return $texto;
	}

	public function fn_ingresarRespuetaUsuarioPregunta($idconferencia, $idconferencia_evaluacion, $idconferencia_evaluacion_respuesta,  $idusuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$texto = $moduloConferenciaDAO->fn_ingresarRespuetaUsuarioPregunta($idconferencia, $idconferencia_evaluacion, $idconferencia_evaluacion_respuesta,  $idusuario);
		return $texto;
	}

	public function fn_validarNumeroEvaluacionesAprobadas($idUsuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$texto = $moduloConferenciaDAO->fn_validarNumeroEvaluacionesAprobadas($idUsuario);
		return $texto;
	}



	public function fn_retornarUltimaEvaluacionConteo30($idConferencia, $idUsuario) {
		$conferenciaDAO = new moduloConferenciaDAO();
		$datosPresentaciones = $conferenciaDAO->fn_retornarUltimaEvaluacionConteo30($idConferencia, $idUsuario);
		return $datosPresentaciones;
	} //Fin fn_retornarDatosPresentacionesModulos

	public function fn_todasConferenciasModulosNiveles($idUsuario, $tipoUsuario) {
		try {
			$moduloConferenciaDAO  = new moduloConferenciaDAO();
			$infoTotalConferencia = $moduloConferenciaDAO->fn_todasConferenciasModulosNiveles("NULL", $idUsuario, $tipoUsuario, 0);
			return $infoTotalConferencia;
		} catch (Exception $exc) {
			return "Excepción Clase:moduloConferenciaControl, Función:fn_todasConferenciasModulosNiveles " . $exc->getMessage();
		}
	}







	public function fn_todasConferenciasModulosNivelesConPadre($idPadre, $idUsuario, $tipoUsuario, $idioma = "") {
		try {
			$moduloConferenciaDAO  = new moduloConferenciaDAO();
			$infoTotalConferencia = $moduloConferenciaDAO->fn_todasConferenciasModulosNiveles($idPadre, $idUsuario, $tipoUsuario, 0, $idioma);
			return $infoTotalConferencia;
		} catch (Exception $exc) {
			return "Excepción Clase:moduloConferenciaControl, Función:fn_todasConferenciasModulosNivelesConPadre " . $exc->getMessage();
		}
	}


	public function fn_numeroConferenciasModulosParaCertificar($modulo, $usuario, $tipo) {
		$conferenciaDAO = new conferenciaDAO();
		$oidConferencias = $conferenciaDAO->fn_numeroConferenciasModulosParaCertificar($modulo);
		$j = 0;
		for ($i = 0; $i < count($oidConferencias); $i++) {
			$conferencias = $conferenciaDAO->fn_validarAprobacionConferencia($oidConferencias[$i]['conferencia'], $usuario);
			if ($conferencias) {
				$j++;
			}
		} //Fin for		
		if ($tipo == "P") {
			if ($j == count($oidConferencias)) {
				return "S";
			} else {
				return "N";
			}
		} else if ($tipo == "X") {
			if ($modulo == "28") {
				if ($j > 0) {
					return "S";
				} else {
					return "N";
				}
			} else {
				if ($j == count($oidConferencias) && $j > 0) {
					return "S";
				} else {
					return "N";
				}
			}
		} else {
			if ($j == count($oidConferencias) && $j > 0) {
				return "S";
			} else {
				return "N";
			}
		}
		//return $conferencias;
	} //Fin fn_retornarConferenciasModulo



	public function fn_numeroConferenciasModulosParaCertificarAKT($modulo, $usuario, $tipo) {
		$conferenciaDAO = new conferenciaDAO();
		$oidConferencias = $conferenciaDAO->fn_numeroConferenciasModulosParaCertificarAKT($modulo);
		$j = 0;
		for ($i = 0; $i < count($oidConferencias); $i++) {
			$conferencias = $conferenciaDAO->fn_validarAprobacionConferencia($oidConferencias[$i]['conferencia'], $usuario);
			if ($conferencias) {
				$j++;
			}
		} //Fin for		
		if ($tipo == "P") {
			if ($j == count($oidConferencias)) {
				return "S";
			} else {
				return "N";
			}
		} else {
			if ($j == count($oidConferencias) && $j > 0) {
				return "S";
			} else {
				return "N";
			}
		}
		//return $conferencias;
	} //Fin fn_retornarConferenciasModulo



	public function fn_traerInformacionModulosAnteriores($iidModulo) {
		$conferenciaDAO = new moduloConferenciaDAO();
		$datosPresentaciones = $conferenciaDAO->fn_traerInformacionModulosAnteriores($iidModulo);
		return $datosPresentaciones;
	} //Fin fn_traerInformacionModulosAnteriores


	public function fn_traerInformacionMensajesConeferencias($idConferencia) {
		$conferenciaDAO = new moduloConferenciaDAO();
		$datosPresentaciones['informacion'] = $conferenciaDAO->fn_traerInformacionMensajesConeferencias($idConferencia);
		if (count($datosPresentaciones['informacion']) > 0) {
			$idModuloSig = $datosPresentaciones['informacion']['idmodulo_sig'];
			$datosPresentaciones['moduloSig'] = $conferenciaDAO->fn_leerModuloConferencia($idModuloSig);
			if ($datosPresentaciones['informacion']['idtema'] != 0) {
				$idTemaSig = $datosPresentaciones['informacion']['idtema'];
				$datosPresentaciones['temaSig'] = $conferenciaDAO->fn_leerModuloConferencia($idTemaSig);
			}
		}
		return $datosPresentaciones;
	} //Fin fn_traerInformacionMensajesConeferencias


	/*agosto 23 2016*/
	public function fn_calificarPreguntasPresentacionTiempo($respuestas, $totalPreguntas, $idUsuario, $idConferencia, $tiempo) {
		$correctas = 0;
		$conferenciaDAO = new conferenciaDAO();
		for ($i = 0; $i < count($respuestas); $i++) {
			if ($conferenciaDAO->fn_esCorrectaRespuesta($respuestas[$i])) {
				$correctas++;
			} //Fin if
		} //Fin for
		$calificacion = ($correctas * 100) / $totalPreguntas;
		$calificacion = number_format($calificacion, 0);
		$infoEvaluacion = false;
		$infoEvaluacion = $conferenciaDAO->fn_validarAprobacionConferencia($idConferencia, $idUsuario);
		if ($infoEvaluacion == false) {
			$idConfIngresada = $conferenciaDAO->fn_ingresarEvaluacionPresentacionParaTiempo($calificacion, $idUsuario, $idConferencia);
			$ip = "";
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else if (isset($_SERVER['HTTP_VIA'])) {
				$ip = $_SERVER['HTTP_VIA'];
			} else if (isset($_SERVER['REMOTE_ADDR'])) {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			$infoAdcional = $this->detectarNavegador();
			$guardarInfo = $conferenciaDAO->fn_ingresarEvaluacionTiempo($idConfIngresada, $tiempo, $ip, $infoAdcional["browser"] . " v." . $infoAdcional["version"], $infoAdcional['os']);
		}
		return $calificacion;
	} //Fin fn_cargarRandomPreguntasPresentacion

	public function fn_consultarEvaluacionTiempo($idConferencia) {
		$conferenciaDAO = new conferenciaDAO();
		$datosPresentacionesTiempo = $conferenciaDAO->fn_consultarEvaluacionTiempo($idConferencia);
		return $datosPresentacionesTiempo;
	}


	public function detectarNavegador() {
		$browser = array("IEXPLORER", "OPERA", "MOZILLA", "NETSCAPE", "FIREFOX", "SAFARI", "CHROME");
		$os = array("WINDOWS", "MAC", "LINUX");
		$info['browser'] = "OTRO";
		$info['os'] = "OTRO";
		foreach ($browser as $parent) {
			$s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
			$f = $s + strlen($parent);
			$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
			$version = preg_replace('/[^0-9,.]/', '', $version);
			if ($s) {
				$info['browser'] = $parent;
				$info['version'] = $version;
			}
		}

		foreach ($os as $val) {
			if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $val) !== false)
				$info['os'] = $val;
		}
		return $info;
	}

	public function fn_guardarTiemposEvaluacionesConferencias($idConferencia, $tiempo, $tipo, $parametros, $idadmin) {
		$conferenciaDAO = new conferenciaDAO();

		$datosPresentaciones = $conferenciaDAO->fn_guardarTiemposEvaluacionesConferencias($idConferencia, $tiempo, $tipo, $parametros, $idadmin);

		return $datosPresentaciones;
	}

	public function fn_todasConferenciasModulosNivelesTipoVisualizacion($idUsuario, $tipoUsuario, $idioma = "") {
		try {
			$moduloConferenciaDAO  = new moduloConferenciaDAO();
			$infoTotalConferencia = $moduloConferenciaDAO->fn_todasConferenciasModulosNivelesTipoVisualizacion("NULL", $idUsuario, $tipoUsuario, 0, $idioma);
			return $infoTotalConferencia;
		} catch (Exception $exc) {
			return "Excepción Clase:moduloConferenciaControl, Función:fn_todasConferenciasModulosNivelesTipoVisualizacion " . $exc->getMessage();
		}
	}

	public function fn_porcentajeConferenciaSegmento($idUsuario, $tipoUsuario, $orden, $segmento, $condicion) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$infoTotalConferencia = $moduloConferenciaDAO->fn_porcentajeConferenciaSegmento("NULL", $idUsuario, $tipoUsuario, 0, $orden, $segmento, $condicion);

		for ($i = 0; $i < count($infoTotalConferencia); $i++) {
			$infoTotalConferencia[$i]['etiquetas'] = $this->consultarEtiquetasConferencia($infoTotalConferencia[$i]['idmodulo_conferencia']);
			$infoTotalConferencia[$i]['tematicas'] = $this->consultarTematicasConferencia($infoTotalConferencia[$i]['idmodulo_conferencia']);
		}

		return $infoTotalConferencia;
	}

	public function porcentajeConferencia($idUsuario, $tipoUsuario, $orden) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$infoTotalConferencia = $moduloConferenciaDAO->fn_porcentajeConferencia("NULL", $idUsuario, $tipoUsuario, 0, $orden);

		for ($i = 0; $i < count($infoTotalConferencia); $i++) {
			$infoTotalConferencia[$i]['etiquetas'] = $this->consultarEtiquetasConferencia($infoTotalConferencia[$i]['idmodulo_conferencia']);
			$infoTotalConferencia[$i]['tematicas'] = $this->consultarTematicasConferencia($infoTotalConferencia[$i]['idmodulo_conferencia']);
		}

		return $infoTotalConferencia;
	}

	public function porcentajeConferenciaSerie($idUsuario, $tipoUsuario, $orden) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$infoTotalConferencia = $moduloConferenciaDAO->fn_porcentajeConferenciaSerie("NULL", $idUsuario, $tipoUsuario, 0, $orden);

		for ($i = 0; $i < count($infoTotalConferencia); $i++) {
			$infoTotalConferencia[$i]['etiquetas'] = $this->consultarEtiquetasConferencia($infoTotalConferencia[$i]['idmodulo_conferencia']);
			$infoTotalConferencia[$i]['tematicas'] = $this->consultarTematicasConferencia($infoTotalConferencia[$i]['idmodulo_conferencia']);
		}

		return $infoTotalConferencia;
	}

	public function porcentajeConferenciaVariable($idUsuario, $tipoUsuario, $orden, $condicion) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$infoTotalConferencia = $moduloConferenciaDAO->fn_porcentajeConferenciaVariable("NULL", $idUsuario, $tipoUsuario, 0, $orden, $condicion);

		return $infoTotalConferencia;
	}

	public function conferenciasModulos($idModulo, $idUsuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$infoTotalConferencia = $moduloConferenciaDAO->fn_retornarConferenciasModulo2($idModulo);

		return $infoTotalConferencia;
	}

	public function contenidoFavorito($idModulo, $idUsuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$favorito = $moduloConferenciaDAO->fn_contenidoFavorito($idModulo, $idUsuario);

		return $favorito;
	}

	public function addFavorito($idModulo, $idUsuario) {
		try {
			$moduloConferenciaDAO = new moduloConferenciaDAO();
			$favorito = $moduloConferenciaDAO->add_contenidoFavorito($idModulo, $idUsuario);
			return $favorito;
		} catch (Exception $exc) {
			return "Excepción Clase:moduloConferenciaControl, Función:addFavorito " . $exc->getMessage();
		}
	}
	public function removeFavorito($idModulo, $idUsuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$favorito = $moduloConferenciaDAO->remove_contenidoFavorito($idModulo, $idUsuario);

		return $favorito;
	}


	public function fn_todasConferenciasModulosNivelesNotificaciones($idUsuario, $tipoUsuario) {
		$moduloConferenciaDAO  = new moduloConferenciaDAO();

		$infoTotalConferencia = $moduloConferenciaDAO->fn_todasConferenciasModulosNivelesNotificaciones("NULL", $idUsuario, $tipoUsuario, 0);

		return $infoTotalConferencia;
	}

	/*Actualizacion el 18/01/2019*/
	public function fn_EncuestaTotales() {
		$conferenciaDAO = new conferenciaDAO();

		$datosEncuesta = $conferenciaDAO->fn_EncuestaTotales();

		return $datosEncuesta;
	}

	/*Fin Actualizacion*/

	/*Funcion consultar partes del modulo*/
	public function fn_cantidadPartes($idModuloConferencia) {
		$moduloConferenciaDAO  = new moduloConferenciaDAO();

		$cantidadPartes = $moduloConferenciaDAO->fn_cantidadPartes($idModuloConferencia);

		return $cantidadPartes;
	}/*FIN consultar partes del modulo*/

	/*Funcion consultar Restricciones*/
	public function fn_consultarRestricciones($idModuloConferencia, $categoriasUsuario) {
		$moduloConferenciaDAO  = new moduloConferenciaDAO();
		$rutaDAO  = new rutaDAO();

		$idsRutaUsuario = $rutaDAO->fn_rutasCategoriaUsuario($categoriasUsuario);
		$idRutaUser = implode(",", $idsRutaUsuario);

		$moduloRestricciones = $moduloConferenciaDAO->fn_consultarRestricciones($idModuloConferencia, $idRutaUser);

		return $moduloRestricciones;
	}/*FIN consultar Restricciones*/

	/*Funcion consultar Restricciones*/
	public function fn_consultarAvanzar($idModuloConferencia, $categoriasUsuario) {
		$moduloConferenciaDAO  = new moduloConferenciaDAO();
		$rutaDAO  = new rutaDAO();

		$idsRutaUsuario = $rutaDAO->fn_rutasCategoriaUsuario($categoriasUsuario);
		$idRutaUser = implode(",", $idsRutaUsuario);

		$moduloConferenciaAvanzar = $moduloConferenciaDAO->fn_consultarAvanzar($idModuloConferencia, $idRutaUser);
		return $moduloConferenciaAvanzar;
	}/*FIN consultar Restricciones*/

	public function fn_leerVisualizacionesConferencia($idConferencia, $idUsuario) {
		$moduloConferenciaDAO  = new moduloConferenciaDAO();
		$ConferenciaAvanzar = $moduloConferenciaDAO->fn_leerVisualizacionesConferencia($idConferencia, $idUsuario);
		return $ConferenciaAvanzar;
	}/*FIN consultar Restricciones*/

	/*consultar modulo conferencia*/
	public function fn_consultarModuloConferencia($idConferencia) {
		$moduloConferenciaDAO  = new moduloConferenciaDAO();
		$moduloConferencia = $moduloConferenciaDAO->fn_consultarModuloConferencia($idConferencia);
		return $moduloConferencia;
	}/*FIN consultar modulo conferencia*/

	public function fn_retornarTodosModulosCanalOrdenAlfabetico($orden) {
		$moduloConferenciaDAO  = new moduloConferenciaDAO();
		$moduloConferencia = $moduloConferenciaDAO->fn_retornarTodosModulosCanalOrdenAlfabetico($orden);
		return $moduloConferencia;
	}/*FIN consultar modulo conferencia*/

	public function fn_leerPromediomeGustaConferencia($conferencia) {
		$moduloConferenciaDAO  = new moduloConferenciaDAO();
		$moduloConferencia = $moduloConferenciaDAO->fn_leerPromediomeGustaConferencia($conferencia);
		return $moduloConferencia;
	}/*FIN consultar PromedioMegusta conferencia*/

	public function fn_traerInformacionModulosFecha($tipoOrden, $limite, $perfil, $segmento, $condicion, $idioma = "") {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$omoduloConferencia = $moduloConferenciaDAO->fn_traerInformacionModulosFecha($tipoOrden, $limite, $perfil, $segmento, $condicion, $idioma);
		for ($i = 0; $i < count($omoduloConferencia); $i++) {
			$omoduloConferencia[$i]['hijos'] = $moduloConferenciaDAO->fn_retornarTodosModulosCanalOrden($omoduloConferencia[$i]['idmodulo_conferencia']);
			$omoduloConferencia[$i]['etiquetas'] = $this->consultarEtiquetasConferencia($omoduloConferencia[$i]['idmodulo_conferencia']);
			$omoduloConferencia[$i]['tematicas'] = $this->consultarTematicasConferencia($omoduloConferencia[$i]['idmodulo_conferencia']);
			for ($j = 0; $j < count($omoduloConferencia[$i]['hijos']); $j++) {
				$omoduloConferencia[$i]['hijos'][$j]['conferencias'] = $moduloConferenciaDAO->fn_retornarConferenciasModulo2($omoduloConferencia[$i]['hijos'][$j]['idmodulo_conferencia']);
			}
		}
		return $omoduloConferencia;
	}

	/**
	 * consultarEtiquetasConferencia
	 *
	 * @param  int $idConferencia
	 * @return array
	 */
	public function consultarEtiquetasConferencia($idConferencia) {
		$etiquetaDao = new etiquetaDAO();

		$response = $etiquetaDao->consultarEtiquetaConferencia($idConferencia);

		return $response;
	}

	/**
	 * consultarTematicasConferencia
	 *
	 * @param  int $idConferencia
	 * @return array
	 */
	public function consultarTematicasConferencia($idConferencia) {
		$tematicaDao = new tematicaDAO();

		$response = $tematicaDao->consultarTematicasConferencia($idConferencia);

		return $response;
	}

	public function fn_leerConferenciaReviewValoraciones($conferencias, $condicion) {
		$moduloConferenciaDAO  = new moduloConferenciaDAO();
		$moduloConferencia['megusta'] = $moduloConferenciaDAO->fn_leerPromediomeGustaConferenciaReview($conferencias);
		$moduloConferencia['valoraciones'] = $moduloConferenciaDAO->fn_leerConferenciaReviewValoraciones($conferencias, $condicion);
		return $moduloConferencia;
	}

	public function porcentajeConferenciaVariablePadre($idUsuario, $tipoUsuario, $orden, $condicion, $idPadre) {
		try {
			$moduloConferenciaDAO = new moduloConferenciaDAO();
			$infoTotalConferencia = $moduloConferenciaDAO->fn_porcentajeConferenciaVariablePadre($idPadre, $idUsuario, $tipoUsuario, 0, $orden, $condicion);
			return $infoTotalConferencia;
		} catch (Exception $exc) {
			return "Excepción Clase:moduloConferenciaControl, Función:porcentajeConferenciaVariable " . $exc->getMessage();
		}
	}

	public function fn_consultarModuloPerteneceConferencia($idconferencia) {
		try {
			$moduloConferenciaDAO = new moduloConferenciaDAO();
			$infoTotalConferencia = $moduloConferenciaDAO->fn_consultarModuloPerteneceConferencia($idconferencia);
			return $infoTotalConferencia;
		} catch (Exception $exc) {
			return "Excepción Clase:moduloConferenciaControl, Función:porcentajeConferenciaVariable " . $exc->getMessage();
		}
	}

	public function fn_consultarModuloCursoPerteneceConferencia($idconferencia) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoTotalConferencia['modulo'] = $moduloConferenciaDAO->fn_consultarModuloPerteneceConferencia($idconferencia);
		if(!empty($infoTotalConferencia['modulo'])){
			if ($infoTotalConferencia['modulo']['idmodulo_padre']) {
				$infoTotalConferencia['curso'] = $moduloConferenciaDAO->fn_leerModuloConferencia($infoTotalConferencia['modulo']['idmodulo_padre'], "");
			}
		}else{
			$infoTotalConferencia = [];
		}
		return $infoTotalConferencia;
	}



	public function contenidoMegusta($idUsuario, $idConferencia) {
		$moduloConferenciaDAO = new conferenciaDAO();
		$meGusta = $moduloConferenciaDAO->fn_contenidoMegusta($idUsuario, $idConferencia);
		return $meGusta;
	}


	/**
	 * @method obtener listado con los contenidos calificados por el usuario en sesión con 4 ó 5 estrellas 
	 * @return array
	 */
	function fn_contenidoFavorito($idUsuario) {
		try {
			$favoritos = new conferenciaDAO();
			$favoritos = $favoritos->fn_contenidoFavorito($idUsuario);
			return $favoritos;
		} catch (Exception $exc) {
			return "Excepción Clase:moduloConferenciaControl, Función:fn_contenidoFavorito " . $exc->getMessage();
		}
	}

	public function guardarMegusta($idUsuario, $idConferencia, $estado) {
		$conferenciaDao = new conferenciaDAO();
		$meGusta = $conferenciaDao->fn_guardarMegusta($idUsuario, $idConferencia, $estado);
		return $meGusta;
	}

	public function removeMG($idUsuario, $idConferencia) {
		try {
			$moduloConferenciaDAO = new conferenciaDAO();
			$removeMG = $moduloConferenciaDAO->removeMG($idUsuario, $idConferencia);
			return $removeMG;
		} catch (Exception $exc) {
			return "Excepción Clase:moduloConferenciaControl, Función:removeMG " . $exc->getMessage();
		}
	}

	public function fn_guardarEncuestaUsuario($idUsuario, $idConferencia, $pregunta1, $pregunta2, $pregunta3, $comentario) {
		$conferenciaDao = new conferenciaDAO();
		$respuesta = $conferenciaDao->fn_guardarEncuestaUsuario($idUsuario, $idConferencia, $pregunta1, $pregunta2, $pregunta3, $comentario);
		return $respuesta;
	}


	public function fn_leerModuloConferenciaGrupoPerfil($idModulo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_leerModuloConferenciaGrupoPerfil($idModulo);
		return $informacionIdModulo;
	}

	public function fn_leerModuloConferenciaCategoriaSegmento($idModulo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_leerModuloConferenciaCategoriaSegmento($idModulo);
		return $informacionIdModulo;
	}

	public function fn_leerModuloConferenciaCurso($idModulo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_leerModuloConferenciaCurso($idModulo);
		return $informacionIdModulo;
	}

	public function fn_leerModuloCursoDestacado($idDestacado) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_leerModuloCursoDestacado($idDestacado);
		return $informacionIdModulo;
	}

	public function fn_leerModuloConferenciaNivel($idNivel) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_leerModuloConferenciaNivel($idNivel);
		return $informacionIdModulo;
	}

	public function fn_leerModuloConferenciaInformacion($idModulo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_leerModuloConferenciaInformacion($idModulo);
		return $informacionIdModulo;
	}

	public function fn_traerInformacionBuscador($paramBusqueda, $orden, $limite) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_traerInformacionBuscador($paramBusqueda, $orden, $limite);
		return $informacionIdModulo;
	}


	public function fn_ingresarModulo_cursoCompletado($idModulo, $idUsuario, $certifica) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_ingresarModulo_cursoCompletado($idModulo, $idUsuario, $certifica);
		return $informacionIdModulo;
	}

	public function fn_ingresarInfo_navegacion($info, $var, $val, $param, $idUsuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_ingresarInfo_navegacion($info, $var, $val, $param, $idUsuario);
		return $informacionIdModulo;
	}

	public function ultimaVisualizacionConferenciasModulosCursos($idUsuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModuloCursos = $moduloConferenciaDAO->ultimaVisualizacionConferenciasModulosCursos($idUsuario);
		return $informacionIdModuloCursos;
	}

	public function fn_traerInformacionModulosTotal($tipoOrden, $limite, $perfil, $segmento, $condicion, $idioma = "") {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$omoduloConferencia = $moduloConferenciaDAO->fn_traerInformacionModulosFecha($tipoOrden, $limite, $perfil, $segmento, $condicion, $idioma);
		return $omoduloConferencia;
	} //Fin fn_retornarDatosIntroduccionCanal

	public function fn_retornarTodosModulosCanal() {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_retornarTodosModulosCanal();
		return $oModulosCanal;
	} //Fin fn_retornarTodosModulosCanal

	public function fn_retornarTodosModulosCanalPorFechaPublicacion() {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_retornarTodosModulosCanalPorFechaPublicacion();
		return $oModulosCanal;
	} //Fin fn_retornarTodosModulosCanal

	public function fn_retornarTodosModulosCanalDestacados($idCurso = false) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_retornarTodosModulosCanalDestacados($idCurso);
		return $oModulosCanal;
	} 

	public function fn_retornarTodosModulosCanalMasCompletados() {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_retornarTodosModulosCanalMasCompletados();
		return $oModulosCanal;
	} //Fin fn_retornarTodosModulosCanalMasCompletados

	public function fn_retornarTodosModulosCanalMasCompletadosUsuario($idUsuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_retornarTodosModulosCanalMasCompletadosUsuario($idUsuario);
		return $oModulosCanal;
	} //Fin fn_retornarTodosModulosCanalMasCompletadosUsuario

	public function fn_retornarTodosModulosCanalMasNavegados() {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_retornarTodosModulosCanalMasNavegados();
		return $oModulosCanal;
	} //Fin fn_retornarTodosModulosCanalMasNavegados

	public function fn_retornarTodosModulosCanalMasNavegadosUsuario($idUsuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_retornarTodosModulosCanalMasNavegadosUsuario($idUsuario);
		return $oModulosCanal;
	} //Fin fn_retornarTodosModulosCanalMasNavegadosUsuario

	public function fn_ingresarOpinion_cursoCompletado($idConferencia, $idUsuario, $valoracion) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_ingresarOpinion_cursoCompletado($idConferencia, $idUsuario, $valoracion);
		return $oModulosCanal;
	} //Fin fn_ingresarOpinion_cursoCompletado

	public function fn_ingresarApunteConferencia($idConferencia, $idUsuario, $apunte) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_ingresarApunteConferencia($idConferencia, $idUsuario, $apunte);
		return $oModulosCanal;
	} //Fin fn_ingresarApunteConferencia

	public function fn_leerConferenciaApuntesUsuario($conferencia, $idUsuario) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->fn_leerConferenciaApuntesUsuario($conferencia, $idUsuario);
		return $oModulosCanal;
	} //Fin fn_leerConferenciaApuntesUsuario

	public function consultarInfoCapituloSerie($idconferencia) {
		$moduloConferenciaDAO = new conferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->consultarInfoCapituloSerie($idconferencia);
		return $oModulosCanal;
	} //Fin fn_leerConferenciaApuntesUsuario

	public function informacionCapitulosModulosSeries($condicion = "") {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->informacionCapitulosModulosSeries($condicion);
		return $oModulosCanal;
	}

	public function actualizarEstadoVivo($estado, $idconferencia) {
		$moduloConferenciaDAO = new conferenciaDAO();
		$oModulosCanal = $moduloConferenciaDAO->actualizarEstadoVivo($estado, $idconferencia);
		return $oModulosCanal;
	}

	public function actualizarDatosPresentacionVivos($archivo, $idioma = "") {
		$ingreso = false;
		$conferenciaDAO = new conferenciaDAO();
		$idConferencia = $conferenciaDAO->fn_editarConferencia($archivo['idconferencia'], $archivo['dsnombre_conferencia'], $archivo['dsautor_conferencia'], $archivo['dsservidor_streaming'], $archivo['dsnombre_archivo'], $archivo['nmduracion_conferencia'], $archivo['dscomentario_conferencia'], $archivo['dsdiploma_conferencia'], $archivo['febaja'], $archivo['dsestado_conferencia'], $archivo['idusuario_modificacion'], $idioma);
		$ingresarCapSerie = $conferenciaDAO->actualizarPresentacionVivo($archivo['idconferencia'], $archivo['videoEmbed'], $archivo['tipoChat'], $archivo['chat'], $archivo['tiempomin'], $archivo['fechav'], $archivo['horav'], $archivo['destac'], $archivo['estadoMomento'], $archivo['param']);
		if ($archivo['dsruta_imagen_conferencia'] != "") {
			$actuImg = $conferenciaDAO->actualizarImagenPresentacionVivo($archivo['idconferencia'], $archivo['dsruta_imagen_conferencia']);
		}

		return $idConferencia;
	}

	/**
	 * @method obtener listado con id de los módulos hijos en consulta
	 * @return array
	 */
	public function fn_obtenerIDModulosHijos($idModuloPadre) {
		$idModulos  = new moduloConferenciaDAO();
		$idModulos = $idModulos->fn_obtenerIDModulosHijos($idModuloPadre);
		return $idModulos;
	}

	public function fn_retornarConferenciasModulo2($idModulo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datosConferencia = $moduloConferenciaDAO->fn_retornarConferenciasModulo2($idModulo);
		return $datosConferencia;
	}

	public function fn_leerModuloConferencia($idModulo){
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datosModulo = $moduloConferenciaDAO->fn_leerModuloConferencia($idModulo);
		return $datosModulo;
	}

	/**
	 * @method obtener array con la información completa de cada curso y del comportamiento del usuario en el curso
	 * @return array
	 * 03-02-2023-yl
	 */
	public function obtenerinfoCompletaCursos($idusuario, $numerolimitIni=false, $numerolimitFin=false){
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoCursos = $moduloConferenciaDAO->obtenerinfoCompletaCursos($idusuario, $numerolimitIni, $numerolimitFin);
		return $infoCursos;
	}


	public function fn_obtenerMetaCursos($idCurso){
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoCursos = $moduloConferenciaDAO->fn_obtenerMetaCursos($idCurso);
		return $infoCursos;
	}

	public function fn_obtenerTotalCursos(){
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoCursos = $moduloConferenciaDAO->fn_obtenerTotalCursos();
		return $infoCursos;
	}

	public function fn_traerInformacionBuscadorArticulos($paramBusqueda) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_traerInformacionBuscadorArticulos($paramBusqueda);
		return $informacionIdModulo;
	}

	public function fn_traerPreguntasFrecuentesAdmin($idPregunta) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_traerPreguntasFrecuentesAdmin($idPregunta);
		return $informacionIdModulo;
	}

	public function fn_retornarPreguntasTotal() {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_retornarPreguntasTotal();
		return $informacionIdModulo;
	}

	public function fn_agregarPreguntaFrecuente($datosIngreso) {
		if ($datosIngreso['titulo_pregunta'] == "" || $datosIngreso['titulo_pregunta'] == NULL) {
			throw new Exception('ERROR: Se require el título de la pregunta');
		} //Fin if
		if ($datosIngreso['descripcion_pregunta'] == "" || $datosIngreso['descripcion_pregunta'] == NULL) {
			throw new Exception('ERROR: Se requiere la descripcion');
		} //Fin if
		if ($datosIngreso['cursos'] == "" || $datosIngreso['cursos'] == NULL) {
			throw new Exception('ERROR: Se requiere seleccionar algún curso');
		}

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$oidModuloConferencia = $moduloConferenciaDAO->fn_ingresarPreguntaFrecuente($datosIngreso['titulo_pregunta'], $datosIngreso['descripcion_pregunta'], $datosIngreso['idadministrador']);
		if($datosIngreso['cursos'] != ""){
		$moduloConferenciaDAO->fn_ingresarCursoPreguntaFrecuente($datosIngreso['cursos'], $datosIngreso['idadministrador'], $oidModuloConferencia);
		}

		return $oidModuloConferencia;
	}

	public function fn_editarPreguntaFrecuente($datosIngreso) {
		if ($datosIngreso['idpregunta'] == "" || $datosIngreso['idpregunta'] == NULL) {
			throw new Exception('ERROR: Se requiere el id de la pregunta');
		} //Fin if
		if ($datosIngreso['titulo_pregunta'] == "" || $datosIngreso['titulo_pregunta'] == NULL) {
			throw new Exception('ERROR: Se requiere el título de la pregunta');
		} //Fin if
		if ($datosIngreso['descripcion_pregunta'] == "" || $datosIngreso['descripcion_pregunta'] == NULL) {
			throw new Exception('ERROR: Se requiere la descripcion');
		} //Fin if
		if ($datosIngreso['cursos'] == "" || $datosIngreso['cursos'] == NULL) {
			throw new Exception('ERROR: Se requiere seleccionar algún curso');
		}

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datos = $moduloConferenciaDAO->fn_modificarPregunta($datosIngreso['titulo_pregunta'], $datosIngreso['descripcion_pregunta'], $datosIngreso['idadministrador'], $datosIngreso['idpregunta']);
		$this->fn_modificarPreguntaCurso($datosIngreso);
		return $datos;
	}

	public function fn_modificarPreguntaCurso($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$moduloConferenciaDAO->fn_eliminarPreguntaCurso($datosIngreso['idpregunta']);
		$moduloConferenciaDAO->fn_ingresarCursoPreguntaFrecuente($datosIngreso['cursos'], $datosIngreso['idadministrador'], $datosIngreso['idpregunta']);
	}

	

	public function fn_cambiarEstadoPregunta($idPregunta, $nuevoEstado) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datosPregunta = $moduloConferenciaDAO->fn_cambiarEstadoPregunta($idPregunta, $nuevoEstado);
		return $datosPregunta;
	}

	public function fn_cambiarEstadoConferencia($idConferencia, $nuevoEstado) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datosConferencia = $moduloConferenciaDAO->fn_cambiarEstadoConferencia($idConferencia, $nuevoEstado);
		return $datosConferencia;
	}

	public function fn_traerPreguntasFrecuentes($idPregunta) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_traerPreguntasFrecuentes($idPregunta);
		return $informacionIdModulo;
	}

	public function fn_agregarMetodologia($datosIngreso) {
		if ($datosIngreso['icono'] == "" || $datosIngreso['icono'] == NULL) {
			throw new Exception('ERROR: Se requiere el ícono de la metodología');
		}
		if ($datosIngreso['titulo_metodologia'] == "" || $datosIngreso['titulo_metodologia'] == NULL) {
			throw new Exception('ERROR: Se requiere el título de la metodología');
		} //Fin if
		if ($datosIngreso['descripcion_metodologia'] == "" || $datosIngreso['descripcion_metodologia'] == NULL) {
			throw new Exception('ERROR: Se requiere la descripcion');
		}

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$idMetodologia = $moduloConferenciaDAO->fn_ingresarMetodologia($datosIngreso['icono'], $datosIngreso['titulo_metodologia'], $datosIngreso['descripcion_metodologia'], $datosIngreso['idadministrador']);
		$moduloConferenciaDAO->fn_ingresarCursoMetodologia($datosIngreso['cursos'], $datosIngreso['idadministrador'], $idMetodologia);

		return $idMetodologia;
	}

	public function fn_leerModuloConferenciaMetodologia($idModulo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_leerModuloConferenciaMetodologia($idModulo);
		return $informacionIdModulo;
	}

	public function fn_leerModuloConferenciaDestacados($idModulo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_leerModuloConferenciaDestacados($idModulo);
		return $informacionIdModulo;
	}

	public function fn_traerMetodologiasAdmin($idMetodologia) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_traerMetodologiasAdmin($idMetodologia);
		return $informacionIdModulo;
	}

	public function fn_traerNivelesAdmin($idNivel) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_traerNivelesAdmin($idNivel);
		return $informacionIdModulo;
	}

	public function fn_traerDestacadosAdmin($idDestacado) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_traerDestacadosAdmin($idDestacado);
		return $informacionIdModulo;
	}

	public function fn_retornarMetodologias() {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_retornarMetodologias();
		return $informacionIdModulo;
	}

	public function fn_retornarNiveles() {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_retornarNiveles();
		return $informacionIdModulo;
	}

	public function fn_retornarDestacados() {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionIdModulo = $moduloConferenciaDAO->fn_retornarDestacados();
		return $informacionIdModulo;
	}

	public function fn_editarMetodologia($datosIngreso) {
		if ($datosIngreso['idMetodologia'] == "" || $datosIngreso['idMetodologia'] == NULL) {
			throw new Exception('ERROR: Se requiere el id de la metodología');
		} //Fin if
		if ($datosIngreso['icono'] == "" || $datosIngreso['icono'] == NULL) {
			throw new Exception('ERROR: Se requiere el título de la pregunta');
		} //Fin if
		if ($datosIngreso['titulo_metodologia'] == "" || $datosIngreso['titulo_metodologia'] == NULL) {
			throw new Exception('ERROR: Se requiere el título de la pregunta');
		} //Fin if
		if ($datosIngreso['descripcion_metodologia'] == "" || $datosIngreso['descripcion_metodologia'] == NULL) {
			throw new Exception('ERROR: Se requiere la descripcion');
		} //Fin if
		if ($datosIngreso['cursos'] == "" || $datosIngreso['cursos'] == NULL) {
			throw new Exception('ERROR: Se requiere seleccionar algún curso');
		}

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datos = $moduloConferenciaDAO->fn_modificarMetodologia($datosIngreso['icono'], $datosIngreso['titulo_metodologia'], $datosIngreso['descripcion_metodologia'], $datosIngreso['idadministrador'], $datosIngreso['idMetodologia']);
		$this->fn_modificarMetodologiaCurso($datosIngreso);
		return $datos;
	}

	public function fn_modificarMetodologiaCurso($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$moduloConferenciaDAO->fn_eliminarMetodologiaCurso($datosIngreso['idMetodologia']);
		$moduloConferenciaDAO->fn_ingresarCursoMetodologia($datosIngreso['cursos'], $datosIngreso['idadministrador'], $datosIngreso['idMetodologia']);
	}
	public function fn_modificarDestacadoCurso($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();

		$moduloConferenciaDAO->fn_eliminarDestacadoCurso($datosIngreso['modConferencia']);
		$moduloConferenciaDAO->fn_ingresarCursoDestacado($datosIngreso['cursos'], $datosIngreso['idadministrador'], $datosIngreso['modConferencia']);
	}
	public function fn_cambiarEstadoMetodologia($idMetodologia, $nuevoEstado) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datosMetodologias = $moduloConferenciaDAO->fn_cambiarEstadoMetodologia($idMetodologia, $nuevoEstado);
		return $datosMetodologias;
	}

	public function fn_cambiarEstadoNivel($idNivel, $nuevoEstado) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datosMetodologias = $moduloConferenciaDAO->fn_cambiarEstadoNivel($idNivel, $nuevoEstado);
		return $datosMetodologias;
	}

	public function fn_cambiarEstadoDestacado($idDestacado, $nuevoEstado) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datosMetodologias = $moduloConferenciaDAO->fn_cambiarEstadoDestacado($idDestacado, $nuevoEstado);
		return $datosMetodologias;
	}

	public function fn_obtenerMetodologias($idCurso = false){
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoMetodologias = $moduloConferenciaDAO->fn_obtenerMetodologias($idCurso);
		return $infoMetodologias;
	}

	public function fn_agregarDestacado($datosIngreso) {
		if ($datosIngreso['titulo_destacado'] == "" || $datosIngreso['titulo_destacado'] == NULL) {
			throw new Exception('ERROR: Se requiere el título');
		} //Fin if
		if ($datosIngreso['descripcion_destacado'] == "" || $datosIngreso['descripcion_destacado'] == NULL) {
			throw new Exception('ERROR: Se requiere la descripcion');
		}

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$idDestacado = $moduloConferenciaDAO->fn_ingresarDestacado($datosIngreso['titulo_destacado'], $datosIngreso['descripcion_destacado'], $datosIngreso['idadministrador']);
		$moduloConferenciaDAO->fn_ingresarCursoDestacado($datosIngreso['cursos'], $datosIngreso['idadministrador'], $idDestacado);

		return $idDestacado;
	}

	public function fn_agregarNivel($datosIngreso) {
		if ($datosIngreso['titulo_nivel'] == "" || $datosIngreso['titulo_nivel'] == NULL) {
			throw new Exception('ERROR: Se requiere el título');
		} //Fin if
		if ($datosIngreso['descripcion_nivel'] == "" || $datosIngreso['descripcion_nivel'] == NULL) {
			throw new Exception('ERROR: Se requiere la descripcion');
		}

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$idNivel = $moduloConferenciaDAO->fn_ingresarNivel($datosIngreso['titulo_nivel'], $datosIngreso['descripcion_nivel'], $datosIngreso['idadministrador']);
		return $idNivel;
	}
	
	public function fn_editarNivel($datosIngreso) {
		if ($datosIngreso['idNivel'] == "" || $datosIngreso['idNivel'] == NULL) {
			throw new Exception('ERROR: Se requiere el id');
		} //Fin if
		if ($datosIngreso['titulo_nivel'] == "" || $datosIngreso['titulo_nivel'] == NULL) {
			throw new Exception('ERROR: Se requiere el título');
		} //Fin if
		if ($datosIngreso['descripcion_nivel'] == "" || $datosIngreso['descripcion_nivel'] == NULL) {
			throw new Exception('ERROR: Se requiere la descripcion');
		} //Fin if

		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datos = $moduloConferenciaDAO->fn_modificarNivel($datosIngreso['titulo_nivel'], $datosIngreso['descripcion_nivel'], $datosIngreso['idadministrador'], $datosIngreso['idNivel']);
		return $datos;
	}

	//GRUPOS//
	public function fn_obtenerGruposConferencia($idCurso){
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoGrupos = $moduloConferenciaDAO->fn_obtenerGruposConferencia($idCurso);
		for ($i = 0; $i < count($infoGrupos); $i++) {
			$infoGrupos[$i]['tutores'] = $moduloConferenciaDAO->fn_obtenerTutoresGrupo($infoGrupos[$i]['idgrupo']);
		}
		return $infoGrupos;
	}

	public function fn_obtenerTutoresGrupo($idGrupo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datosGrupo = $moduloConferenciaDAO->fn_obtenerTutoresGrupo($idGrupo);
		return $datosGrupo;
	}

	public function fn_cambiarEstadoGrupo($idGrupo, $nuevoEstado) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datosConferencia = $moduloConferenciaDAO->fn_cambiarEstadoGrupo($idGrupo, $nuevoEstado);
		return $datosConferencia;
	}

	public function fn_agregarGrupo($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$idGrupo = $moduloConferenciaDAO->fn_ingresarGrupo($datosIngreso['nombre_grupo'], $datosIngreso['capacidad'], $datosIngreso['idmoduloconferencia'],  $datosIngreso['idadministrador'], $datosIngreso['fecha_corte'], $datosIngreso['fecha_inicio'], $datosIngreso['fecha_fin'], $datosIngreso['fecha_extra'], $datosIngreso['estudiantes'], $datosIngreso['duracion']);
		$moduloConferenciaDAO->fn_ingresarTutorGrupo($datosIngreso['tutor'], $idGrupo, $datosIngreso['idadministrador']);
		$moduloConferenciaDAO->fn_insertarIntensidadGrupo($datosIngreso['intensidad'], $idGrupo, $datosIngreso['idadministrador']);
		return $idGrupo;
	}

	public function fn_traerGruposAdmin($idGrupo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionGrupos = $moduloConferenciaDAO->fn_traerGruposAdmin($idGrupo);
		return $informacionGrupos;
	}

	public function fn_traerEquipoAdmin($idEquipo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoEquipo = $moduloConferenciaDAO->fn_traerEquipoAdmin($idEquipo);
		return $infoEquipo;
	}

	public function fn_editarGrupo($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datos = $moduloConferenciaDAO->fn_modificarGrupo($datosIngreso['idGrupo'], $datosIngreso['nombre'], $datosIngreso['capacidad'], $datosIngreso['idadministrador'], $datosIngreso['feCorte'], $datosIngreso['feInicio'], $datosIngreso['feFinal'], $datosIngreso['feExtra'], $datosIngreso['estudiantes'], $datosIngreso['duracion']);
		$this->fn_modificarTutorGrupo($datosIngreso);
		return $datos;
	}	

	public function fn_editarEquipo($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$datos = $moduloConferenciaDAO->fn_modificarEquipo($datosIngreso['idEquipo'], $datosIngreso['nombre'], $datosIngreso['idadministrador']);
		return $datos;
	}	


	public function fn_modificarTutorGrupo($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$moduloConferenciaDAO->fn_eliminarTutorGrupo($datosIngreso['idGrupo']);
		$moduloConferenciaDAO->fn_ingresarTutorGrupo($datosIngreso['tutor'], $datosIngreso['idGrupo'], $datosIngreso['idadministrador']);
	}

	public function fn_obtenerEquiposGrupos($idCurso = false){
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoEquipos = $moduloConferenciaDAO->fn_obtenerEquiposGrupos($idCurso);
		return $infoEquipos;
	}

	public function fn_obtenerEstudiantesConferencia($idEstudiante, $idListado = false){
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoEstudiantes = $moduloConferenciaDAO->fn_obtenerEstudiantesConferencia($idEstudiante, $idListado);
		return $infoEstudiantes;
	}

	public function fn_traerEstudianteAdmin($idEstudiante, $idConferencia = false, $idGrupo = false) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionEstudiante = $moduloConferenciaDAO->fn_traerEstudianteAdmin($idEstudiante, $idConferencia, $idGrupo);
		return $informacionEstudiante;
	}

	public function fn_traerGrupoActualEstudiante($idEstudiante, $idConferencia) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionEstudiante = $moduloConferenciaDAO->fn_traerGrupoActualEstudiante($idEstudiante, $idConferencia);
		return $informacionEstudiante;
	}

	public function fn_agregarEstudianteCurso($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$nuevoEstudiante = $moduloConferenciaDAO->fn_agregarEstudianteCurso($datosIngreso['estudiantes'], $datosIngreso['idCurso']);
		return $nuevoEstudiante;
	}

	public function fn_agregarEstudianteGrupo($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$nuevoEstudiante = $moduloConferenciaDAO->fn_agregarEstudianteGrupo($datosIngreso['estudiantes'], $datosIngreso['idGrupo'], $datosIngreso['idAdmin']);
		return $nuevoEstudiante;
	}

	public function fn_agregarEstudianteEquipo($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$nuevoEstudiante = $moduloConferenciaDAO->fn_agregarEstudianteEquipo($datosIngreso['estudiantes'], $datosIngreso['idEquipo'], $datosIngreso['idAdmin']);
		return $nuevoEstudiante;
	}

	public function fn_eliminarEstudianteGrupo($idEstudiante, $idGrupo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$moduloConferenciaDAO->fn_eliminarEstudianteGrupo($idEstudiante, $idGrupo);
	}


	public function fn_asignarGrupoEstudiante($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$this->fn_eliminarEstudianteGrupo($datosIngreso['idEstudiante'], $datosIngreso['grupoActual']);
		$moduloConferenciaDAO->fn_ingresarEstudianteAGrupo($datosIngreso['idEstudiante'], $datosIngreso['grupo'], $datosIngreso['idAdmin']);
	}

	public function fn_obtenerEstudiantesGrupo($idGrupo, $idListado = false){
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoEstudiantes = $moduloConferenciaDAO->fn_obtenerEstudiantesGrupo($idGrupo, $idListado);
		return $infoEstudiantes;
	}

	public function fn_traerEquipoActualEstudiante($idEstudiante, $idGrupo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionEstudiante = $moduloConferenciaDAO->fn_traerEquipoActualEstudiante($idEstudiante, $idGrupo);
		return $informacionEstudiante;
	}

	public function fn_agregarEquipo($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$idEquipo = $moduloConferenciaDAO->fn_ingresarEquipo($datosIngreso['nombre_equipo'], $datosIngreso['idgrupo'], $datosIngreso['idadministrador']);
		return $idEquipo;
	}

	public function fn_asignarEquipoEstudiante($datosIngreso) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$this->fn_eliminarEstudianteEquipo($datosIngreso['idEstudiante'], $datosIngreso['equipoActual']);
		$moduloConferenciaDAO->fn_ingresarEstudianteAEquipo($datosIngreso['idEstudiante'], $datosIngreso['equipo'], $datosIngreso['idAdmin']);
	}

	public function fn_eliminarEstudianteEquipo($idEstudiante, $idEquipo) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$moduloConferenciaDAO->fn_eliminarEstudianteEquipo($idEstudiante, $idEquipo);
		}

	public function fn_obtenerEstudiantesEquipo($idEquipo){
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$infoEstudiantes = $moduloConferenciaDAO->fn_obtenerEstudiantesEquipo($idEquipo);
		return $infoEstudiantes;
	}

	public function fn_traerIntensidadCurso($idCurso, $idGrupo = false) {
		$moduloConferenciaDAO = new moduloConferenciaDAO();
		$informacionEstudiante = $moduloConferenciaDAO->fn_traerIntensidadCurso($idCurso, $idGrupo);
		return $informacionEstudiante;
	}
};//Fin clase moduloConferenciaControl
