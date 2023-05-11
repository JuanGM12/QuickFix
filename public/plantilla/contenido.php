<?php
switch ($informacion) {
    case 'inicio':
        include("vista/inicio.php");
        break;

    case 'notificaciones':
        include("vista/notificaciones.php");
        break;
    
    case 'ayuda':
        include("vista/ayuda.php");
        break;

    case 'servicios':
        include("vista/servicios.php");
        break;

    case 'configuracion':
        include("vista/configuracion.php");
        break;

    case 'agenda':
        include("vista/agenda.php");
        break;
}