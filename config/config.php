<?php
/** PROD ou DEV - para controle de exibição dos erros no server */
define("ESTADO_PROJETO", "DEV");
/** Dados Acesso Database */
/** O MySQLi só funciona com bancos de dados MySQL, enquanto o PDO é flexível e capaz de trabalhar com vários sistemas de banco de dados, incluindo IBM, Oracle e MySQL. */
//define("TIPOBD", "PDO");
define("TIPOBD", "MYSQL");
$tipo_conexao = $_SERVER['HTTP_HOST'];
$endereco_server = $_SERVER['SERVER_ADDR'];

if($endereco_server === '127.0.0.1') {
    /** dados servidor local */
    define("HOST", "localhost");
    define("PORT", "3306");
    define("USER", "root");
    define("PASSWORD", "");
    define("DATABASE", "crud_mvc_smartteam");
} else {
    /** dados servidor remoto */
    define("HOST", "");
    define("PORT", "");
    define("USER", "");
    define("PASSWORD", "");
    define("DATABASE", "crud_mvc_smartteam");
}