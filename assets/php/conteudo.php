<?php
	if(isset($_GET['diretorio'])){
		$url = $_GET['diretorio'];
		$canal_config = $pdo->query("SELECT * FROM aa_canais WHERE diretorio='$url'");
		$canal_ver = $canal_config->fetch(PDO::FETCH_ASSOC);
	}else{
		$url = 'inicio';
	}
	if(!$conectado){ header("Location:".$base."erro"); exit(); }
?>
<div class="conteudo" <?php if(!isset($url) OR $url == 'inicio'){ echo 'style="background-color: transparent"'; } ?>>
<?php
	if(isset($url) && $url != 'inicio'){
		if(file_exists('assets/modulos/'.$url.'.php')){
			if(Site::Modulo($url) > 0){
				include "assets/modulos/".$url.".php";
				$logs_painel = $pdo->query("INSERT INTO aa_logs_painel(ip, time, usuario, canal) VALUES ('{$ip}','{$time}','{$user_view['usuario']}','{$canal_ver['canal']}')");
			}else{
				include "assets/modulos/erro.php";
			}
		}else{
			include "assets/modulos/erro.php";
		}
	}else{
		include "assets/modulos/inicio.php";
		$logs_painel = $pdo->query("INSERT INTO aa_logs_painel(ip, time, usuario, canal) VALUES ('{$ip}','{$time}','{$user_view['usuario']}','Página Inicial')");
	}
?>
</div>
<script>
	Registro = {
		Apagar: function(id, formAjax){
			if(!formAjax){ var formAjax = 'apagar'; }
			Alerta.Confirm(id,formAjax);
		},

		Execute: function(id, formAjax){
			$('#alerta_confirm button').attr('disabled', 'disabled');
			$('#alerta_confirm').slideUp(function(){
				$('#alerta_confirm').remove();
				$.ajax({
					url: "paginaAjax/<?php echo $url; ?>/"+formAjax,
					type: 'POST',
					data: {'id':id},
					success: function(data){
						if(data == 1){
							if(formAjax == 'apagar'){
								Alerta.Ver("Sucesso!");
								$('table tr#'+id).remove();
							}else if(formAjax == 'fixar'){
								Alerta.Ver("Sucesso!");
								$('table tr#'+id+' .fix').removeAttr('onclick').attr('onclick', 'Registro.Apagar(\''+id+'\',\'desfixar\')').html('<i class="fa fa-star" aria-hidden="true"></i>');
							}else if(formAjax == 'desfixar'){
								Alerta.Ver("Sucesso!");
								$('table tr#'+id+' .fix').removeAttr('onclick').attr('onclick', 'Registro.Apagar(\''+id+'\',\'fixar\')').html('<i class="fa fa-star-o" aria-hidden="true"></i>');
							}else if(formAjax == 'desmarcar'){
								Alerta.Ver("Sucesso!");
								$('table tr#'+id+' .marc').removeAttr('onclick').css({opacity: '0.8', cursor: 'default'});
							}else if(formAjax == 'marcar'){
								Alerta.Ver("Sucesso!");
								$('table tr#'+id+' .marc').removeAttr('onclick').css({opacity: '0.8', cursor: 'default'});
							}else{
								Alerta.Ver("Sucesso!", true, false);
							}
						}else{
							Alerta.Erro();
							$('#alerta_confirm button').removeAttr('disabled');
						}
					}
				});
			});
		}
	}

	$('#formPag').submit(function(){
		$('#formPag input[type="submit"]').attr('disabled', 'disabled');
		var formData = new FormData($(this)[0]);
		var back = $(this).find('input[name="back"]').val();
		var formAjax = $(this).find('input[name="form"]').val();
		var userView = $(this).find('input[name="userView"]').val();
		$.ajax({
			type: "POST",
			url: "paginaAjax/<?php echo $url; ?>/"+formAjax,
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function(){
				$('#formPag').animate({'opacity':'0.5'}, 500);
			},
			success: function(data){
				$('#formPag').animate({'opacity':'1'}, 500, function(){
					if(data == 1){
						Alerta.Ver("Sucesso!", true, back);
					}else if(data == 2){
						Alerta.Ver("Preencha todos campos!");
						$('#formPag input[type="submit"]').removeAttr('disabled');
					}else if(data == 3){
						Alerta.Ver("As senhas devem ser iguais!");
						$('#formPag input[type="submit"]').removeAttr('disabled');
					}else if(data == 4){
						Alerta.Ver("Selecione uma imagem!");
						$('#formPag input[type="submit"]').removeAttr('disabled');
					}else if(data == 5){
						Alerta.Ver("Usuário existente!");
						$('#formPag input[type="submit"]').removeAttr('disabled');
					}else if(data == 6){
						Alerta.Ver("Selecione um áudio!");
						$('#formPag input[type="submit"]').removeAttr('disabled');
					}else if(data == 7){
						Alerta.Ver("Usuário inexistente!");
						$('#formPag input[type="submit"]').removeAttr('disabled');
					}else if(data == 8){
						Alerta.Ver("Já foi moderado!", true, back);
					}else if(data == 9){
						location.href="pagina/<?php echo $url; ?>/editar/"+userView;
					}else if(data == 10){
						Alerta.Ver("Emblema Inexistente!");
						$('#formPag input[type="submit"]').removeAttr('disabled');
					}else if(data == 11){
						Alerta.Ver("Kickado com Sucesso!");
						$('#formPag input[type="submit"]').removeAttr('disabled');
					}else{
						Alerta.Erro();
						$('#formPag input[type="submit"]').removeAttr('disabled');
					}
				});
			}
		});
		return false;
	});

	$('#searchPag').submit(function(){
		var key = $(this).find('input[name="key"]').val();
		$('#searchPag input[type="submit"]').attr('disabled', 'disabled');
		if(key == ''){
			Alerta.Ver("Preencha todos campos!");
			$('#searchPag input[type="submit"]').removeAttr('disabled');
		}else{
			location.href="pagina/<?php echo $url; ?>/buscar/"+key;
		}
		return false;
	});
</script>