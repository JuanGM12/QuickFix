<?php
$plantilla = "plantilla/";
if(isset($_GET['informacion']) && $_GET['informacion'] != ''){
    $informacion = $_GET['informacion'];
}
if(isset($_GET['inicio']) && $_GET['inicio'] != ''){
    $inicio = $_GET['inicio'];
}
include ("modulos/bloqueoSeguridad.php");
?>

<!DOCTYPE html>
<html lang="es"> 
<head>
    <title>QuickFix - Servicios de máxima cálidad</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="QuickFix - Prestamos todo tipo de">
    <meta name="author" content="Grupo 11">    
    <link rel="shortcut icon" href="favicon.ico"> 
    <script defer src="/plantilla/plugins/fontawesome/js/all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<?php
if (!isset($_GET['informacion'])) {
 include ($plantilla. "inicial.php");
    echo '<link rel="stylesheet" href="/plantilla/css/estilos.css">';
}else{
    echo '<link id="theme-style" rel="stylesheet" href="/plantilla/css/style.css">';
    include ($plantilla . "header.php");
}
include($plantilla . "contenido.php");
?>
</head> 
<script src="/plantilla/plugins/popper.min.js"></script>
<script src="/plantilla/plugins/bootstrap/js/bootstrap.min.js"></script>  
<script src="/plantilla/plugins/chart.js/chart.min.js"></script> 
<script src="/plantilla/js/index-charts.js"></script> 
<script src="/plantilla/js/app.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</html> 
<?php include ($plantilla . "footer.php");

