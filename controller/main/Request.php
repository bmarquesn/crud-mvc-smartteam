<?php
class Request {
    public $request = array();

    public function __construct() {
        /** por default, primeiramente será carregado o Controller Login */
        if(isset($_GET['controller']) && !empty($_GET['controller'])) {
            array_push($this->request, array("controller" => $_GET['controller']));
        } else {
            array_push($this->request, array("controller" => "Login"));
        }

        if(isset($_GET['method']) && !empty($_GET['method'])) {
            array_push($this->request, array("method" => $_GET['method']));
        } else {
            array_push($this->request, array("method" => "index"));
        }
    }
    
    public function __get($nome) {
        if(!empty($this->request)) {
            if (isset($this->request[$nome]) && !empty($this->request[$nome])) {
                unset($_POST[$nome]);
                return $this->request[$nome];
            }
        }

        return false;
    }
}