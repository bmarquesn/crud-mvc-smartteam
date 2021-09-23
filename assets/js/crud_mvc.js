$(function(){
	$('a').on('click', function(event){
		if($(this).attr('href')==""){
			event.preventDefault();
		}
	});

	$('#topo_menu_interno').find('a').on('click', function(){
		if($(this).text()==="LOGOUT"){
			var confirmar=confirm('Deseja mesmo fechar o sistema?');
			if(confirmar){
				window.location.href="?controller=login&method=logout";
			}
		}
	});

	/** cep */
	$('input#cep').mask('00000-000');

	/** busca cep */
	function limpaFormulárioCEP() {
		// Limpa valores do formulário de cep.
		$("#logradouro").val("");
		$("#bairro").val("");
		$("#cidade").val("");
		$("#uf").val("");
	}

	$("#cep").blur(function() {
		//Nova variável "cep" somente com dígitos.
		var cep=$(this).val().replace(/\D/g, '');
		//Verifica se campo cep possui valor informado.
		if(cep!=""){
			//Expressão regular para validar o CEP.
			var validacep = /^[0-9]{8}$/;
			//Valida o formato do CEP.
			if(validacep.test(cep)){
				//Preenche os campos com "..." enquanto consulta webservice.
				$("#logradouro").val("...");
				$("#bairro").val("...");
				$("#cidade").val("...");
				$("#uf").val("...");
				//Consulta o webservice viacep.com.br/
				$.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
					if(!("erro" in dados)){
						//Atualiza os campos com os valores da consulta.
						$("#logradouro").val(dados.logradouro);
						$("#bairro").val(dados.bairro);
						$("#cidade").val(dados.localidade);
						$("#uf").val(dados.uf);
					}else{
						limpaFormulárioCEP();
						exibirAlertaCampo("#modal_valida_usuario", $("#cep"), "CEP NÃO ENCONTRADO");
					}
				});
			}else{
				limpaFormulárioCEP();
				exibirAlertaCampo("#modal_valida_usuario", $("#cep"), "FORMATO DE CEP INVÁLIDO");
			}
		}else{
			limpaFormulárioCEP();
			exibirAlertaCampo("#modal_valida_usuario", $("#cep"), "O campo CEP não foi preenchido");
		}
	});

	/** reset formulario */
	$('input[type="reset"]').on('click', function(){
		$('input[type="text"]').val('');
		$('select option').val('');
		$('input[type="radio"]').prop('checked', false);
		$('input[type="checkbox"]').prop('checked', false);
		$('textarea').val('');
	});
});

function exibirAlertaCampo(nome_modal, campo, mensagem){
	$(nome_modal).find('.modal-body').find('p').html(mensagem);
	$(nome_modal).modal('show');

	$(nome_modal).on('hidden.bs.modal', function(){
		if(campo!=""){
			campo.focus();
		}
	});
}

//Function that checks if valid email
function validEmail(field){
	var value_field = field.val().trim();
	var retorno;

	if ((/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value_field)) || (!value_field)) {
        retorno=true;
    } else {
        retorno=false;
	}

	return retorno;
}