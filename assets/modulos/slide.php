<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'slide'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$descricao = htmlspecialchars($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			$url = htmlspecialchars($_POST['url']);
			$guia = htmlspecialchars($_POST['nova_guia']);
			if($titulo == '' || $descricao == '' || $imagem['tmp_name'] == '' || $url == '' || $guia == ''){
				echo 2;
			}else{
				if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
					echo 4;
				}else{
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
       				$imagem_name = 'slide-'.md5(uniqid(time())) . "." . $ext[1];
			        $caminho_imagem = "../uploads/".$imagem_name;
			        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);

			        $sql = $pdo->prepare("INSERT INTO slide(titulo, descricao, imagem, url, nova_guia) VALUES(:titulo, :descricao, :imagem, :url, :nova_guia)");
			        $sql->bindParam(':titulo', $titulo);
			        $sql->bindParam(':descricao', $descricao);
			        $sql->bindParam(':imagem', $imagem_name);
			        $sql->bindParam(':url', $url);
			        $sql->bindParam(':nova_guia', $guia);
			        $sql->execute();
			        if($sql){
			        	echo 1;
			        }
				}
			}
		}else if($_GET['formAjax'] == 'slideEditar'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$descricao = htmlspecialchars($_POST['descricao']);
			$imagem = $_FILES['imagem'];
			$url = htmlspecialchars($_POST['url']);
			$guia = htmlspecialchars($_POST['nova_guia']);
			$id = (int) $_POST['id'];
			$slide_v = $pdo->prepare("SELECT * FROM slide WHERE id=:id");
			$slide_v->bindParam(':id', $id);
			$slide_v->execute();
			$slide_view = $slide_v->fetch(PDO::FETCH_ASSOC);
			if($id != ''){
				if($titulo == '' || $descricao == '' || $url == '' || $guia == ''){
					echo 2;
				}else{
					if($imagem['tmp_name'] != ''){
						if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
							echo 4;
						}else{
							$diretorio = '../uploads/';
							if(file_exists($diretorio.$slide_view['imagem'])){
								unlink($diretorio.$slide_view['imagem']);
							}
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
		       				$imagem_name = 'slide-'.md5(uniqid(time())) . "." . $ext[1];
					        $caminho_imagem = $diretorio.$imagem_name;
					        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
						}
					}else{
						$imagem_name = $slide_view['imagem'];
					}
					$sql = $pdo->prepare("UPDATE slide SET titulo=:titulo, descricao=:descricao, imagem=:imagem, url=:url, nova_guia=:guia WHERE id=:id");
					$sql->bindParam(':titulo', $titulo);
					$sql->bindParam(':descricao', $descricao);
					$sql->bindParam(':imagem', $imagem_name);
					$sql->bindParam(':url', $url);
					$sql->bindParam(':guia', $guia);
					$sql->bindParam(':id', $id);
					$sql->execute();
					if($sql){
			        	echo 1;
			        }
				}
			}
		}else if($_GET['formAjax'] == 'apagar'){
			$id = (int) $_POST['id'];
			$slide_v = $pdo->prepare("SELECT * FROM slide WHERE id=:id");
			$slide_v->bindParam(':id', $id);
			$slide_v->execute();
			$slide_view = $slide_v->fetch(PDO::FETCH_ASSOC);

			$caminho_slide = '../uploads/'.$slide_view['imagem'];
			if(file_exists($caminho_slide)){
				unlink($caminho_slide);
			}
			$sql = $pdo->prepare("DELETE FROM slide WHERE id=:id");
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
		$sql = $pdo->prepare("SELECT * FROM slide WHERE id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="form" value="slideEditar" />
		<input type="hidden" name="back" value="true" />
		<input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Título:</p>
		<input type="text" name="titulo" value="<?php echo $dados['titulo']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Descrição:</p>
		<input type="text" name="descricao" value="<?php echo $dados['descricao']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Atual Imagem:</p>
		<img src="assets/uploads/<?php echo $dados['imagem']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione a imagem: (Deixe em branco caso não queira mudar)</p>
		<input type="file" accept="image/*" name="imagem" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Url:</p>
		<input type="text" name="url" value="<?php echo $dados['url']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Nova guia?</p>
		<select name="nova_guia">
			<option value="true" <?php if($dados['nova_guia'] == 'true'){ echo 'selected'; } ?>>Sim</option>
			<option value="false" <?php if($dados['nova_guia'] == 'false'){ echo 'selected'; } ?>>Não</option>
		</select>

		<input type="submit" value="Salvar" />
	</form>
<?php
	}else{
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="slide" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Título:</p>
	<input type="text" name="titulo" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Descrição:</p>
	<input type="text" name="descricao" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione a imagem:</p>
	<input type="file" accept="image/*" name="imagem" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Url:</p>
	<input type="text" name="url" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Nova guia?</p>
	<select name="nova_guia">
		<option value="true">Sim</option>
		<option value="false">Não</option>
	</select>

	<input type="submit" value="Adicionar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
    <th>Título</th>
    <th>Descrição</th>
    <th>Imagem</th>
    <th>Url</th>
    <th>Nova guia</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM slide ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="7">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/editar/<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
    <td><?php echo $row['titulo']; ?></td>
    <td><?php echo $row['descricao']; ?></td>
    <td><img src="assets/uploads/<?php echo $row['imagem']; ?>" /></td>
    <td><a href="<?php echo $row['url'] ?>" target="_blank">Url</a></td>
    <td><?php if($row['nova_guia'] == 'true'){ echo 'Sim'; }else{ echo 'Não'; } ?></td>
  </tr>
<?php
		}
	}
?>
</table></div>
<?php
	}
?>