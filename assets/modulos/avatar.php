<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'avatar'){
			$user = $_POST['username'];
			if($user == ''){
				echo 2;
			}else{
				$usuario_view_sql = $pdo->prepare("SELECT * FROM usuarios WHERE usuario=:usuario");
				$usuario_view_sql->bindParam(':usuario', $user);
				$usuario_view_sql->execute();
				if($usuario_view_sql->rowCount() == 0){
					echo 7;
				}else{
					$sql = $pdo->prepare("UPDATE usuarios SET avatar='default.png' WHERE usuario=:usuario");
					$sql->bindParam(':usuario', $user);
					$sql->execute();
					if($sql){
						echo 1;
					}
				}
			}
		}
	// FIM AJAX //
exit(); }else{ exit(); }}
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="avatar" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário:</p>
	<input type="text" name="username" />

	<input type="submit" value="Remover" />
</form>