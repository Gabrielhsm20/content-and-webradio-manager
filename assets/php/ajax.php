<?php
include 'config.php';
include 'functions.php';
if(isset($_GET['f'])){
	$f = $_GET['f'];

	if($f == 'Install'){
		$dbUsername = $_POST['dbUsername']; $dbPassword = $_POST['dbPassword']; $dbName = $_POST['dbName'];
		if($dbUsername == '' || $dbName == ''){
			echo 1;
		}else{
			try{
				$pdo = new PDO("mysql:host=localhost;dbname=".$dbName.";charset=UTF8;","".$dbUsername."","".$dbPassword."");
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				$conectado = true;
			}catch(PDOException $e){
				$conectado = false;
			}

			if(!$conectado){
				echo 3;
			}else{
				$cx_data = '<?php $hosting = \'localhost\'; $dbUsername = \''.$dbUsername.'\'; $dbPassword = \''.$dbPassword.'\'; $dbName = \''.$dbName.'\'; ?>';
				$cx_open = fopen("conexao.php", "w");
				fwrite($cx_open, $cx_data);
				fclose($cx_open);

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://'.$_SERVER['HTTP_HOST'].$base.'database.sql');
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
				curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
				$hc = curl_exec($ch);
				$pdo->query($hc);
				curl_close($ch);

				echo 4;
			}
		}
	}else if($f == 'login'){
		$username = $_POST['username'];
		$password = substr(md5($_POST['password']), 4);
		$pin = $_POST['pin'];
		$check = $_POST['check'];

		$ip_config = $pdo->query("SELECT * FROM aa_ip_ban WHERE ip='$ip'");
		if($ip_config->rowCount() > 0){
			echo 1;
		}else{
			$user_config = $pdo->prepare("SELECT * FROM aa_usuarios WHERE usuario=:username AND senha=:password AND pin=:pin AND status='true'");
			$user_config->bindParam(':username', $username);
			$user_config->bindParam(':password', $password);
			$user_config->bindParam(':pin', $pin);
			$user_config->execute();
			if($user_config->rowCount() == 0){
				echo 2;
			}else{
				$user_view = $user_config->fetch(PDO::FETCH_ASSOC);
				if($user_view['banido'] == 'true'){
					echo 3;
				}else{
					$success = $pdo->query("UPDATE aa_usuarios SET ultimo_time='$time', ultimo_ip='$ip', online='true', online_time='$time' WHERE usuario='$username'");

					$_SESSION['userLoginKP'] = $userLoginId;
					$_SESSION['usuarioKP'] = $user_view['usuario'];
					$_SESSION['senhaKP'] = $user_view['senha'];

					if($check == 'true'){
						setcookie('userLoginKP', $userLoginId, time() + (86400 * 30), "/");
						setcookie('usuarioKP', $user_view['usuario'], time() + (86400 * 30), "/");
						setcookie('senhaKP', $user_view['senha'], time() + (86400 * 30), "/");
					}
					echo 4;
				}
			}
		}
	}else if($f == 'aviso'){
		$aviso_id = (int) $_POST['id'];
		$verifica_visto = $pdo->query("SELECT * FROM aa_avisos_visto WHERE aviso_id='{$aviso_id}' AND usuario='{$user_view['usuario']}'")->rowCount();
		if($verifica_visto == 0){
			$sql = $pdo->query("INSERT INTO aa_avisos_visto(aviso_id, usuario, time) VALUES('{$aviso_id}', '{$user_view['usuario']}', '{$time}')");
			echo 1;
		}
	}
}