<?php
$plantilla = "plantilla/";
if(isset($_GET['informacion']) && $_GET['informacion'] != ''){
    $informacion = $_GET['informacion'];
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
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="favicon.ico"> 
    
    <!-- FontAwesome JS-->
    <script defer src="/plantilla/plugins/fontawesome/js/all.min.js"></script>
	
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="/plantilla/css/style.css">

</head> 



<?php
if (!isset($_GET['informacion'])) {
// include ($plantilla. "inicial.php");
}
?>
<?php include ($plantilla . "header.php");


include($plantilla . "contenido.php");

?>

<script src="/plantilla/plugins/popper.min.js"></script>
    <script src="/plantilla/plugins/bootstrap/js/bootstrap.min.js"></script>  

    <!-- Charts JS -->
    <script src="/plantilla/plugins/chart.js/chart.min.js"></script> 
    <script src="/plantilla/js/index-charts.js"></script> 
    
    <!-- Page Specific JS -->
    <script src="/plantilla/js/app.js">
    <script src="/plantilla/js/app.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    </script> 
</html> 
<?php include ($plantilla . "footer.php");

