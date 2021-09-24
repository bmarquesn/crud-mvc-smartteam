$(function(){
	var input_cpfcnpj = $('input#cpf_cnpj');

	if(input_cpfcnpj.length > 0) {
		carregarDatePicker();
		$("#data_nascimento").datepicker();

		input_cpfcnpj.keydown(function(){
			try {
				input_cpfcnpj.unmask();
			} catch (e) {}

			var tamanho = input_cpfcnpj.val().length;

			if(tamanho < 11){
				input_cpfcnpj.mask("999.999.999-99");
			} else {
				input_cpfcnpj.mask("99.999.999/9999-99");
			}

			// ajustando foco
			var elem = this;
			setTimeout(function(){
				// mudo a posição do seletor
				elem.selectionStart = elem.selectionEnd = 10000;
			}, 0);
			// reaplico o valor para mudar o foco
			var currentValue = $(this).val();
			$(this).val('');
			$(this).val(currentValue);
		});
	}

	$('button.inserir_usuario').click(function(){
		window.location.href="?controller=usuario&method=inserir";
	});

	$('.conteudo_interno .usuario').find('input[type="button"][value="SALVAR"]').click(function(){
		if(validaUsuario()){
			alert('Usuario salvo com sucesso!!!');
			window.location.href="?controller=usuario&method=index";
		}
    });

    /** botao excluir */
	$('button.usuario_excluir').on('click', function(){
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
					exibirAlertaCampo("#modal_valida_usuario", '', texto_retorno);
				},
				complete:function(msg){
					if(msg.responseText=="excluiu"){
						alert('Usuário excluido com sucesso!!!');
						setTimeout(function(){window.location.href="?controller=usuario&method=index";}, 1000);
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

function validaUsuario(){
	var valido=false;
	var texto_retorno="É preciso preencher o campo ";
	var nome = $('.conteudo_interno .usuario').find('input[name="nome"]');
	var email = $('div.usuario').find('input[name="email"]');
	var cpf_cnpj = $('div.usuario').find('input[name="cpf_cnpj"]');
	var senha = $('div.usuario').find('input[name="senha"]');
	var data_nascimento = $('div.usuario').find('input[name="data_nascimento"]');
	var cep = $('div.usuario').find('input[name="cep"]');
	var logradouro = $('div.usuario').find('input[name="logradouro"]');
	var numero_endereco = $('div.usuario').find('input[name="numero_endereco"]');
	var bairro = $('div.usuario').find('input[name="bairro"]');
	var complemento_endereco = $('div.usuario').find('input[name="complemento_endereco"]');
	var cidade = $('div.usuario').find('input[name="cidade"]');
	var uf = $('div.usuario').find('select[name="uf"]');

	var usuario_id=$('.conteudo_interno .usuario').find('input[name="usuario_id"]').val().trim();

	if(cpf_cnpj.val().trim()==""){
		texto_retorno+="<strong>CPF / CNPJ</strong>";
		exibirAlertaCampo("#modal_valida_usuario", cpf_cnpj, texto_retorno);
		valido=false;
	}else if(nome.val().trim()==""){
		texto_retorno+="<strong>NOME DO USUÁRIO</strong>";
		exibirAlertaCampo("#modal_valida_usuario", nome, texto_retorno);
		valido=false;
	}else if(email.val().trim()==""){
		texto_retorno+="<strong>EMAIL</strong>";
		exibirAlertaCampo("#modal_valida_usuario", email, texto_retorno);
		valido=false;
	}else if(!validEmail(email)){
		texto_retorno="O campo <strong>EMAIL</strong> está em formato inválido";
		exibirAlertaCampo("#modal_valida_usuario", email, texto_retorno);
		valido=false;
	}else if(data_nascimento.val().trim()==""){
		texto_retorno+="<strong>DATA DE NASCIMENTO</strong>";
		exibirAlertaCampo("#modal_valida_usuario", data_nascimento, texto_retorno);
		valido=false;
	}else if(usuario_id==""&&senha.val().trim()==""){
		texto_retorno+="<strong>SENHA</strong>";
		exibirAlertaCampo("#modal_valida_usuario", senha, texto_retorno);
		valido=false;
	}else if(cep.val().trim()==""){
		texto_retorno+="<strong>CEP</strong>";
		exibirAlertaCampo("#modal_valida_usuario", cep, texto_retorno);
		valido=false;
	}else if(logradouro.val().trim()==""){
		texto_retorno+="<strong>ENDEREÇO</strong>";
		exibirAlertaCampo("#modal_valida_usuario", logradouro, texto_retorno);
		valido=false;
	}else if(numero_endereco.val().trim()==""){
		texto_retorno+="<strong>NÚMERO</strong>";
		exibirAlertaCampo("#modal_valida_usuario", numero_endereco, texto_retorno);
		valido=false;
	}else if(bairro.val().trim()==""){
		texto_retorno+="<strong>BAIRRO</strong>";
		exibirAlertaCampo("#modal_valida_usuario", bairro, texto_retorno);
		valido=false;
	}else if(cidade.val().trim()==""){
		texto_retorno+="<strong>CIDADE</strong>";
		exibirAlertaCampo("#modal_valida_usuario", cidade, texto_retorno);
		valido=false;
	}else if(uf.val().trim()==""){
		texto_retorno+="<strong>ESTADO</strong>";
		exibirAlertaCampo("#modal_valida_usuario", uf, texto_retorno);
		valido=false;
	}else{
		var confirmar = confirm('Deseja mesmo inserir/atualizar o Usuário?');

		if(confirmar) {
			$.ajax({
				type:"POST",
				data:{
					usuario_id:usuario_id,
					cpf_cnpj:cpf_cnpj.val().trim(),
					nome:nome.val().trim(),
					email:email.val().trim(),
					data_nascimento:data_nascimento.val().trim(),
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
					texto_retorno="<strong>Salvando Dados do Usuário. Aguarde...</strong><br /><img src=\"assets/img/loader.gif\" alt=\"Carregando\" style=\"width:15%;\" />";
					exibirAlertaCampo("#modal_valida_usuario", "", texto_retorno);
				},
				complete:function(msg){
					if(msg.responseText=="salvou"){
						valido=true;
					}else{
						valido=false;
					}

					if(valido){
						setTimeout(function(){window.location.href="?controller=usuario&method=index";}, 1000);
					} else {
						if(msg.responseText.indexOf("Error: Duplicate entry") != -1) {
							var campo = msg.responseText.split('for key')[1];
							if(campo.indexOf("cpf_cnpj") != -1) {
								texto_retorno = "Já existe um usuário com o <strong>CPF / CNPJ</strong> digitado";
								exibirAlertaCampo("#modal_valida_usuario", cpf_cnpj, texto_retorno);
							} else if(campo.indexOf("email") != -1) {
								texto_retorno = "Já existe um usuário com o <strong>E-MAIL</strong> digitado";
								exibirAlertaCampo("#modal_valida_usuario", email, texto_retorno);
							} else {
								texto_retorno = "Já existe um usuário com o(s) dado(s) digitado(s)";
								exibirAlertaCampo("#modal_valida_usuario", nome, texto_retorno);
							}
						} else {
							alert('Erro ao salvar os Dados de Usuário!!!');
						}
					}
				}
			});
		}
	}

	return valido;
}