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
	function limpa_formulário_cep() {
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
						limpa_formulário_cep();
						exibir_alerta_campo("#modal_valida_usuario", $("#cep"), "CEP NÃO ENCONTRADO");
					}
				});
			}else{
				limpa_formulário_cep();
				exibir_alerta_campo("#modal_valida_usuario", $("#cep"), "FORMATO DE CEP INVÁLIDO");
			}
		}else{
			limpa_formulário_cep();
			exibir_alerta_campo("#modal_valida_usuario", $("#cep"), "O campo CEP não foi preenchido");
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
function exibir_alerta_campo(nome_modal, campo, mensagem){
	$(nome_modal).find('.modal-body').children('p').html(mensagem);
	$(nome_modal).modal('show');
	$(nome_modal).on('hidden.bs.modal', function(){
		if(campo!=""){
			campo.focus();
		}
	});
}
//Function that checks if valid email
function validaEmail(campo){
	var valor_campo=campo;
	var valido=false;
    if((/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valor_campo))||(!valor_campo)){
		valido=true;
	}
	return valido;
}