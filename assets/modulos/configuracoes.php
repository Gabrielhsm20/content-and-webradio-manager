<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'configuracoes'){
			$senha = htmlspecialchars($_POST['senha']);
			$rsenha = htmlspecialchars($_POST['rsenha']);
			$pin = htmlspecialchars($_POST['pin']);
			$avatar = $_FILES['avatar'];
			$turno = htmlspecialchars($_POST['turno']);
			$programa = htmlspecialchars($_POST['programa']);
			$skype = htmlspecialchars($_POST['skype']);
			$twitter = htmlspecialchars($_POST['twitter']);
			$facebook = htmlspecialchars($_POST['facebook']);

			if($senha != ''){
				if($senha != $rsenha){ 
					echo 3; return false;
				}else{
					$senha = substr(md5($_POST['senha']), 4);
				}
			}else{
				$senha = $user_view['senha'];
			}

			if($pin == ''){
				$pin = $user_view['pin'];
			}

			if($avatar['tmp_name'] != ''){
				if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $avatar["type"])){
					echo 4; return false;
				}else{
					$diretorio = '../uploads/';
					if(file_exists($diretorio.$user_view['avatar']) && $user_view['avatar'] != 'default.png'){
						unlink($diretorio.$user_view['avatar']);
					}
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $avatar["name"], $ext);
					$avatar_name = 'kprofile-'.Site::Url($user_view['usuario']).'-'.md5(uniqid(time())) . "." . $ext[1];
			        $caminho_avatar = $diretorio.$avatar_name;
			        move_uploaded_file($avatar["tmp_name"], $caminho_avatar);
				}
			}else{
				$avatar_name = $user_view['avatar'];
			}

			$sql = $pdo->prepare("UPDATE aa_usuarios SET senha=:senha, pin=:pin, avatar=:avatar, turno=:turno, programa=:programa, skype=:skype, twitter=:twitter, facebook=:facebook WHERE usuario=:usuario");
			$sql->bindParam(':senha', $senha);
			$sql->bindParam(':pin', $pin);
			$sql->bindParam(':avatar', $avatar_name);
			$sql->bindParam(':turno', $turno);
			$sql->bindParam(':programa', $programa);
			$sql->bindParam(':skype', $skype);
			$sql->bindParam(':twitter', $twitter);
			$sql->bindParam(':facebook', $facebook);
			$sql->bindParam(':usuario', $user_view['usuario']);
			$sql->execute();
			if($sql){
				echo 1;
				$_SESSION['usuario'] = $user_view['usuario'];
				$_SESSION['senha'] = $senha;
				setcookie('usuario', 'Error', time()-1, "/");
				setcookie('senha', 'Error', time()-1, "/");
			}
		}
	// FIM AJAX //
exit(); }else{ exit(); }}
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="configuracoes" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Senha: (Deixe em branco caso não queira mudar)</p>
	<input type="password" name="senha" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Repita sua senha: (Deixe em branco caso não queira mudar)</p>
	<input type="password" name="rsenha" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;PIN: (Deixe em branco caso não queira mudar)</p>
	<input type="number" name="pin" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Avatar: (Deixe em branco caso não queira mudar)</p>
	<input type="file" accept="image/*" name="avatar" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Turno:</p>
	<select name="turno">
		<option value="manha" <?php if($user_view['turno'] == 'manha'){ echo 'selected'; } ?>>Manhã</option>
		<option value="tarde" <?php if($user_view['turno'] == 'tarde'){ echo 'selected'; } ?>>Tarde</option>
		<option value="noite" <?php if($user_view['turno'] == 'noite'){ echo 'selected'; } ?>>Noite</option>
	</select>
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Programa:</p>
	<input type="text" name="programa" value="<?php echo $user_view['programa']; ?>" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário skype:</p>
	<input type="text" name="skype" value="<?php echo $user_view['skype']; ?>" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário twitter:</p>
	<input type="text" name="twitter" value="<?php echo $user_view['twitter']; ?>" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário facebook:</p>
	<input type="text" name="facebook" value="<?php echo $user_view['facebook']; ?>" />

	<input type="submit" value="Salvar" />
</form>