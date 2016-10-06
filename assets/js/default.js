Alerta = {
	Ver: function(conteudo, reload, back){
		var id = Math.round(Math.random()*10000);
		html = '<div class="alerta" id="alerta_'+id+'">'+conteudo+'</div>';
		$('body').append(html);
		$('#alerta_'+id).slideDown();
		setTimeout(function(){
			$('#alerta_'+id).slideUp(function(){
				$('#alerta_'+id).remove();
			});
		}, 4000);

		setTimeout(function() {
			if(reload){
				if(back == 'true'){
					 history.back()
				}else{
					location.reload();
				}
			}
		}, 1000);
	},

	Confirm: function(id, formAjax){
		$('body').append('<div class="alerta" id="alerta_confirm"><button onclick="Registro.Execute(\''+id+'\',\''+formAjax+'\')">CONTINUAR</button>&nbsp;&nbsp;<button onclick="Alerta.ConfirmF()">CANCELAR</button></div>');
		$('#alerta_confirm').slideDown();
	},

	ConfirmF: function(){
		$('#alerta_confirm button').attr('disable', 'disabled');
		$('#alerta_confirm').slideUp(function(){ $('#alerta_confirm').remove(); });
	},

	Erro: function(){
		Alerta.Ver("Erro interno!", false, false);
	}
}

User = {
	VerAviso: function(id, user){
		$.ajax({
            type: 'POST',
            url: 'ajax/aviso',
            data: {'id':id},
            success:function(retorno){
                if(retorno == 1){
					Alerta.Ver("Lido!", false);
					$('#aviso_'+id+' .button').animate({'opacity':'0'}, 500, function(){
						$('#aviso_'+id+' .button:nth-child(1)').hide().removeAttr('onclick');
						$('#aviso_'+id+' .button:nth-child(2)').css('width','100%');
	                	$('#aviso_'+id+' .button').animate({'opacity':'1'}, 500);
					});
					if($('#aviso_'+id+' .leitores .leitor').length == 0){
						$('#aviso_'+id+' .leitores').html('<div class="leitor theme">'+user+'</div>');
					}else{
						$('#aviso_'+id+' .leitores').append('<div class="leitor theme">'+user+'</div>');
					}
				}else{
					Alerta.Erro();
				}
            }
        });
	}
}

Color = {
	Update: function(cor){
		$('.theme, input[type="submit"]').css('background-color','#'+cor);
	},

	Original: function(){
		$('.jscolor').val('293A4A');
		Color.Update('293A4A');
	}
}

$(function() {
	$('.menu .main li > a').click(function(){
		var submenu = $(this).next('ul.submenu');
		$('.submenu').not(submenu).slideUp('slow');
		$(submenu).slideToggle('slow');
	});

	$('.aviso .ver_leitores').click(function(){
		var leitores = $(this).next('.leitores');
		$('.leitores').not(leitores).slideUp('slow');
		$(leitores).slideToggle('slow');
	});
});