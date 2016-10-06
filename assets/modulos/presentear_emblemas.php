<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'emblemas'){
			$usuario = $_POST['username'];
			$codigo = htmlspecialchars($_POST['code']);
			$existe = $pdo->prepare("SELECT * FROM emblemas WHERE codigo=:codigo");
			$existe->bindParam(':codigo', $codigo);
			$existe->execute();
			if($usuario == '' || $codigo == ''){
				echo 2;
			}else if($existe->rowCount() == 0){
				echo 10;
			}else{
				$usuario = explode('>', $usuario);
	            foreach($usuario as $user){
	                $user = trim($user);
	                $userExiste = $pdo->prepare("SELECT * FROM usuarios WHERE usuario=:user"); $userExiste->bindParam(':user', $user);
	                $userExiste->execute();
	                $userPossui = $pdo->prepare("SELECT * FROM usuarios_emblemas WHERE usuario=:user AND codigo=:codigo"); $userPossui->bindParam(':user', $user); $userPossui->bindParam(':codigo', $codigo);
	                $userPossui->execute();
	                if($userExiste->rowCount() > 0 && $userPossui->rowCount() == 0){
		                $sql = $pdo->prepare("INSERT INTO usuarios_emblemas(usuario, codigo) VALUES(:usuario, :codigo)");
		                $sql->bindParam(':usuario', $user);
		                $sql->bindParam(':codigo', $codigo);
		                $sql->execute();
	                }
	            }
	           echo 1;
			}
		}
	// FIM AJAX //
exit(); }else{ exit(); }}
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="emblemas" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuários: (Fulano > Ciclano > Beltrano)</p>
	<input type="text" name="username" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Código do Emblema:</p>
	<input type="text" name="code" />

	<input type="submit" value="Presentear" />
</form>