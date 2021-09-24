<?php
require_once('model/DividaModel.php');
require_once('main/MainController.php');

class DividaController extends Controller {
    private $DividaModel;
    private $UsuarioModel;

    public function __construct() {
        session_start();

        if(!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
            header('Location:?controller=login&method=logout&message=Preciso-Estar-Logado');
        } else {
            require_once('model/DividaModel.php');
            $this->DividaModel = new DividaModel;
            require_once('model/UsuarioModel.php');
            $this->UsuarioModel = new UsuarioModel;
        }
    }

    public function index() {
        $filtro_1 = isset($_GET['filtro_1'])&&!empty($_GET['filtro_1'])?$_GET['filtro_1']:0;
        $filtro_2 = isset($_GET['filtro_2'])&&!empty($_GET['filtro_2'])?$_GET['filtro_2']:0;
        $filtro_3 = isset($_GET['filtro_3'])&&!empty($_GET['filtro_3'])?$_GET['filtro_3']:0;
        $filtro_4 = isset($_GET['filtro_4'])&&!empty($_GET['filtro_4'])?$_GET['filtro_4']:0;

        if(!empty($filtro_1) || !empty($filtro_2) || !empty($filtro_3) || !empty($filtro_4)) {
            $array_filtro[] = ['nomeUsuario', $filtro_1];
            $array_filtro[] = ['titulo', $filtro_2];
            $array_filtro[] = ['valor', str_replace('R$ ', '', str_replace(',', '.', str_replace('.', '', $filtro_3)))];
            $array_filtro[] = ['data_vencimento', $filtro_4];

            $registros['dividas'] = $this->DividaModel->trazer_dados_dividas(null, $array_filtro, ['data_vencimento' => 'DESC', 'valor' => 'DESC'], 0);
        } else {
            $registros['dividas'] = $this->DividaModel->trazer_dados_dividas(null, null, ['data_vencimento' => 'DESC', 'valor' => 'DESC'], 0);
        }

        $registros['dividas_vencidas']['qtd'] = 0;
        $registros['dividas_vencidas']['valor'] = 0;
        $registros['dividas_apagar']['qtd'] = 0;
        $registros['dividas_apagar']['valor'] = 0;

        if(!empty($registros['dividas'])) {
            foreach($registros['dividas'] as $key => $value) {
                if(strtotime(date('Y-m-d')) > strtotime($value['data_vencimento'])) {
                    $registros['dividas_vencidas']['qtd']++;
                    $registros['dividas_vencidas']['valor'] = $registros['dividas_vencidas']['valor'] + $value['valor'];
                } else {
                    $registros['dividas_apagar']['qtd']++;
                    $registros['dividas_apagar']['valor'] = $registros['dividas_apagar']['valor'] + $value['valor'];
                }
            }
        }

        return $this->view('divida', [
            'registros' => $registros
            ,'css_pages' => 'jquery-ui/jquery-ui.min.css'
            ,'script_pages' => ['jquery-ui/jquery-ui.min.js', 'divida.js', 'jquery.maskMoney.js']
        ], 'pagina_interna');
    }

    public function inserir() {
        $ativo = 1;
        $registros['usuarios'] = $this->UsuarioModel->all($ativo, ['nome', 'ASC']);

        return $this->view('dividaInserir', [
            'registros' => $registros
            ,'css_pages' => 'jquery-ui/jquery-ui.min.css'
            ,'script_pages' => ['jquery-ui/jquery-ui.min.js', 'divida.js', 'jquery.maskMoney.js']
        ], 'pagina_interna');
    }

    public function salvar() {
        $dados_salvar = $_POST;
        $id_divida = NULL;

        foreach($dados_salvar as $key => $value) {
            if(!empty(trim($value))) {
                /** usa-se esta parte para usar na atualização */
                if($key == 'divida_id' && !empty($value)) {
                    $this->DividaModel->__set('id', 'id-'.(int)$value);
                }

                if($key == 'usuario_id') {
                    $this->DividaModel->__set($key, (int)$value);
                } elseif($key == 'valor') {
                    $this->DividaModel->__set($key, str_replace('R$ ', '', str_replace(',', '.', str_replace('.', '', $value))));
                } elseif($key == 'data_vencimento') {
                    $this->DividaModel->__set($key, substr($value, 6) . '-' . substr($value, 3, -5) . '-' . substr($value, 0, -8));
                } else {
                    if($key != 'divida_id') {
                        $this->DividaModel->__set($key, $value);
                    }
                }
            }
        }

        $id_divida = $this->DividaModel->save(0);

        if(strripos($id_divida, 'Error') === false) {
            echo "salvou";
        } else {
            /** aqui mostrará o erro SQL */
            echo $id_divida;
        }

        die;
    }

    public function editar() {
        if(isset($_GET['identifier']) && !empty($_GET['identifier'])) {
            $id_divida = (int)$_GET['identifier'];
        }

        $ativo = 1;

        $dados_divida = $this->DividaModel->trazer_dados_dividas($id_divida, null, null, 0);

        if(!empty($dados_divida[0])) {
            $dados_divida[0]['data_vencimento'] = substr($dados_divida[0]['data_vencimento'], 8, 2) . '/' . substr($dados_divida[0]['data_vencimento'], 5, 2) . '/' . substr($dados_divida[0]['data_vencimento'], 0, 4);
            $dados_divida[0]['valor'] = number_format($dados_divida[0]['valor'], 2, ',', '.');
        }

        $registros['divida'] = $dados_divida[0];

        $registros['usuarios'] = $this->UsuarioModel->all($ativo, ['nome', 'ASC']);

        return $this->view('dividaInserir', [
            'registros' => $registros
            ,'css_pages' => 'jquery-ui/jquery-ui.min.css'
            ,'script_pages' => ['jquery-ui/jquery-ui.min.js', 'divida.js', 'jquery.maskMoney.js']
        ], 'pagina_interna');
    }

    public function excluir() {
        $dados_salvar = $_POST;

        $this->DividaModel->destroy(array_keys($dados_salvar)[0], array_values($dados_salvar)[0], 0);

        echo "excluiu";
        die;
    }
}