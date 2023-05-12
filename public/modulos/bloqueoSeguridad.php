<?php
function verificaAutenticacion() {
    if(!isset($_SESSION['autenticado']) || (isset($_SESSION['autenticado'])) && $_SESSION['autenticado'] != "SI") {
        $auth = false;
    } else {
        $auth = true;
    }
    return $auth;
}