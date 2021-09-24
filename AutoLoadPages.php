<?php
require_once('config/config.php');

if(ESTADO_PROJETO === "PROD") {
    error_reporting(0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', true);
}

require_once('controller/main/Request.php');
$Request = new Request;

$controller = $Request->request[0]['controller'];
$method = $Request->request[1]['method'];

$pagina_Atual = $controller;
$funcao_Atual = $method;

$date = new DateTime();

function AutoLoadPages($className) {
    $obj_class = NULL;
    $diretorio_controller = "controller";
    spl_autoload_extensions("Controller.php");
    $extension =  spl_autoload_extensions();

    if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . $diretorio_controller . DIRECTORY_SEPARATOR . $className . $extension)) {
        require_once(__DIR__ . DIRECTORY_SEPARATOR . $diretorio_controller . DIRECTORY_SEPARATOR . $className . $extension);
        $nome_class = $className.explode(".php", $extension)[0];
        $load_class = $nome_class;

        if(class_exists($load_class)) {
            $obj_class = new $load_class;
        }
    } else {
        $obj_class = "Index";
    }

    return $obj_class;
}

$nome_class = AutoLoadPages($controller);

if(method_exists($nome_class, $method)) {
    $parameters = $_GET;
    unset($parameters['controller']);
    unset($parameters['method']);
    $html_pagina = call_user_func(array($nome_class, $method), $parameters);
} else {
    $html_pagina = "1 - Página não encontrada!";
}
?>