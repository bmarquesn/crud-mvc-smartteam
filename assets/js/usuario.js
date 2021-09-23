$(function(){
	$('button.inserir_usuario').click(function(){
		window.location.href="?controller=usuario&method=inserir";
	});
	$('.conteudo_interno .usuario').find('input[type="button"][value="ENVIAR"]').click(function(){
		if(valida_usuario()){
			alert('Usuario salvo com sucesso!!!');
			window.location.href="?controller=usuario&method=index";
		}
    });
    /** botao excluir */
	$('button.usuario_excluir').on('click', function(){
		texto_retorno='<strong>Excluindo Usuário. Aguarde...</strong><br /><img src="assets/img/loader.gif" alt="Carregando" style="width:15%;" />';
		exibir_alerta_campo("#modal_valida_usuario", '', texto_retorno);
		var confirmar = confirm('Deseja mesmo excluir o Usuário selecionado?');
		if(confirmar){
			var id_usuario=$(this).parent('td').parent('tr').children('td:first').children('input').val().trim();
			$.ajax({
				type:"POST",
				data:{id:id_usuario},
				url:'?controller=usuario&method=excluir',
				cache:'false',
				dataType:'json',
				beforeSend: function(){
					texto_retorno='<strong>Excluindo Usuário. Aguarde...</strong><br /><img src="assets/img/loader.gif" alt="Carregando" style="width:15%;" />';
					exibir_alerta_campo("#modal_valida_usuario", '', texto_retorno);
				},
				complete:function(msg){
					$('#modal_valida_usuario').find('.modal-body').children('p').html('');
					$('#modal_valida_usuario').modal('hide');

					if(msg.responseText=="salvou"){
						alert('Usuário excluído com sucesso!!!');
						window.location.href="?controller=usuario&method=index";
					}else{
						alert('Erro ao excluir o Usuário!!!');
					}
				}
			});
		}
	});
	/** botao editar */
	$('button.usuario_editar').on('click', function(){
		var id_usuario=$(this).parent('td').parent('tr').children('td:first').children('input').val().trim();
		window.location.href="?controller=usuario&method=editar&identifier="+id_usuario;
    });
    /** buscar/filtrar */
	$('button.buscar_usuario').click(function(){
		var nome_responsavel=$('#menu_busca').find('input[type="text"]:first').val().trim();
		var email_responsavel=$('#menu_busca').find('input[type="text"]:last').val().trim();
		if(nome_responsavel!=""||email_responsavel!=""){
			window.location.href="?controller=usuario&method=index&filtro_1="+nome_responsavel+"&filtro_2="+email_responsavel;
		}else{
			window.location.href="?controller=usuario&method=index";
		}
	});
	$('#menu_busca').find('input[type="text"]:first').keypress(function(event) {
		if(event.which == 13) {
			if($(this).val().trim()!=""){
				$('button.buscar_usuario').click();
			}
		 }
	});
	$('#menu_busca').find('input[type="text"]:last').keypress(function(event) {
		if(event.which == 13) {
			if($(this).val().trim()!=""){
				$('button.buscar_usuario').click();
			}
		 }
	});
});
function valida_usuario(){
	var valido=false;
	var texto_retorno="É preciso preencher o campo ";
	var nome = $('.conteudo_interno .usuario').find('input[name="nome"]');
	var email = $('div.usuario').find('input[name="email"]');
	var senha = $('div.usuario').find('input[name="senha"]');
	var usuario = $('div.usuario').find('input[name="usuario"]');
	var cep = $('div.usuario').find('input[name="cep"]');
	var logradouro = $('div.usuario').find('input[name="logradouro"]');
	var numero_endereco = $('div.usuario').find('input[name="numero_endereco"]');
	var bairro = $('div.usuario').find('input[name="bairro"]');
	var complemento_endereco = $('div.usuario').find('input[name="complemento_endereco"]');
	var cidade = $('div.usuario').find('input[name="cidade"]');
	var uf = $('div.usuario').find('select[name="uf"]');

	var id_usuario=$('.conteudo_interno .usuario').find('input[name="id_usuario"]').val().trim();

	if(nome.val().trim()==""){
		texto_retorno+="<strong>NOME DO USUÁRIO</strong>";
		exibir_alerta_campo("#modal_valida_usuario", nome, texto_retorno);
		valido=false;
	}else if(email.val().trim()==""){
		texto_retorno+="<strong>EMAIL</strong>";
		exibir_alerta_campo("#modal_valida_usuario", email, texto_retorno);
		valido=false;
	}else if(!validaEmail(email.val().trim())){
		texto_retorno="O campo <strong>EMAIL</strong> está em formato inválido";
		exibir_alerta_campo("#modal_valida_usuario", email, texto_retorno);
		valido=false;
	}else if(usuario.val().trim()==""){
		texto_retorno+="<strong>USUÁRIO / LOGIN</strong>";
		exibir_alerta_campo("#modal_valida_usuario", usuario, texto_retorno);
		valido=false;
	}else if(id_usuario==""&&senha.val().trim()==""){
		texto_retorno+="<strong>SENHA</strong>";
		exibir_alerta_campo("#modal_valida_usuario", senha, texto_retorno);
		valido=false;
	}else if(cep.val().trim()==""){
		texto_retorno+="<strong>CEP</strong>";
		exibir_alerta_campo("#modal_valida_usuario", cep, texto_retorno);
		valido=false;
	}else if(logradouro.val().trim()==""){
		texto_retorno+="<strong>ENDEREÇO</strong>";
		exibir_alerta_campo("#modal_valida_usuario", logradouro, texto_retorno);
		valido=false;
	}else if(numero_endereco.val().trim()==""){
		texto_retorno+="<strong>NÚMERO</strong>";
		exibir_alerta_campo("#modal_valida_usuario", numero_endereco, texto_retorno);
		valido=false;
	}else if(bairro.val().trim()==""){
		texto_retorno+="<strong>BAIRRO</strong>";
		exibir_alerta_campo("#modal_valida_usuario", bairro, texto_retorno);
		valido=false;
	}else if(cidade.val().trim()==""){
		texto_retorno+="<strong>CIDADE</strong>";
		exibir_alerta_campo("#modal_valida_usuario", cidade, texto_retorno);
		valido=false;
	}else if(uf.val().trim()==""){
		texto_retorno+="<strong>ESTADO</strong>";
		exibir_alerta_campo("#modal_valida_usuario", uf, texto_retorno);
		valido=false;
	}else{
		var confirmar = confirm('Deseja mesmo inserir/atualizar o Usuário?');
		
		if(confirmar) {
			$.ajax({
				type:"POST",
				data:{
					id_usuario:id_usuario,
					nome:nome.val().trim(),
					email:email.val().trim(),
					usuario:usuario.val().trim(),
					senha:senha.val().trim(),
					cep:cep.val().trim(),
					logradouro:logradouro.val().trim(),
					numero_endereco:numero_endereco.val().trim(),
					complemento_endereco:complemento_endereco.val().trim(),
					bairro:bairro.val().trim(),
					cidade:cidade.val().trim(),
					uf:uf.val().trim()
				},
				url:'?controller=usuario&method=salvar',
				cache:'false',
				dataType:'json',
				beforeSend: function(){
					texto_retorno='<strong>Salvando Dados do Usuário. Aguarde...</strong><br /><img src="assets/img/loader.gif" alt="Carregando" style="width:15%;" />';
					exibir_alerta_campo("#modal_valida_usuario", uf, texto_retorno);
				},
				complete:function(msg){
					$('#modal_valida_usuario').find('.modal-body').children('p').html('');
					$('#modal_valida_usuario').modal('hide');

					if(msg.responseText=="salvou"){
						valido=true;
					}else{
						valido=false;
					}

					if(valido){
						alert('Dados de Usuário salvos com sucesso!!!');
						window.location.href="?controller=usuario&method=index";
					} else {
						alert('Erro ao salvos os Dados de Usuário!!!');
					}
				}
			});
		}
	}

	return valido;
}