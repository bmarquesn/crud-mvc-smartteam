function validaLogin(){
	var valido=false;

	var email = $('#login').find('form').find('input[name="email"]');
	var senha = $('#login').find('form').find('input[name="senha"]');
	var codigo = $('#login').find('form').find('input[name="codigo"]');
	var codigo_gerado=$('div#login').find('div#codigo_gerado').text().trim();

	if(email.val().trim()=="") {
		exibirAlertaLogin('É necessário digitar o E-MAIL');
		email.focus();
		valido=false;
	} else if(senha.val().trim()=="") {
		exibirAlertaLogin('É necessário digitar a SENHA');
		senha.focus();
		valido=false;
	} else if(!validEmail(email)) {
		exibirAlertaLogin('É necessário digitar um E-MAIL VÁLIDO');
		senha.focus();
		valido=false;
	} else if(codigo.val().trim()=="") {
		exibirAlertaLogin('É necessário digitar o CÓDIGO DE VERIFICAÇÃO');
		codigo.focus();
		valido=false;
	} else if(codigo.val().trim()!=codigo_gerado) {
		exibirAlertaLogin('O CÓDIGO DE VERIFICAÇÃO digitado está incorreto<br />Note que letras MAIÚSCULAS e minúsculas são diferenciadas');
		codigo.focus();
		valido=false;
	} else {
		$('#login').find('#mensagem').hide('fast');
		$('#login').find('#mensagem').find('.alert-danger').text('');
		valido=true;
	}

	return valido;
}

function exibirAlertaLogin(mensagem){
	$('#login').find('#mensagem').hide('fast');
	$('#login').find('#mensagem').find('.alert-danger').html(mensagem);
	$('#login').find('#mensagem').show('fast');
}

//Function that checks if valid email
function validEmail(field){
	var value_field = $(field).val().trim();
	var retorno;

	if ((/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value_field)) || (!value_field)) {
        retorno=true;
    } else {
        retorno=false;
	}

	return retorno;
}