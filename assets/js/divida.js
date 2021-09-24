$(function(){
	var input_datavencimento = $('input#data_vencimento');

	carregarDatePicker();
	if(input_datavencimento.length > 0) {
		$("#data_vencimento").datepicker();
		$("#valor").maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
	} else {
		$('#menu_busca').find('input[type="text"]').eq(2).maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
		$('#menu_busca').find('input[type="text"]').eq(3).datepicker();
	}

	$('button.inserir_divida').click(function(){
		window.location.href="?controller=divida&method=inserir";
	});

	$('.conteudo_interno .divida').find('input[type="button"][value="SALVAR"]').click(function(){
		if(validaDivida()){
			alert('Divida salva com sucesso!!!');
			window.location.href="?controller=divida&method=index";
		}
    });

    /** botao excluir */
	$('button.divida_excluir').on('click', function(){
		var confirmar = confirm('Deseja mesmo excluir o Dívida selecionado?');

		if(confirmar){
			var id_divida=$(this).parent('td').parent('tr').children('td:first').children('input').val().trim();
			$.ajax({
				type:"POST",
				data:{id:id_divida},
				url:'?controller=divida&method=excluir',
				cache:'false',
				dataType:'json',
				beforeSend: function(){
					texto_retorno='<strong>Excluindo Dívida. Aguarde...</strong><br /><img src="assets/img/loader.gif" alt="Carregando" style="width:15%;" />';
					exibirAlertaCampo("#modal_valida_divida", '', texto_retorno);
				},
				complete:function(msg){
					if(msg.responseText=="excluiu"){
						setTimeout(function(){window.location.href="?controller=divida&method=index";}, 1000);
					}else{
						alert('Erro ao excluir a Dívida!!!');
					}
				}
			});
		}
	});

	/** botao editar */
	$('button.divida_editar').on('click', function(){
		var id_divida=$(this).parent('td').parent('tr').children('td:first').children('input').val().trim();
		window.location.href="?controller=divida&method=editar&identifier="+id_divida;
    });

    /** buscar/filtrar */
	$('button.buscar_divida').click(function(){
		var titulo=$('#menu_busca').find('input[type="text"]').eq(0).val().trim();
		var usuario=$('#menu_busca').find('input[type="text"]').eq(1).val().trim();
		var valor=$('#menu_busca').find('input[type="text"]').eq(2).val().trim();
		var data_vencimento=$('#menu_busca').find('input[type="text"]').eq(3).val().trim();
		if(usuario!=""||titulo!=""||valor!=""||data_vencimento!=""){
			window.location.href="?controller=divida&method=index&filtro_1="+usuario+"&filtro_2="+titulo+"&filtro_3="+valor+"&filtro_4="+data_vencimento;
		}else{
			window.location.href="?controller=divida&method=index";
		}
	});
});

function validaDivida(){
	var valido=false;
	var texto_retorno="É preciso preencher o campo ";
	var titulo = $('.conteudo_interno .divida').find('input[name="titulo"]');
	var usuario_id = $('div.divida').find('select[name="usuario_id"]');
	var valor = $('div.divida').find('input[name="valor"]');
	var data_vencimento = $('div.divida').find('input[name="data_vencimento"]');

	var divida_id=$('.conteudo_interno .divida').find('input[name="divida_id"]').val().trim();

	if(titulo.val().trim()==""){
		texto_retorno+="<strong>TÍTULO</strong>";
		exibirAlertaCampo("#modal_valida_divida", titulo, texto_retorno);
		valido=false;
	}else if(usuario_id.val().trim()==""){
		texto_retorno+="<strong>SELECIONE O USUÁRIO</strong>";
		exibirAlertaCampo("#modal_valida_divida", usuario_id, texto_retorno);
		valido=false;
	}else if(valor.val().trim()==""){
		texto_retorno+="<strong>VALOR</strong>";
		exibirAlertaCampo("#modal_valida_divida", valor, texto_retorno);
		valido=false;
	}else if(data_vencimento.val().trim()==""){
		texto_retorno+="<strong>DATA DO VENCIMENTO</strong>";
		exibirAlertaCampo("#modal_valida_divida", data_vencimento, texto_retorno);
		valido=false;
	}else{
		var confirmar = confirm('Deseja mesmo inserir/atualizar a Dívida?');

		if(confirmar) {
			$.ajax({
				type:"POST",
				data:{
					divida_id:divida_id,
					titulo:titulo.val().trim(),
					usuario_id:usuario_id.val().trim(),
					valor:valor.val().trim(),
					data_vencimento:data_vencimento.val().trim()
				},
				url:'?controller=divida&method=salvar',
				cache:'false',
				dataType:'json',
				beforeSend: function(){
					texto_retorno="<strong>Salvando Dados da Dívida. Aguarde...</strong><br /><img src=\"assets/img/loader.gif\" alt=\"Carregando\" style=\"width:15%;\" />";
					exibirAlertaCampo("#modal_valida_divida", "", texto_retorno);
				},
				complete:function(msg){
					if(msg.responseText=="salvou"){
						valido=true;
					}else{
						valido=false;
					}

					if(valido){
						setTimeout(function(){window.location.href="?controller=divida&method=index";}, 1000);
					} else {
						alert('Erro ao salvar os Dados da Dívida!!!');
					}
				}
			});
		}
	}

	return valido;
}

function carregarDatePicker() {
	/* Brazilian initialisation for the jQuery UI date picker plugin. */
	/* Written by Leonildo Costa Silva (leocsilva@gmail.com). */
	(function( factory ) {
		if ( typeof define === "function" && define.amd ) {
			// AMD. Register as an anonymous module.
			define([ "../datepicker" ], factory );
		} else {
			// Browser globals
			factory( jQuery.datepicker );
		}
	}(function(datepicker) {
		datepicker.regional['pt-BR'] = {
			closeText: 'Fechar',
			prevText: 'Anterior',
			nextText: 'Próximo',
			currentText: 'Hoje',
			monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
			dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'],
			dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
			dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
			weekHeader: 'Sm',
			dateFormat: 'dd/mm/yy',
			firstDay: 0,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: '',
			selectYear: true,
			changeYear: true,
			yearRange: "1921:2021"
		};
		datepicker.setDefaults(datepicker.regional['pt-BR']);
		return datepicker.regional['pt-BR'];
	}));

	$("#data_nascimento").datepicker();
}