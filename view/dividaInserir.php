<?php $dados_divida = $html_pagina['library']['registros']; ?>
<div class="divida form-inserir">
    <input type="hidden" name="divida_id" value="<?php echo isset($dados_divida['divida'])&&!empty($dados_divida['divida'])?$dados_divida['divida']['divida_id']:''; ?>" readonly="readonly" />
    <div class="row">
        <div class="col">
            <label for="titulo">Título</label><input type="text" name="titulo" class="form-control" id="titulo" value="<?php echo isset($dados_divida['divida'])&&!empty($dados_divida['divida'])?$dados_divida['divida']['tituloDivida']:''; ?>" placeholder="Digite TÍTULO" maxlength="200" />
        </div>
        <div class="col">
            <label for="usuario_id">Selecione o Usuário</label>
            <select name="usuario_id" class="form-control" id="usuario_id">
                <option value="">-- Selecione --</option>
                <?php
                if(isset($dados_divida['usuarios']) && !empty($dados_divida['usuarios'])) {
                    foreach($dados_divida['usuarios'] as $key => $value) {
                        $selected = '';

                        if(isset($dados_divida['divida']) && !empty($dados_divida['divida']) && $dados_divida['divida']['usuario_id'] == $value['id']) {
                            $selected = ' selected="selected"';
                        }

                        echo '<option value="' . $value['id'] . '"'.$selected.'>' . $value['nome'] . ' - ' . $value['cpf_cnpj'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="valor">Valor</label><input type="text" name="valor" class="form-control" id="valor" value="<?php echo isset($dados_divida['divida'])&&!empty($dados_divida['divida'])?$dados_divida['divida']['valor']:''; ?>" placeholder="Digite o Valor da Dívida" maxlength="27" />
        </div>
        <div class="col">
            <label for="data_vencimento">Data do Vencimento</label><input type="text" name="data_vencimento" readonly="readonly" class="form-control" id="data_vencimento" value="<?php echo isset($dados_divida['divida'])&&!empty($dados_divida['divida'])?$dados_divida['divida']['data_vencimento']:''; ?>" placeholder="Selecione a Data do Vencimento" style="background-color:#FFF !important;" />
        </div>
    </div>
    <br /><br /><br />
    <div class="row">
        <div class="col-4">
            <a href="?controller=divida"><input type="button" value="VOLTAR" class="form-control voltar btn btn-warning" /></a>
        </div>
        <div class="col-4">
            <input type="reset" value="LIMPAR" class="form-control btn btn-danger" />
        </div>
        <div class="col-4">
            <input type="button" value="SALVAR" class="form-control btn btn-primary" />
        </div>
    </div>
    <br />
</div>
<div class="modal fade" id="modal_valida_divida" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">Alerta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<?php if(isset($dados_divida['divida']) && !empty($dados_divida['divida'])): ?>
<script type="text/javascript">
$(function() {
    $('#divida_id').val('<?php echo $dados_divida['divida']['divida_id']; ?>');
});
</script>
<?php endif ?>