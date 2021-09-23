<?php
require_once('config/Conexao.php');

class MainModel extends Conexao {
    private $atributos;
    private $table;

    public function __construct() {}

    public function __set(string $atributo, $valor) {
        $this->atributos[$atributo] = $valor;
        return $this;
    }

    public function __get(string $atributo) {
        return $this->atributos[$atributo];
    }

    public function __isset($atributo) {
        return isset($this->atributos[$atributo]);
    }

    public function setTable(string $TableName) {
        $this->table = $TableName;
        return $this;
    }

    public function getTable() {
        return $this->table;
    }

    public function all($ativo = 1) {
        $mysqli = Conexao::getInstance();

        $str_sql = "SELECT * FROM " . $this->table . " WHERE ativo = ". $ativo;

        if($stmt = $mysqli->prepare($str_sql)) {
            $result = array();
        
            if($stmt->execute()) {
                $obj_result = $stmt->get_result();

                while ($rs = $obj_result->fetch_assoc()) {
                    $result[] = $rs;
                }
            }
            
            if(count($result) > 0) {
                return $result;
            }
        }

        return false;
    }

    public function all_filter($array_filtro = array(), $and_or = "AND", $like_equal = "=", $ativo = 1) {
        $conexao_bd = Conexao::getInstance();
        
        $str_sql = "SELECT * FROM " . $this->table . " WHERE (";

        foreach($array_filtro as $key => $value) {
            if((int)$key === 0) {
                if($like_equal === "=") {
                    $str_sql .= $value[0] . $like_equal . $value[1];
                } else {
                    $str_sql .= $value[0] . " LIKE('%%" . $value[1] . "%%')";
                }
            } else {
                if($like_equal === "=") {
                    $str_sql .= " " . $and_or . " " . $value[0] . $like_equal . $value[1];
                } else {
                    $str_sql .= " " . $and_or . " " . $value[0] . " LIKE('%%" . $value[1] . "%%')";
                }
            }
        }

        $str_sql .= ") AND ativo = " . $ativo;

        if($stmt = $conexao_bd->prepare($str_sql)) {
            $result = array();
            
            if($stmt->execute()) {
                if(TIPOBD === "MYSQL") {
                    $obj_result = $stmt->get_result();
                } elseif(TIPOBD === "PDO") {

                }
                
                if(!empty($obj_result)) {
                    while ($rs = $obj_result->fetch_assoc()) {
                        $result[] = $rs;
                    }
                }
            }
            
            if(count($result) > 0) {
                return $result;
            }
        }

        return false;
    }

    public function save($debug = 0) {
        $colunas = $this->preparar($this->atributos);

        if(!isset($this->id) || empty($this->id)) {
            $query = "INSERT INTO " . $this->table . " (". implode(', ', array_keys($colunas)) . ") VALUES (" . implode(', ', array_values($colunas)).");";
        } else {
            foreach ($colunas as $key => $value) {
                if($key !== 'id') {
                    $definir[] = "{$key}={$value}";
                }
            }

            $query = "UPDATE " . $this->table . " SET ".implode(', ', $definir)." WHERE ".explode("-", $this->id)[0]."=". $this->escapar(explode("-", $this->id)[1]) . ";";
        }
        
        if($conexao = Conexao::getInstance()) {
            if($debug === 0) {
                $stmt = $conexao->prepare($query);
            } else {
                /** para debugar */
                var_dump($query);
                die;
            }
            
            if($stmt->execute()) {
                if(!isset($this->id) || empty($this->id)) {
                    return $stmt->insert_id;
                } else {
                    return (int)explode("-", $this->id)[1];
                }
            }
        }

        return false;
    }

    public function escapar($dados) {
        if(is_string($dados) & !empty($dados)) {
            return "'".addslashes($dados)."'";
        } elseif(is_bool($dados)) {
            return $dados ? 'TRUE' : 'FALSE';
        } elseif(is_int($dados)) {
            return (int)$dados;
        } elseif($dados !== '') {
            return $dados;
        } else {
            return 'NULL';
        }
    }

    private function preparar($dados) {
        $resultado = array();

        foreach ($dados as $k => $v) {
            if(is_scalar($v)) {
                $resultado[$k] = $this->escapar($v);
            }
        }
        
        return $resultado;
    }

    public function count() {
        $conexao = Conexao::getInstance();
        $count = $conexao->exec("SELECT count(*) FROM " . $this->table . ";");

        if($count) {
            return (int)$count;
        }

        return false;
    }

    public function find($id) {
        $conexao = Conexao::getInstance();
        $stmt = $conexao->prepare("SELECT * FROM " . $this->table . " WHERE id='{$id}';");

        if($stmt->execute()) {
            if($stmt->rowCount() > 0) {
                $resultado = $stmt->fetchObject(ucfirst($this->table));
                if($resultado) {
                    return $resultado;
                }
            }
        }

        return false;
    }

    public function destroy($campo,  $id, $excluir = 0) {
        if($excluir === 1) {
            $query = "DELETE FROM " . $this->table . " WHERE " . $campo . " = " . (int)$id . ";";
        } else {
            $query = "UPDATE " . $this->table . " SET ativo = 0 WHERE " . $campo . " = " . (int)$id . ";";
        }

        if($conexao = Conexao::getInstance()) {
            $stmt = $conexao->prepare($query);
            
            $stmt->execute();
            
            return true;
        }

        return false;
    }

    public function specific_query($query_sql, $debug = 0) {
        if($debug === 1) {
            var_dump($query_sql);
            die;
        } else {
            if($conexao = Conexao::getInstance()) {
                $stmt = $conexao->prepare($query_sql);

                if($stmt->execute()) {
                    $obj_result = $stmt->get_result();

                    while ($rs = $obj_result->fetch_assoc()) {
                        $result[] = $rs;
                    }

                    return $result;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}