<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'noticia'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$descricao = htmlspecialchars($_POST['descricao']);
			$texto = $_POST['texto'];
			$categoria = (int) $_POST['categoria'];
			$imagem = $_FILES['imagem'];
			$url = Site::Url($_POST['titulo']);
			if($titulo == '' || $descricao == '' || $categoria == '' || $texto == '' || $imagem['tmp_name'] == ''){
				echo 2;
			}else{
				if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
					echo 4;
				}else{
					$diretorio = '../uploads/';
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
       				$imagem_name = 'noticia-'.md5(uniqid(time())) . "." . $ext[1];
			        $caminho_imagem = $diretorio.$imagem_name;
			        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
					$sql = $pdo->prepare("INSERT INTO noticias(titulo, descricao, autor, categoria, imagem, url, texto, evento, fixo, status, revisado, revisador, time, evento_time) VALUES(:titulo, :descricao, :autor, :categoria, :imagem, :url, :texto, 'false', 'false', 'false', 'false', '', :time, '')");
					$sql->bindParam(':titulo', $titulo);
					$sql->bindParam(':descricao', $descricao);
					$sql->bindParam(':categoria', $categoria);
					$sql->bindParam(':imagem', $imagem_name);
					$sql->bindParam(':url', $url);
					$sql->bindParam(':texto', $texto);
					$sql->bindParam(':autor',$user_view['usuario']);
					$sql->bindParam(':time', $time);
					$sql->execute();
					if($sql){
			        	echo 1;
			        }
			    }
			}
		}else if($_GET['formAjax'] == 'noticiaEditar'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$descricao = htmlspecialchars($_POST['descricao']);
			$texto = $_POST['texto'];
			$categoria = (int) $_POST['categoria'];
			$imagem = $_FILES['imagem'];
			$url = Site::Url($_POST['titulo']);
			$id = (int) $_POST['id'];
			$noticia_v = $pdo->prepare("SELECT * FROM noticias WHERE id=:id AND autor='{$user_view['usuario']}'");
			$noticia_v->bindParam(':id', $id);
			$noticia_v->execute();
			$noticia_view = $noticia_v->fetch(PDO::FETCH_ASSOC);
			if($id != '' && $noticia_v->rowCount() > 0){
				if($titulo == '' || $descricao == '' || $categoria == '' || $texto == ''){
					echo 2;
				}else if($noticia_view['revisado'] == 'true'){
					echo 8;
				}else{
					if($imagem['tmp_name'] != ''){
						if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
							echo 4;
						}else{
							$diretorio = '../uploads/';
							if(file_exists($diretorio.$noticia_view['imagem'])){
								unlink($diretorio.$noticia_view['imagem']);
							}
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
		       				$imagem_name = 'noticia-'.md5(uniqid(time())) . "." . $ext[1];
					        $caminho_imagem = $diretorio.$imagem_name;
					        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
						}
					}else{
						$imagem_name = $noticia_view['imagem'];
					}
					$sql = $pdo->prepare("UPDATE noticias SET titulo=:titulo, descricao=:descricao, imagem=:imagem, url=:url, texto=:texto, categoria=:categoria WHERE id=:id");
					$sql->bindParam(':titulo', $titulo);
					$sql->bindParam(':descricao', $descricao);
					$sql->bindParam(':texto', $texto);
					$sql->bindParam(':categoria', $categoria);
					$sql->bindParam(':imagem', $imagem_name);
					$sql->bindParam(':url', $url);
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
		$id = (int) $_GET['id'];
		$sql = $pdo->prepare("SELECT * FROM noticias WHERE id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="form" value="noticiaEditar" />
		<input type="hidden" name="back" value="true" />
		<input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Título:</p>
		<input type="text" name="titulo" value="<?php echo $dados['titulo']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Descrição:</p>
		<input type="text" name="descricao" value="<?php echo $dados['descricao']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Categoria:</p>
		<select name="categoria">
		<?php
			$sql_c = $pdo->query("SELECT * FROM noticias_cat ORDER BY id");
			while($row = $sql_c->fetch(PDO::FETCH_ASSOC)){
		?>
			<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $dados['categoria']){ echo 'selected'; } ?>><?php echo $row['categoria']; ?></option>
		<?php
			}
		?>
		</select>
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Atual Imagem:</p>
		<img src="assets/uploads/<?php echo $dados['imagem']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione a imagem:</p>
		<input type="file" accept="image/*" name="imagem" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Texto:</p>
		<textarea id="tiny" name="texto"><?php echo $dados['texto']; ?></textarea>

		<input type="submit" style="margin-top: 10px" value="Salvar" />
	</form>
<?php
	}else{
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="noticia" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Título:</p>
	<input type="text" name="titulo" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Descrição:</p>
	<input type="text" name="descricao" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Categoria:</p>
		<select name="categoria">
		<?php
			$sql_c = $pdo->query("SELECT * FROM noticias_cat ORDER BY id");
			while($row = $sql_c->fetch(PDO::FETCH_ASSOC)){
		?>
			<option value="<?php echo $row['id']; ?>"><?php echo $row['categoria']; ?></option>
		<?php
			}
		?>
		</select>
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione a imagem:</p>
	<input type="file" accept="image/*" name="imagem" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Texto:</p>
	<textarea id="tiny" name="texto"></textarea>

	<input type="submit" style="margin-top: 10px" value="Postar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
    <th>Título</th>
    <th>Descrição</th>
    <th>Categoria</th>
    <th>Data</th>
    <th>Revisado</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM noticias WHERE evento='false' AND autor='{$user_view['usuario']}' ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="6">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
			$categoria = $pdo->query("SELECT * FROM noticias_cat WHERE id='{$row['categoria']}'")->fetch(PDO::FETCH_ASSOC);
			$categoria = $categoria['categoria'];
?>
  <tr id="<?php echo $row['id']; ?>" <?php if($row['revisado'] == 'true'){ echo 'style="opacity: 0.5;"'; } ?>>
    <td style="cursor: pointer"><a <?php if($row['revisado'] == 'false'){ echo 'href="pagina/'.$url.'/editar/'.$row['id'].'"'; } ?>><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
    <td><?php echo $row['titulo']; ?></td>
    <td><?php echo $row['descricao']; ?></td>
    <td><?php echo $categoria; ?></td>
    <td><?php echo date('d/m/Y H:i', $row['time']); ?></td>
    <td><?php if($row['revisado'] == 'true'){ echo 'Sim'; }else{ echo 'Não'; } ?></td>
  </tr>
<?php
		}
	}
?>
</table></div>
<?php
	}
?>