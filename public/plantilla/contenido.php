<?php
if(isset($informacion)){
switch ($informacion) {
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
}else{}

if(isset($inicio)){
    switch ($inicio) {
        case 'contacto':
            include("vista/contacto.php");
            break;

        case 'registrarse':
            include("modulos/registrarUsuario.php");
            break;
    }
}else{}