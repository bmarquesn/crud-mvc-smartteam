<?php
require_once('main/MainModel.php');

class UsuarioModel extends MainModel {
    private $nome_tabela = "usuarios";
    private $tabela_enderecos = "enderecos";

    public function __construct() {
        $this->setTable($this->nome_tabela);
    }

    public function trazer_dados_usuario($id_usuario, $degug = 0) {
        $str_sql = "SELECT " . $this->nome_tabela . ".*, enderecos.* FROM " . $this->nome_tabela;
        $str_sql .= " LEFT JOIN " . $this->tabela_enderecos . " ON " . $this->tabela_enderecos . ".usuario_id = " . $this->nome_tabela . ".id";
        $str_sql .= " WHERE " . $this->nome_tabela . ".id = " . (int)$id_usuario;

        $dados_usuario = $this->specific_query($str_sql, $degug);

        return $dados_usuario;
    }
}