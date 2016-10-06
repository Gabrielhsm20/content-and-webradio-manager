<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
	if($_GET['formAjax'] == 'notificacao'){
	    $usuario = htmlspecialchars($_POST['usuario']);
	    $mensagem = htmlspecialchars($_POST['mensagem']);

	    $usuario_existe = $pdo->prepare("SELECT * FROM aa_usuarios WHERE usuario=:usuario");
	    $usuario_existe->bindParam(':usuario', $usuario);
	    $usuario_existe->execute();

	    if($usuario == '' || $mensagem == ''){
	    	echo 2;
	    }else if($usuario_existe->rowCount() == 0){
	    	echo 7;
	    }else{
	    	$sql = $pdo->prepare("INSERT INTO aa_notificacao(usuario, texto, time, visto) VALUES(:usuario, :mensagem, '{$time}', 'false')");
	    	$sql->bindParam(':usuario',$usuario);
            $sql->bindParam(':mensagem',$mensagem);
    		$sql->execute();
	    	if($sql){
	    		echo 1;
	    	}
	    }
	}
  // FIM AJAX //
exit(); }else{ exit(); }}
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="notificacao" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário:</p>
	<input type="text" name="usuario" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Mensagem:</p>
	<input type="text" name="mensagem" />
	<input type="submit" value="Enviar" />
</form>