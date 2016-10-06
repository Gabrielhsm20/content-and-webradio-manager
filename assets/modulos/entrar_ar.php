<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
	if($_GET['formAjax'] == 'kickar'){
		$dados = $pdo->query("SELECT * FROM aa_dados_radio")->fetch(PDO::FETCH_ASSOC);
	    $scfp = @fsockopen($dados['ip'], $dados['porta'], $errno, $errstr, 10);
		if($scfp){
			@fputs($scfp,"GET /admin.cgi?pass=".$dados['senha_kick']."&mode=kicksrc HTTP/1.0\r\nUser-Agent: SHOUTcast Song Status (Mozilla Compatible)\r\n\r\n");
			while(!feof($scfp)) {
				$page .= fgets($scfp, 1000);
			}
			fclose($scfp);
		}
		$pdo->query("INSERT INTO aa_logs_kick(usuario, ip, time) VALUES('{$user_view['usuario']}', '{$ip}','{$time}')");
		echo 11;
	}
  // FIM AJAX //
exit(); }else{ exit(); }}
?>
<?php
	$dados = $pdo->query("SELECT * FROM aa_dados_radio")->fetch(PDO::FETCH_ASSOC);
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="kickar" />
	<input type="hidden" name="back" value="false" />
	<input type="submit" style="margin-bottom: 10px" value="Kickar DJ">
</form>
<form>
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Quality:</p>
	<input type="text" value="High Quality" readonly />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Format:</p>
	<input type="text" value="AccPlus: 64 kb/s, 44,1 kHz, Stereo" readonly />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Ip:</p>
	<input type="text" value="<?php echo $dados['ip'] ?>" readonly />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Porta:</p>
	<input type="text" value="<?php echo $dados['porta'] ?>" readonly />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Senha da rádio:</p>
	<input type="text" value="<?php echo $dados['senha_radio'] ?>" readonly />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Station name:</p>
	<input type="text" value="<?php echo $user_view['usuario'] ?>" readonly />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Genre:</p>
	<input type="text" value="<?php echo $user_view['programa'] ?>" readonly />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Website URL:</p>
	<input type="text" value="http://www.<?php echo $_SERVER['HTTP_HOST']; ?>/" readonly />
</form>