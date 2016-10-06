<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'emblema'){
			$codigo = htmlspecialchars($_POST['codigo']);
			$descricao = htmlspecialchars($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			if($codigo == '' || $descricao == '' || $imagem['tmp_name'] == ''){
				echo 2;
			}else{
				if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
					echo 4;
				}else{
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
       				$imagem_name = 'emblema-'.md5(uniqid(time())) . "." . $ext[1];
			        $caminho_imagem = "../uploads/".$imagem_name;
			        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);

			        $sql = $pdo->prepare("INSERT INTO emblemas(codigo, descricao, imagem) VALUES(:codigo, :descricao, :imagem)");
			        $sql->bindParam(':codigo', $codigo);
			        $sql->bindParam(':descricao', $descricao);
			        $sql->bindParam(':imagem', $imagem_name);
			        $sql->execute();
			        if($sql){
			        	echo 1;
			        }
				}
			}
		}else if($_GET['formAjax'] == 'emblemaEditar'){
			$descricao = htmlspecialchars($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			$id = (int) $_POST['id'];
			$emblema_v = $pdo->prepare("SELECT * FROM emblemas WHERE id=:id");
			$emblema_v->bindParam(':id', $id);
			$emblema_v->execute();
			$emblema_view = $emblema_v->fetch(PDO::FETCH_ASSOC);
			if($id != ''){
				if($descricao == ''){
					echo 2;
				}else{
					if($imagem['tmp_name'] != ''){
						if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
							echo 4;
						}else{
							$diretorio = '../uploads/';
							if(file_exists($diretorio.$emblema_view['imagem'])){
								unlink($diretorio.$emblema_view['imagem']);
							}
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
		       				$imagem_name = 'slide-'.md5(uniqid(time())) . "." . $ext[1];
					        $caminho_imagem = $diretorio.$imagem_name;
					        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
						}
					}else{
						$imagem_name = $emblema_view['imagem'];
					}
					$sql = $pdo->prepare("UPDATE emblemas SET descricao=:descricao, imagem=:imagem WHERE id=:id");
					$sql->bindParam(':descricao', $descricao);
					$sql->bindParam(':imagem', $imagem_name);
					$sql->bindParam(':id', $id);
					$sql->execute();
					if($sql){
			        	echo 1;
			        }
				}
			}
		}else if($_GET['formAjax'] == 'apagar'){
			$id = (int) $_POST['id'];
			$emblema_v = $pdo->prepare("SELECT * FROM emblemas WHERE id=:id");
			$emblema_v->bindParam(':id', $id);
			$emblema_v->execute();
			$emblema_view = $emblema_v->fetch(PDO::FETCH_ASSOC);

			$caminho_emblema = '../uploads/'.$emblema_view['imagem'];
			if(file_exists($caminho_emblema)){
				unlink($caminho_emblema);
			}
			$sql = $pdo->prepare("DELETE FROM emblemas WHERE id=:id");
			$sql->bindParam(':id', $id);
			$sql->execute();
			if($sql){
				echo 1;
			}
		}
	// FIM AJAX //
exit(); }else{ exit(); }}
?>
<?php
	if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){
		$id = (int) $_GET['id'];
		$sql = $pdo->prepare("SELECT * FROM emblemas WHERE id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="form" value="emblemaEditar" />
		<input type="hidden" name="back" value="true" />
		<input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Código:</p>
		<input type="text" value="<?php echo $dados['codigo']; ?>" readonly />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Descrição:</p>
		<input type="text" name="descricao" value="<?php echo $dados['descricao']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Atual Imagem:</p>
		<img src="assets/uploads/<?php echo $dados['imagem']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione a imagem: (Deixe em branco caso não queira mudar)</p>
		<input type="file" accept="image/*" name="imagem" />

		<input type="submit" value="Salvar" />
	</form>
<?php
	}else{
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="emblema" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Código:</p>
	<input type="text" name="codigo" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Descrição:</p>
	<input type="text" name="descricao" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione a imagem:</p>
	<input type="file" accept="image/*" name="imagem" />

	<input type="submit" value="Adicionar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
    <th>Código</th>
    <th>Descrição</th>
    <th>Imagem</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM emblemas ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="5">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/editar/<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
    <td><?php echo $row['codigo']; ?></td>
    <td><?php echo $row['descricao']; ?></td>
    <td><img src="assets/uploads/<?php echo $row['imagem']; ?>" /></td>
  </tr>
<?php
		}
	}
?>
</table></div>
<?php
	}
?>