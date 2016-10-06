<?php
	include 'assets/php/config.php';
	if(!$conectado){ header("Location:".$base."erro"); exit(); }
	else if($logado){ header("Location:".$base."inicio"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo $base; ?>" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta name="author" content="Gabriel Henrique" />
	<title>Login - KPanel Content Manager</title>
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="assets/css/all.css" />
	<style> .theme, input[type="submit"], .pin .button{ background-color: #<?php echo $tema_ver['tema']; ?>; } </style>
</head>
<body class="theme">
	<div class="panel login">
		<div class="center">
			<div class="logo"></div>
			<form id="login" autocomplete="off">
				<div class="arrow"></div>
				<div class="text"><i class="fa fa-user" aria-hidden="true"></i><input type="text" name="username" placeholder="Usuário" /></div>
				<div class="text"><i class="fa fa-lock" aria-hidden="true"></i><input type="password" name="password" placeholder="Senha" /></div>
				<div class="text"><i class="fa fa-th" aria-hidden="true"></i><input type="pin" name="pin" placeholder="Pin" readonly /></div>
				<div class="pin">
					<div class="button" onclick="Pin.Insert('1')">1</div>
					<div class="button" onclick="Pin.Insert('2')">2</div>
					<div class="button" onclick="Pin.Insert('3')">3</div>
					<div class="button" onclick="Pin.Insert('4')">4</div>
					<div class="button" onclick="Pin.Insert('5')">5</div>
					<div class="button" onclick="Pin.Insert('6')">6</div>
					<div class="button" onclick="Pin.Insert('7')">7</div>
					<div class="button" onclick="Pin.Insert('8')">8</div>
					<div class="button" onclick="Pin.Insert('9')">9</div>
					<div class="button" onclick="Pin.Insert('0')">0</div>
					<div class="button" onclick="Pin.Each()"><i class="fa fa-eraser" aria-hidden="true"></i></div>
				</div>
				<input type="submit" value="Entrar" />
				<div class="manter"><span>Mantenha-me conectado</span>&nbsp;&nbsp;<input type="checkbox" name="check" value="1" /></div>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="assets/js/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" src="assets/js/default.js"></script>
	<script>
		Pin = {
			Insert: function(number){
				$('#login input[name="pin"]').val($('#login input[name="pin"]').val()+number);
			},

			Each: function(){
				$('#login input[name="pin"]').val('');
			}
		}
		$('#login').submit(function() {
			var username = $('#login input[name="username"]').val(), password = $('#login input[name="password"]').val(), pin = $('#login input[name="pin"]').val(), check = $('#login input[name="check"]:checked').val();
			if(check == '1'){ var check = 'true'; }else{ var check = 'false'; }
			if(username == '' || password == '' || pin == ''){
				Alerta.Ver("Preencha todos campos!", false, false);
			}else{
				$.ajax({
					url: 'ajax/login',
					type: 'POST',
					data: {'username':username, 'password':password, 'pin':pin, 'check':check},
					beforeSend: function(){
						$('#login').animate({'opacity':'0.5'}, 500);
					},
					success: function(retorno){
						$('#login').animate({'opacity':'1'}, 500, function(){
							if(retorno == 1){
								Alerta.Ver("Você está banido por IP.", false, false);
							}else if(retorno == 2){
								Alerta.Ver("Usuário inexistente!", false, false);
							}else if(retorno == 3){
								Alerta.Ver("Usuário banido.", false, false);
							}else if(retorno == 4){
								Alerta.Ver("Logado com sucesso!", true, false);
							}else{
								Alerta.Erro();
							}
						});
					}
				});
			}
			return false;
		});
	</script>
	<?php if(!$conectado){ header("Location:".$base."erro"); exit(); } ?>
</body>
</html>