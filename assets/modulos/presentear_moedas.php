<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'moedas'){
			$usuario = htmlspecialchars($_POST['username']);
			$moedas = htmlspecialchars($_POST['money']);
			if($usuario == '' || $moedas == '' || $moedas == 0){
				echo 2;
			}else{
				$usuario = explode('>', $usuario);
	            foreach($usuario as $user){
	                $user = trim($user);
	                $existe = $pdo->prepare("SELECT * FROM usuarios WHERE usuario=:user");
	                $existe->bindParam(':user', $user);
	                $existe->execute();
	                if($existe->rowCount() > 0){
	                	$total = $pdo->prepare("SELECT * FROM usuarios WHERE usuario=:user");
		                $total->bindParam(':user', $user);
		                $total->execute();
		                $total = $total->fetch(PDO::FETCH_ASSOC);
		                $atual = $total['moedas'] + $moedas;
		                $sql = $pdo->prepare("UPDATE usuarios SET moedas=:atual WHERE usuario=:user");
		                $sql->bindParam(':atual', $atual);
		                $sql->bindParam(':user', $user);
		                $sql->execute();
	                }
	            }
	            if($sql){
	            	echo 1;
	            }
			}
		}
	// FIM AJAX //
exit(); }else{ exit(); }}
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="moedas" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuários: (Fulano > Ciclano > Beltrano)</p>
	<input type="text" name="username" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Valor:</p>
	<input type="number" name="money" />

	<input type="submit" value="Presentear" />
</form>