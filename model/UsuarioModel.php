<?php
require_once('main/MainModel.php');

class UsuarioModel extends MainModel {
    private $nome_tabela = "usuario";
    
    public function __construct() {
        $this->setTable($this->nome_tabela);
    }

    public function trazer_dados_usuario($id_usuario, $degug = 0) {
        $str_sql = "SELECT usuario.id AS idUsuario, usuario.*, endereco.* FROM " . $this->nome_tabela;
        $str_sql .= " LEFT JOIN endereco ON endereco.id_usuario = usuario.id";
        $str_sql .= " WHERE usuario.id = " . (int)$id_usuario;

        $dados_usuario = $this->specific_query($str_sql, $degug);

        return $dados_usuario;
    }
}