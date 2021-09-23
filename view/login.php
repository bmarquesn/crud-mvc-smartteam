<div class="line_top"></div>
<div class="container-fluid">
    <div class="row min-vh-100 align-items-center" id="login">
        <div class="col text-center">
            <form action="?controller=Login&method=logar" method="post" onsubmit="return validaLogin()">
                <a href="index.php"><img src="assets/img/bruno_marques_nogueira_avatar.jpg" class="img-fluid" alt="Bruno Marques Nogueira - Programmer – Analyst - Manager" title="Bruno Marques Nogueira - Programmer – Analyst - Manager" /></a>
                <br />
                <div class="row" id="mensagem">
                    <div class="col">
                        <div class="alert alert-danger" role="alert"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="email">E-Mail</label>
                            </div>
                            <input type="text" name="email" value="" placeholder="E-MAIL" class="form-control" id="email" aria-label="E-mail" aria-describedby="inputGroup-sizing-default" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="senha">Senha</label>
                            </div>
                            <input type="password" name="senha" value="" placeholder="SENHA" class="form-control" id="senha" aria-label="Senha" aria-describedby="inputGroup-sizing-default" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <strong>CÓDIGO DE VERIFICAÇÃO:</strong>
                    </div>
                    <div class="col" id="codigo_gerado">
                        <?php echo $html_pagina['library']['hash_login']; ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="codigo">DIGITE O CÓDIGO DE VERIFICAÇÃO</label>
                            </div>
                            <input type="text" name="codigo" value="" placeholder="CÓDIGO" class="form-control" id="codigo" aria-label="Código de Verificação" aria-describedby="inputGroup-sizing-default" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="ENTRAR" class="btn btn-primary" />
                    </div>
                </div>
            </form>
        </div>
        <div class="col">
            <h1>CRUD MVC SMARTTEAM<br />Bruno Marques Nogueira</h1>
            <ul>
                <li><strong>M</strong>odel - Camada responsável por acesso e interações com o Banco de dados. É, talvez, a camada mais importante</li>
                <li><strong>V</strong>iew - Camada responsável por exibir o sistema. É onde o usuário interage</li>
                <li><strong>C</strong>ontroller - Camada responsável por fazer o controle de todo o sistema. É aqui que o sistema conversa com o Banco de Dados (as Models), conversa com as telas (as Views) e realiza toda, ou quase toda, a lógica que o sistema necessita</li>
            </ul>
        </div>
    </div>
</div>
<?php
if(!empty($html_pagina['library']['message'])) {
    echo '<script type="text/javascript">$(function(){exibirAlertaLogin("' . str_replace('-', ' ', $html_pagina['library']['message']) . '");});</script>';
}
?>