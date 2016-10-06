<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'configuracoes_radio'){
    	$dados = $pdo->query("SELECT * FROM aa_dados_radio")->fetch(PDO::FETCH_ASSOC);

    	$ip_radio = htmlspecialchars($_POST['ip']);
		$porta = htmlspecialchars($_POST['porta']);
		$senha_radio = htmlspecialchars($_POST['senha_radio']);
		$senha_kick = htmlspecialchars($_POST['senha_kick']);
		if($ip_radio == '' || $porta == ''){
			echo 2;
		}else{

			if($senha_kick == ''){ $senha_kick = $dados['senha_kick']; }
			if($senha_radio == ''){ $senha_radio = $dados['senha_radio']; }

			$sql = $pdo->prepare("UPDATE aa_dados_radio SET ip=:ip, porta=:porta, senha_radio=:senha_radio, senha_kick=:senha_kick");
			$sql->bindParam(':ip', $ip_radio);
			$sql->bindParam(':porta', $porta);
			$sql->bindParam(':senha_radio', $senha_radio);
			$sql->bindParam(':senha_kick', $senha_kick);
			$sql->execute();
			if($sql){
				echo 1;
			}
		}
	}
  // FIM AJAX //
exit(); }else{ exit(); }}
?>
<?php
	$dados = $pdo->query("SELECT * FROM aa_dados_radio")->fetch(PDO::FETCH_ASSOC);
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="configuracoes_radio" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;IP:</p>
	<input type="text" name="ip" value="<?php echo $dados['ip']; ?>" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Porta:</p>
	<input type="text" name="porta" value="<?php echo $dados['porta']; ?>" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Senha da rádio: (Deixe em branco caso não queira mudar)</p>
	<input type="text" name="senha_radio" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Senha da kick: (Deixe em branco caso não queira mudar)</p>
	<input type="text" name="senha_kick" />

	<input type="submit" value="Salvar" />
</form>