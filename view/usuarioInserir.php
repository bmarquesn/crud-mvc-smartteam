<?php $dados_usuario = $html_pagina['library']['registros']; ?>
<div class="usuario form-inserir">
    <input type="hidden" name="usuario_id" value="<?php echo isset($dados_usuario)&&!empty($dados_usuario)?$dados_usuario['usuario_id']:''; ?>" readonly="readonly" />
    <div class="row">
        <div class="col">
            <label for="cpf_cnpj">CPF/CNPJ</label><input type="text" name="cpf_cnpj" class="form-control" id="cpf_cnpj" value="<?php echo isset($dados_usuario)&&!empty($dados_usuario)?$dados_usuario['cpf_cnpj']:''; ?>" placeholder="Digite CPF/CNPJ" maxlength="20" />
        </div>
        <div class="col">
            <label for="nome">Nome</label><input type="text" name="nome" class="form-control" id="nome" value="<?php echo isset($dados_usuario)&&!empty($dados_usuario)?$dados_usuario['nome']:''; ?>" placeholder="Digite o Nome do Usuário" />
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="email">Email</label><input type="text" name="email" class="form-control" id="email" value="<?php echo isset($dados_usuario)&&!empty($dados_usuario)?$dados_usuario['email']:''; ?>" placeholder="Digite o Email do Usuário" maxlength="200" />
        </div>
        <div class="col">
            <label for="data_nascimento">Data de Nascimento</label><input type="text" name="data_nascimento" readonly="readonly" class="form-control" id="data_nascimento" value="<?php echo isset($dados_usuario)&&!empty($dados_usuario)?$dados_usuario['data_nascimento']:''; ?>" placeholder="Selecione a Data de Nascimento" style="background-color:#FFF !important;" />
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="senha">Senha</label><input type="password" name="senha" class="form-control" id="senha" value="" placeholder="Digite a Senha" />
        </div>
    </div>
    <br />
    <h3>Dados de Endereço</h3>
    <div class="row">
        <div class="col-3">
            <label for="cep">CEP</label><input type="text" name="cep" class="form-control" id="cep" value="<?php echo isset($dados_usuario)&&!empty($dados_usuario)?$dados_usuario['cep']:''; ?>" placeholder="CEP" />
        </div>
        <div class="col-6">
            <label for="logradouro">Endereço</label><input type="text" name="logradouro" class="form-control" id="logradouro" value="<?php echo isset($dados_usuario)&&!empty($dados_usuario)?$dados_usuario['logradouro']:''; ?>" placeholder="Endereço" />
        </div>
        <div class="col-3">
            <label for="numero_endereco">Número</label><input type="text" name="numero_endereco" class="form-control" id="numero_endereco" value="<?php echo isset($dados_usuario)&&!empty($dados_usuario)?$dados_usuario['numero_endereco']:''; ?>" placeholder="Número" />
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <label for="complemento_endereco">Complemento</label><input type="text" name="complemento_endereco" class="form-control" id="complemento_endereco" value="<?php echo isset($dados_usuario)&&!empty($dados_usuario)?$dados_usuario['complemento_endereco']:''; ?>" placeholder="Complemento" />
        </div>
        <div class="col-3">
            <label for="bairro">Bairro</label><input type="text" name="bairro" class="form-control" id="bairro" value="<?php echo isset($dados_usuario)&&!empty($dados_usuario)?$dados_usuario['bairro']:''; ?>" placeholder="bairro" />
        </div>
        <div class="col-3">
            <label for="cidade">Cidade</label><input type="text" name="cidade" class="form-control" id="cidade" value="<?php echo isset($dados_usuario)&&!empty($dados_usuario)?$dados_usuario['cidade']:''; ?>" placeholder="Cidade" />
        </div>
        <div class="col-3">
            <label for="uf">UF</label>
            <select name="uf" class="form-control" id="uf">
                <option value="">Selecione</option>
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espirito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MT">Mato Grosso</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
            </select>
        </div>
    </div>
    <br /><br /><br />
    <div class="row">
        <div class="col-4">
            <a href="?controller=usuario"><input type="button" value="VOLTAR" class="form-control voltar btn btn-warning" /></a>
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
<div class="modal fade" id="modal_valida_usuario" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
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
<?php if(isset($dados_usuario) && !empty($dados_usuario)): ?>
<script type="text/javascript">
$(function() {
    $('#uf').val('<?php echo $dados_usuario['uf']; ?>');
});
</script>
<?php endif ?>