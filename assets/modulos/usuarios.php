<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'usuario'){
			$user = htmlspecialchars($_POST['userView']);
			if($user == ''){
				echo 2;
			}else{
				$usuario_view_sql = $pdo->prepare("SELECT * FROM usuarios WHERE usuario=:usuario");
				$usuario_view_sql->bindParam(':usuario', $user);
				$usuario_view_sql->execute();
				if($usuario_view_sql->rowCount() == 0){
					echo 7;
				}else{
					echo 9;
				}
			}
		}else if($_GET['formAjax'] == 'usuarioEditar'){
			$banido = htmlspecialchars($_POST['banido']);
			$motivo = htmlspecialchars($_POST['motivo']);
			$id = (int) $_POST['id'];
			if($id!=''){
				if($banido == 'true' && $motivo == ''){
					echo 2;
				}else{
					$sql = $pdo->prepare("UPDATE usuarios SET banido=:banido, motivo_ban=:motivo WHERE id=:id");
					$sql->bindParam(':banido', $banido);
					$sql->bindParam(':motivo', $motivo);
					$sql->bindParam(':id', $id);
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
<?php
	if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){
		$user = $_GET['id'];
		$sql = $pdo->prepare("SELECT * FROM usuarios WHERE usuario=:user");
		$sql->bindParam(':user', $user);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="usuarioEditar" />
	<input type="hidden" name="back" value="true" />
	<input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário:</p>
	<input type="text" value="<?php echo $dados['usuario']; ?>" readonly />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Registro:</p>
	<input type="text" value="<?php echo date('d/m/Y H:i',$dados['registro_time']); ?>" readonly />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Último Login:</p>
	<input type="text" value="<?php echo date('d/m/Y H:i',$dados['ultimo_time']); ?>" readonly />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Último IP:</p>
	<input type="text" value="<?php echo $dados['ultimo_ip']; ?>" readonly />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Banido:</p>
	<select name="banido">
		<option value="true" <?php if($dados['banido'] == 'true'){ echo 'selected'; } ?>>Sim</option>
		<option value="false" <?php if($dados['banido'] == 'false'){ echo 'selected'; } ?>>Não</option>
	</select>
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Motivo do Ban:</p>
	<input type="text" name="motivo" value="<?php echo $dados['motivo_ban']; ?>" />

	<input type="submit" value="Salvar" />
</form>
<?php
	}else{
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="usuario" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário:</p>
	<input type="text" name="userView" />

	<input type="submit" value="Ver" />
</form>
<?php
	}
?>