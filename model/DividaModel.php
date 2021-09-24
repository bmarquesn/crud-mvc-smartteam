<?php
require_once('main/MainModel.php');

class DividaModel extends MainModel {
    private $nome_tabela = "dividas";
    private $tabela_usuario = "usuarios";

    public function __construct() {
        $this->setTable($this->nome_tabela);
    }

    public function trazer_dados_dividas($id_divida = null, $filtro = null, $order = null,  $degug = 0) {
        $str_sql = "SELECT " . $this->nome_tabela . ".id AS divida_id, dividas.titulo AS tituloDivida, " . $this->nome_tabela . ".valor, " . $this->nome_tabela . ".data_vencimento, " . $this->nome_tabela . ".updated, " . $this->nome_tabela . ".usuario_id, " . $this->tabela_usuario . ".nome AS nomeUsuario";
        $str_sql .= " FROM " . $this->nome_tabela;
        $str_sql .= " LEFT JOIN " . $this->tabela_usuario . " ON " . $this->tabela_usuario . ".id = " . $this->nome_tabela . ".usuario_id";
        $str_sql .= " WHERE " . $this->nome_tabela . ".ativo = 1";

        if(!is_null($id_divida)) {
            $str_sql .= " AND " . $this->nome_tabela . ".id = " . (int)$id_divida;
        }

        if(!is_null($filtro)) {
            foreach($filtro as $key => $value) {
                if(!empty($value[1])) {
                    if($value[0] != "valor") {
                        if($value[0] == "nomeUsuario") {
                            $str_sql .= " AND " . $this->tabela_usuario . ".nome LIKE('%%" . $value[1] . "%%')";
                        } else {
                            if($value[0] == "data_vencimento") {
                                $str_sql .= " AND " . $this->nome_tabela . "." . $value[0] . " = '" . substr($value[1], 6) . '-' . substr($value[1], 3, -5) . '-' . substr($value[1], 0, -8) . "'";
                            } else {
                                $str_sql .= " AND " . $this->nome_tabela . "." . $value[0] . " LIKE('%%" . $value[1] . "%%')";
                            }
                        }
                    } else {
                        $str_sql .= " AND " . $this->nome_tabela . "." . $value[0] . " = '" . $value[1] . "'";
                    }
                }
            }
        }

        if(!is_null($order)) {
            $str_sql .= " ORDER BY ";

            $posicao_key = 1;

            foreach($order as $key => $value) {
                if($key !== 'nomeUsuario') {
                    if($posicao_key == 1) {
                        $str_sql .= $this->nome_tabela . "." . $key . " " . $value;
                    } else {
                        $str_sql .= ', ' . $this->nome_tabela . "." . $key . " " . $value;
                    }
                } else {
                    if($posicao_key == 1) {
                        $str_sql .= $this->tabela_usuario . ".nome " . $value;
                    } else {
                        $str_sql .= ', ' . $this->tabela_usuario . ".nome " . $value;
                    }
                }

                $posicao_key++;
            }
        }

        $dados_usuario = $this->specific_query($str_sql, $degug);

        return $dados_usuario;
    }
}