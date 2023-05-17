<?php
$plantilla = "plantilla/";
$vista = "vista/";
    include ($plantilla ."headerInicial.php");

if (!isset($_GET['inicio'])) {
 include ($vista. "inicial.php");
    echo '<link rel="stylesheet" href="/plantilla/css/estilos.css">';
}else{
}