<?php

if(!defined('DEBUG')){
    require_once __DIR__ . "/config.php";
}

if(DEBUG){
    ini_set('display_errors', 1);
    ini_set("log_errors", 1);
    ini_set("error_log", __DIR__ . "/php_error_log");
    error_reporting(E_ALL);
}else{
    ini_set('display_errors', 0);
    ini_set("log_errors", 1);
    ini_set("error_log", __DIR__ . "/php_error_log");
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_WARNING);
}

session_start();

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventas.controlador.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "extensiones/vendor/autoload.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();
