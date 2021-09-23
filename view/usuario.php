<div class="usuario">
    <!-- p><a href="?controller=usuario&method=inserir" class="btn-sm btn-primary">INSERIR</a></p -->
    <table class="table table-bordered table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th class="col-5">Nome</th>
                <th class="col-5">E-mail</th>
                <th colspan="2" class="col-2 text-center">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php
        if(!isset($html_pagina['library']['registros']) || empty($html_pagina['library']['registros'])) {
            echo '<tr><td colspan="4"><em>Não há Usuários cadastrados</em></td></tr>';
        } else {
            foreach($html_pagina['library']['registros'] as $key => $value) {
                echo '<tr>';
                    echo '<td><input type="hidden" value="' . $value['id'] . '" />' . $value['nome'] . '</td>';
                    echo '<td>' . $value['email'] . '</td>';
                    echo '<td class="text-center"><button type="button" class="btn btn-primary usuario_editar" title="Visualizar/Editar Usuário">V / E</button></td>';
                    echo '<td class="text-center"><button type="button" class="btn btn-danger usuario_excluir" title="Excluir Usuário">X</button></td>';
                echo '</tr>';
            }
        }
        ?>
        </tbody>
    </table>
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