<?php
require_once('Request.php');

class Controller extends Request {
    public $request;
    public $hash_senha = "*8run0_n0Gu3ir4_h45H*";

    public function __construct() {
    }
    
    public function view($arquivo, $array = null, $tipo_view = null) {
        if (!is_null($array)) {
            foreach ($array as $var => $value) {
                ${$var} = $value;
            }
        }

        ob_start();
        $retorno_controller = array(
            'page_include' => "view" . DIRECTORY_SEPARATOR . "{$arquivo}.php"
            ,'library' => $array
            ,'tipo_view' => $tipo_view
        );
        return $retorno_controller;
        ob_flush();
    }
}