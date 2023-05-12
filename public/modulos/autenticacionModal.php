<?php

$rutaActual = $_SERVER["REQUEST_URI"];

if ($rutaActual == "index.php" || $rutaActual == "/index.php" || $rutaActual == "/" || $rutaActual == "" || $rutaActual == "/inicio") {
	$rutaActual = "/inicio";
} else {
	$rutaActual = "";
}
try {
	if (!verificaAutenticacion()) {		
?>
			<!-- Modal INGRESAR -->
			<div class="modal fade" id="autenticar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
					<div class="modal-content autenticarregistrar p-5">
						<div class="modal-header p-0 mb-3" style="border:none;">
							<h3 class="modal-title text-white ff-5" id="staticBackdropLabel">Titulo</h3>
							<button type="button" class="quitarpropbutton grn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
						</div>
						<div class="form-floating my-2">
							<input type="text" class="form-control camposformulario text-dark" name="dato1" id="dato1" placeholder="Documento">
							<label class="text-dark" for="dato1">Documento de identidad</label>
						</div>
						<div class="form-floating  text-white my-2">
							<input class="form-control camposformulario" type="password" name="dato2" id="dato2" placeholder="Contraseña">
							<label class="text-dark" for="dato2">Contraseña</label>
						</div>
						
						<a href="/recordar" class="text-white  text-end peq text-decoration-underline">
							¿Olvidaste tu contraseña?
						</a>
						<div class="d-grid gap-2">
							<button type="button" id="sendBtn" onclick="prueba()">Iniciar</button>
						</div>
						
							<h5 class=" text-white text-center mt-2">
								¿AÚN NO HACES PARTE? <a href="#" class="text-white text-decoration-underline" data-bs-toggle="modal" data-bs-target="#registrar" data-bs-dismiss="modal" id="btnRegistrarseDesdeIngresar">REGÍSTRATE</a>
							</h5>
					</div>
				</div>
			</div>
					

<?php
			
			$campo2vacio = "";
			$valorCampo2 = "";
				$campo2vacio = " && $('#dato2').val()!='' ";
				$valorCampo2 = ", dato2: $('#dato2').val() ";
?>
<script type='text/javascript'>
				document.getElementById("sendBtn");
					var ventana_ancho = 0;
					var ventana_alto = 0;

					$('#dato2').keypress(function(e) {
					    var keycode = (e.keyCode ? e.keyCode : e.which);
					    if (keycode == '13') {
					        llamadoLogin();
					        e.preventDefault();
					        return false;
					    }
					});

					function prueba(){
						console.log("Hola");
					}

					function redireccionar(){
						var urlPrgma = '" . $rutaActual . "';
						$(location).attr('href',urlPrgma);
					}

					function llamadoLogin(){								
						if($("#dato1").val()!=""){
							$.ajax({
								type: 'POST',
								url: '/modulos/validarUsuario.php',
								data: { dato1: $('#dato1').val() " . $valorCampo2 . " }
							}).done(function( msg ) {
								console.log(msg)
								var respuesta= msg.trim();
								if(respuesta=='logOK'){										
									var urlPrgma = '/index.php';										
									redireccionar();
								}else if(respuesta=='Fail'){
									ejecutarAlerta('¡Upsssss!', 'Error', 'error', 'CERRAR');
								}else if(respuesta=='Fallo'){
									ejecutarAlerta('¡Upsssss!', 'Error', 'error', 'CERRAR');
								}
							});
						}else{
							ejecutarAlerta('¡Upsssss!', 'Campos sin llenar', 'error', 'CERRAR');
						}
					}
				  </script>
				  <?php
	}
}
catch (Exception $e) {
	echo $e->getMessage();
}
?>