<?php
	include 'assets/php/config.php';
	if($conectado){ include 'assets/php/logout.php'; }
?>
<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo $base; ?>" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta name="author" content="Gabriel Henrique" />
	<title>Install - KPanel Content Manager</title>
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="assets/css/all.css" />
	<style> .theme, input[type="submit"], .pin .button{ background-color: #293A4A; } </style>
</head>
<body class="theme">
	<div class="panel login">
		<div class="center">
			<div class="logo"></div>
			<form id="config" autocomplete="off">
				<div class="arrow"></div>
				<div class="text"><i class="fa fa-user" aria-hidden="true"></i><input type="text" name="dbUsername" placeholder="Usuário do Banco de Dados" /></div>
				<div class="text"><i class="fa fa-lock" aria-hidden="true"></i><input type="text" name="dbPassword" placeholder="Senha do Banco de Dados" /></div>
				<div class="text"><i class="fa fa-database" aria-hidden="true"></i><input type="text" name="dbName" placeholder="Nome do Banco de Dados" /></div>
				<input type="submit" value="Salvar" />
			</form>
		</div>
	</div>
	<script type="text/javascript" src="assets/js/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" src="assets/js/default.js"></script>
	<script>
		$('#config').submit(function() {
			$('#config input[type="submit"]').attr('disabled', 'disabled');
			var formData = new FormData($(this)[0]);
			$.ajax({
				type: "POST",
				url: "ajax/Install",
				data: formData,
				contentType: false,
				processData: false,
				beforeSend: function(){
					Alerta.Ver("Aguarde!");
					$('#config').animate({'opacity':'0.5'}, 500);
				},
				success: function(data){
					$('#config').animate({'opacity':'1'}, 500, function(){
						if(data == 1){
							Alerta.Ver("Preencha todos campos!", false, false);
							$('#config input[type="submit"]').removeAttr('disabled');
						}else if(data == 2){
							Alerta.Ver("Chave de instalação/ativação incorreta!", false, false);
							$('#config input[type="submit"]').removeAttr('disabled');
						}else if(data == 3){
							Alerta.Ver("Dados do banco de dados incorreto!");
							$('#config input[type="submit"]').removeAttr('disabled');
						}else if(data == 4){
							Alerta.Ver("Sucesso!", true, false);
						}else{
							Alerta.Erro();
							$('#config input[type="submit"]').removeAttr('disabled');
						}
					});
				}
			});
			return false;
		});
	</script>
</body>
</html>