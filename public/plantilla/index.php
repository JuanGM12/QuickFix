<?php
$plantilla = "plantilla/";
if(isset($_GET['informacion']) && $_GET['informacion'] != ''){
    $informacion = $_GET['informacion'];
}



include($plantilla . "contenido.php");
