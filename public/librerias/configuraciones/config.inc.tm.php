<?php

define('PATH_REQUIRES', $_SERVER['DOCUMENT_ROOT'] . '/librerias/configuraciones/requires.php');
define('PATH_REQUIRE_CANAL', $_SERVER['DOCUMENT_ROOT'] . '/librerias/configuraciones/requires.tm.php');
define('PATH_LIBRARIES', $_SERVER['DOCUMENT_ROOT'] . '/librerias/');
define('PATH_DAO', $_SERVER['DOCUMENT_ROOT'] . '/librerias/clases_dao/');

$DB = array();
$DB["dbName"] = "quickfix_bd";
$DB["host"] = "localhost";
$DB["user"] = "root";
$DB["pass"] = "";
$DB["class"] = PATH_DAO . "class_base_datos.php";