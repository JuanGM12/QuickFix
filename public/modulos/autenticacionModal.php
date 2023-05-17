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
							<h3 class="modal-title text-black ff-5" id="staticBackdropLabel">Iniciar Sesión</h3>
							<button type="button" class="quitarpropbutton grn text-black" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
						</div>
						<div class="form-floating my-2">
						<label class="text-dark" for="dato1">Documento de identidad</label>
							<input type="text" class="form-control camposformulario text-dark" name="dato1" id="dato1" placeholder="Documento">
						</div>
						<div class="form-floating  text-black my-2">
						<label class="text-dark" for="dato2">Contraseña</label>
							<input class="form-control camposformulario" type="password" name="dato2" id="dato2" placeholder="Contraseña">
						</div>
						
						<a href="/recordar" class="text-black text-end peq text-decoration-underline">
							¿Olvidaste tu contraseña?
						</a>
						<div class="d-grid gap-2">
							<button type="button" id="sendBtn" onclick="prueba()">Iniciar</button>
						</div>
						
							<h5 class=" text-black text-center mt-2">
								¿AÚN NO HACES PARTE? <a href="/modulos/registrarUsuario.php" class="text-black text-decoration-underline">REGÍSTRATE</a>
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