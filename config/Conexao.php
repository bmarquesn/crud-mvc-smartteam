<?php
require_once('config.php');

class Conexao {
    private static $conexao;

    private function __construct() {

    }

    public static function getInstance() {
        if(is_null(self::$conexao)) {
            if(TIPOBD === "PDO") {
                self::$conexao = new \PDO('mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DATABASE, USER, PASSWORD);
                self::$conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$conexao->exec('set names utf8');
            } elseif(TIPOBD === "MYSQL") {
                self::$conexao = new mysqli(HOST, USER, PASSWORD, DATABASE);
                self::$conexao->set_charset('utf8');

                if(self::$conexao->connect_error) {
                    echo "Erro na conexao: " . self::$conexao->connect_errno . self::$conexao->connect_error;
                    die;
                }
            }

        }

        return self::$conexao;
    }

    public static function closeConnection() {
        if(!is_null(self::$conexao)) {
            self::$conexao->close();
        }
    }
}