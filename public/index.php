<?php
session_start();
$_SESSION['canalSeleccionado'] = $_SERVER['DOCUMENT_ROOT'] . '/librerias/configuraciones/requires.tm.php';
include("plantilla/index.php");