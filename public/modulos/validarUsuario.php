<?php
session_start();

require_once  $_SESSION['canalSeleccionado'];

$dato1 = $_POST['dato1'];
$dato2 = $_POST['dato2'];

$usuariosControl = new moduloUsuarioControl();
try {
  $autenticacionUsuario = $usuariosControl->fn_loginUsuario($dato1, $dato2);
  if ($autenticacionUsuario == "") {
    echo 'Fallo';
  } else {
    $_SESSION["posicionEstado"] = 0;
    $_SESSION["autenticado"] = "SI";
    echo "logOK";
  }
} catch (Exception $e) {
  echo $e->getMessage();
}
