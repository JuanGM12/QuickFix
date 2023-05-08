<?php
session_start();
$_SESSION['canalSeleccionado'] = $_SERVER['DOCUMENT_ROOT'] . '/librerias/configuraciones/requires.tm.php';
require_once $_SESSION['canalSeleccionado'];
include("plantilla/index.php");