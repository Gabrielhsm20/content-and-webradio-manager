<?php
	if(!isset($_SESSION)){ session_start(); }
	date_default_timezone_set("America/Sao_Paulo");
	$hosting = ''; $dbUsername = ''; $dbPassword = ''; $dbName = '';
	include 'conexao.php';
	try{
		$pdo = new PDO("mysql:host=".$hosting.";dbname=".$dbName.";charset=UTF8;","".$dbUsername."","".$dbPassword."");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$conectado = true;
	}catch(PDOException $e){
		$conectado = false;
	}

	$time = time();
	$time_month = time() - 30 * 24 * 60 * 60;
	$ip = $_SERVER['REMOTE_ADDR'];
	$userLoginId = substr(md5($ip), 4);
	$http_host = str_replace('www.', '', $_SERVER['HTTP_HOST']);

	$base = $_SERVER['REQUEST_URI'];
	$base = explode('/admin/', $base);
	$base = $base[0].'/admin/';

	if($conectado){
		$tema_ver = $pdo->query("SELECT * FROM aa_ktema")->fetch(PDO::FETCH_ASSOC);
		if(isset($_SESSION['userLoginKP']) || isset($_COOKIE['userLoginKP'])){
			if(isset($_SESSION['usuarioKP'])){
				$userLogin = $_SESSION['userLoginKP'];
			}else{
				$userLogin = $_COOKIE['userLoginKP'];
			}
			if($userLogin == $userLoginId){
				if(isset($_SESSION['usuarioKP'])){
					$username = $_SESSION['usuarioKP'];
					$password = $_SESSION['senhaKP'];
				}else{
					$username = $_COOKIE['usuarioKP'];
					$password = $_COOKIE['senhaKP'];
				}
				$user_config = $pdo->query("SELECT * FROM aa_usuarios WHERE usuario='$username' AND senha='$password' AND status='true' AND banido='false'");
				$ip_config = $pdo->query("SELECT * FROM aa_ip_ban WHERE ip='$ip'")->rowCount();
				if($user_config->rowCount() == 0 || $ip_config > 0){
					include 'assets/php/logout.php';
					$logado = false;
				}else{
					$user_view = $user_config->fetch(PDO::FETCH_ASSOC);
					$user_cargo_sql = $pdo->query("SELECT * FROM aa_usuarios_rel r, aa_cargos c WHERE r.cargo_id=c.cargo_id AND r.user_id='{$user_view['id']}' ORDER BY c.ordem ASC");
					$user_cargo = $user_cargo_sql->fetch(PDO::FETCH_ASSOC);
					if($user_view['banido'] == 'true'){
						include 'assets/php/logout.php';
						$logado = false;
					}else{
						$logado = true;
					}
				}
			}else{
				include 'assets/php/logout.php';
				$logado = false;
			}
		}else{
			$logado = false;
		}
		$time_weak = time() - (((date('N', time()) - 1) * 24*60*60) + (date('H', time())*60*60) + (date('i', time()) * 60) + date('s', time()));
		$time_reset = $time_weak + 7*24*60*60;

		$resetar_check = $pdo->query("SELECT * FROM aa_horarios WHERE id='0' AND hora<'{$time}'")->rowCount();
		if($resetar_check == 1){
			$reset_time = $pdo->query("UPDATE aa_horarios SET hora='{$time_reset}' WHERE id='0'");
			$reset = $pdo->query("UPDATE aa_horarios SET user_id='0' WHERE fixo='false' AND id!='0'");
		}
	}
?>