<?php
	include 'assets/php/config.php';
	include 'assets/php/functions.php';
	if(!$conectado){ header("Location:".$base."erro"); exit(); }
	else if(!$logado){ header("Location:".$base."login"); exit(); }
	if(isset($_GET['logout'])){ include 'assets/php/logout.php'; }
?>
<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo $base; ?>" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta name="author" content="Gabriel Henrique" />
	<title>Olá <?php echo $user_view['usuario']; ?> - KPanel Content Manager</title>
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="assets/css/jquery-ui.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/jquery.datetimepicker.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/animate.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/all.css" />
	<style> .theme, .content .dias button, .content .horarios button, input[type="submit"]{ background-color: #<?php echo $tema_ver['tema']; ?>; } .conteudo p > i{ color: #<?php echo $tema_ver['tema']; ?>; } </style>
	<script type="text/javascript" src="assets/js/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.datetimepicker.full.min.js"></script>
	<script type="text/javascript" src="assets/js/jscolor.min.js"></script>
	<script type="text/javascript" src="assets/js/default.js?fim"></script>
	<script>
		$(function() {
			$.datetimepicker.setLocale('pt-BR'); $('#datepicker').datetimepicker({ format:'d.m.Y H:i' });
		});

		function timeConvert(num){
            var s = num%60; 
	        var m = Math.floor((num/60)%60);
	        var h = Math.floor(num/60/60);
	        if (s<10) s = "0" + s;
        	if (m<10) m = "0" + m;
        	if (h<10) h = "0" + h;
        	if (h==24) h = "00";
        	return  " " + h + ":" + m + ":" + s;   
		}

		t = <?php echo date('s', time()) + date('i', time())*60 + date('H', time())*60*60; ?>;
		setInterval(function() {proximo_segundo()}, 1000); function proximo_segundo(){ 
			$('#relogio').html(timeConvert(t)); t++; 
		}
		proximo_segundo();
	</script>
</head>
<body>
	<div class="panel logado">
		<div class="header theme">
			<div class="center">
				<div class="logo"></div>
				<div class="buttons">
					<div class="button" style="cursor: default" id="relogio"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;&nbsp;00:00:00</div>
					<div class="button" style="cursor: default"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;Olá <?php echo $user_view['usuario']; ?></div>
					<a href="pagina/notificacoes">
					<?php
						$userNot = $pdo->query("SELECT * FROM aa_notificacao WHERE usuario='{$user_view['usuario']}' AND visto='false'")->rowCount();
					?>
						<div class="button"><i class="fa fa-bell" aria-hidden="true" <?php if($userNot > 0){ echo 'style="animation: tada 1.5s infinite linear"'; } ?>></i></div>
					</a>
					<a href="logout"><div class="button"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;&nbsp;Sair</div></a>
				</div>
			</div>
		</div>
		<div class="content">
			<div class="siredbar theme"></div>
			<div class="menu theme">
				<div class="avatar" style="background-image: url('assets/uploads/<?php echo $user_view['avatar']; ?>')"></div>
				<div class="cargos">
				<?php
					$sql = $pdo->query("SELECT * FROM aa_usuarios_rel r, aa_cargos c WHERE r.cargo_id=c.cargo_id AND r.user_id='{$user_view['id']}' ORDER BY c.ordem ASC");
					while($row = $sql->fetch(PDO::FETCH_ASSOC)){
						echo $row['cargo'].'<br>';
					}
				?>
				</div>
				<ul class="main">
					<li><a href="inicio"><p>Página Inicial</p></a></li>
					<?php
					$sql_menu = $pdo->query("SELECT * FROM aa_usuarios_rel r, aa_canais c, aa_permissao p WHERE r.user_id = '".$user_view['id']."' AND r.cargo_id = p.cargo_id AND p.canal_id = c.canal_id AND c.status = 'true' AND c.pai = '0' GROUP BY p.canal_id ORDER BY c.ordem");
					while ($menu = $sql_menu->fetch(PDO::FETCH_ASSOC)) {
					?>
						<li><a><p><?php echo $menu['canal']; ?></p></a>
						<ul class="submenu">
					<?php
					$sql_submenu = $pdo->query("SELECT * FROM aa_usuarios_rel r, aa_canais c, aa_permissao p WHERE r.user_id = '".$user_view['id']."' AND r.cargo_id = p.cargo_id AND p.canal_id = c.canal_id AND c.status = 'true' AND c.pai = '".$menu['canal_id']."' GROUP BY p.canal_id ORDER BY c.ordem, c.canal");
								if($sql_submenu->rowCount() == 0){
									echo '<li><a><p>Sem Acesso!</p></a></li>';	
								}else{
									while ($submenu = $sql_submenu->fetch(PDO::FETCH_ASSOC)) {
					?>
						<li><a href="pagina/<?php echo $submenu['diretorio']; ?>"><p><?php echo $submenu['canal']; ?></p></a></li>
					<?php
						}
					}
					?>
							</ul>
						</li>
					<?php
					}

					?>
				</ul>
			</div>
			<div class="centerbar">
				<?php
					include 'assets/php/conteudo.php';
				?>
			</div>
		</div>
	</div>
	<?php if(!$conectado){ header("Location:".$base."erro"); exit(); } ?>
</body>
</html>