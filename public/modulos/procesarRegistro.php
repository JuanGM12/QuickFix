<?php
session_start();
require_once $_SESSION['canalSeleccionado'];
$usuariosControl = new moduloUsuarioControl();

$usuario = $_POST['usuario'];
$contra = $_POST['contrasena'];
$contraConfirmacion = $_POST['confirmar_contrasena'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$departamento = $_POST['departamento'];
$ciudad = $_POST['ciudad'];
$codigoPostal = $_POST['codigo_postal'];
$direccion = $_POST['direccion'];
$numeroDocumento = $_POST['numero_documento'];
$tipoDocumento = $_POST['tipo_documento'];
$tipoUsuario = $_POST['tipo_usuario'];


$datosIngreso['usuario'] = $usuario;
$datosIngreso['contra'] = $contra;
$datosIngreso['contraConfirmacion'] = $contraConfirmacion;
$datosIngreso['nombre'] = $nombre;
$datosIngreso['apellidos'] = $apellidos;
$datosIngreso['correo'] = $correo;
$datosIngreso['telefono'] = $telefono;
$datosIngreso['departamento'] = $departamento;
$datosIngreso['ciudad'] = $ciudad;
$datosIngreso['codigoPostal'] = $codigoPostal;
$datosIngreso['direccion'] = $direccion;
$datosIngreso['numeroDocumento'] = $numeroDocumento;
$datosIngreso['tipoDocumento'] = $tipoDocumento;
$datosIngreso['tipoUsuario'] = $tipoUsuario;


$usuarios = $usuariosControl->fn_registrarUsuario($datosIngreso);
header("../index.php");
exit();