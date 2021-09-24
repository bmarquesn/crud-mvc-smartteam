<?php
require_once('main/MainController.php');

class UsuarioController extends Controller {
    private $UsuarioModel;
    private $EnderecoModel;

    public function __construct() {
        session_start();

        if(!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
            header('Location:?controller=login&method=logout&message=Preciso-Estar-Logado');
        } else {
            require_once('model/UsuarioModel.php');
            $this->UsuarioModel = new UsuarioModel;
            require_once('model/EnderecoModel.php');
            $this->EnderecoModel = new EnderecoModel;
        }
    }

    public function index() {
        $filtro_1 = isset($_GET['filtro_1'])&&!empty($_GET['filtro_1'])?$_GET['filtro_1']:0;
        $filtro_2 = isset($_GET['filtro_2'])&&!empty($_GET['filtro_2'])?$_GET['filtro_2']:0;
        $ativo = 1;

        if(!empty($filtro_1) || !empty($filtro_2)) {
            $array_filtro[] = ['nome', $filtro_1];
            $array_filtro[] = ['email', $filtro_2];
            $registros = $this->UsuarioModel->all_filter($array_filtro, 'OR', 'LIKE', $ativo);
        } else {
            $registros = $this->UsuarioModel->all($ativo);
        }

        return $this->view('usuario', [
            'registros' => $registros
            ,'script_pages' => 'usuario.js'
        ], 'pagina_interna');
    }

    public function inserir() {
        return $this->view('usuarioInserir', [
            'registros' => null
            ,'css_pages' => 'jquery-ui/jquery-ui.min.css'
            ,'script_pages' => ['jquery-ui/jquery-ui.min.js', 'usuario.js']
        ], 'pagina_interna');
    }

    public function salvar() {
        $dados_salvar = $_POST;
        $id_usuario = NULL;

        foreach($dados_salvar as $key => $value) {
            $novo_usuario = true;

            if(!empty(trim($value))) {
                if($key == 'usuario_id' && !empty($value)) {
                    $novo_usuario = false;
                    $this->UsuarioModel->__set('id', (int)$value);
                    /** chave estrangeira - na tabela endereco tem o id_usuario */
                    $this->EnderecoModel->__set('usuario_id', (int)$value);
                }

                /** usa-se esta parte para usar na atualização */
                if($key == 'usuario_id' && !empty($value)) {
                    $novo_usuario = false;
                    $this->UsuarioModel->__set('id', 'id-'.(int)$value);
                    /** chave estrangeira - na tabela endereco tem o id_usuario */
                    $this->EnderecoModel->__set('id', 'usuario_id-'.(int)$value);
                }

                if($key == 'nome' || $key == 'email' || $key == 'cpf_cnpj' || $key == 'senha' || $key == 'data_nascimento') {
                    if($key == 'senha') {
                        $this->UsuarioModel->__set($key, md5($value.$this->hash_senha));
                    } elseif($key == 'cpf_cnpj') {
                        $this->UsuarioModel->__set($key, preg_replace("/[^0-9]/", "", $value));
                    } elseif($key == 'data_nascimento') {
                        $this->UsuarioModel->__set($key, substr($value, 6) . '-' . substr($value, 3, -5) . '-' . substr($value, 0, -8));
                    } else {
                        $this->UsuarioModel->__set($key, $value);
                    }
                } else if($key == 'cep' || $key == 'logradouro' || $key == 'numero_endereco' || $key == 'complemento_endereco' || $key == 'bairro' || $key == 'cidade' || $key == 'uf') {
                    if($key == 'cep') {
                        $this->EnderecoModel->__set($key, preg_replace("/[^0-9]/", "", $value));
                    } else {
                        $this->EnderecoModel->__set($key, $value);
                    }
                }
            }
        }

        $id_usuario = $this->UsuarioModel->save(0);

        if(strripos($id_usuario, 'Error') === false) {
            if($novo_usuario) {
                $this->EnderecoModel->__set('usuario_id', (int)$id_usuario);
            }

            $this->EnderecoModel->save(0);

            echo "salvou";
        } else {
            /** aqui mostrará o erro SQL */
            echo $id_usuario;
        }

        die;
    }

    public function editar() {
        if(isset($_GET['identifier']) && !empty($_GET['identifier'])) {
            $id_usuario = (int)$_GET['identifier'];
        }

        $dados_usuario = $this->UsuarioModel->trazer_dados_usuario($id_usuario, 0);

        if(!empty($dados_usuario[0])) {
            $dados_usuario[0]['data_nascimento'] = substr($dados_usuario[0]['data_nascimento'], 8, 2) . '/' . substr($dados_usuario[0]['data_nascimento'], 5, 2) . '/' . substr($dados_usuario[0]['data_nascimento'], 0, 4);
        }

        return $this->view('usuarioInserir', [
            'registros' => $dados_usuario[0]
            ,'css_pages' => 'jquery-ui/jquery-ui.min.css'
            ,'script_pages' => ['jquery-ui/jquery-ui.min.js', 'usuario.js']
        ], 'pagina_interna');
    }

    public function excluir() {
        $dados_salvar = $_POST;

        $this->UsuarioModel->destroy(array_keys($dados_salvar)[0], array_values($dados_salvar)[0], 0);
        $this->EnderecoModel->destroy('usuario_id', array_values($dados_salvar)[0], 1);

        echo "excluiu";
        die;
    }
}