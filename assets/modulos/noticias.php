<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'noticiaEditar'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$descricao = htmlspecialchars($_POST['descricao']);
			$texto = $_POST['texto'];
			$categoria = (int) $_POST['categoria'];
			$imagem = $_FILES['imagem'];
			$fixo = htmlspecialchars($_POST['fixo']);
			$status = htmlspecialchars($_POST['status']);
			$id = (int) $_POST['id'];
			$noticia_v = $pdo->prepare("SELECT * FROM noticias WHERE id=:id");
			$noticia_v->bindParam(':id', $id);
			$noticia_v->execute();
			$noticia_view = $noticia_v->fetch(PDO::FETCH_ASSOC);
			if($id != ''){
				if($titulo == '' || $descricao == '' || $categoria == '' || $texto == '' || $fixo == '' || $status == ''){
					echo 2;
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
					$sql = $pdo->prepare("UPDATE noticias SET titulo=:titulo, descricao=:descricao, categoria=:categoria, imagem=:imagem, texto=:texto, fixo=:fixo, status=:status, revisado='true', revisador=:revisador WHERE id=:id");
					$sql->bindParam(':titulo', $titulo);
					$sql->bindParam(':descricao', $descricao);
					$sql->bindParam(':categoria', $categoria);
					$sql->bindParam(':imagem', $imagem_name);
					$sql->bindParam(':texto', $texto);
					$sql->bindParam(':fixo', $fixo);
					$sql->bindParam(':status', $status);
					$sql->bindParam(':revisador', $user_view['usuario']);
					$sql->bindParam(':id', $id);
					$sql->execute();
					if($sql){
			        	echo 1;
			        }
				}
			}
		}else if($_GET['formAjax'] == 'apagar'){
			$id = (int) $_POST['id'];
			$noticia_v = $pdo->prepare("SELECT * FROM noticias WHERE id=:id");
			$noticia_v->bindParam(':id', $id);
			$noticia_v->execute();
			$noticia_view = $noticia_v->fetch(PDO::FETCH_ASSOC);

			$caminho_noticia = '../uploads/'.$noticia_view['imagem'];
			if(file_exists($caminho_noticia)){
				unlink($caminho_noticia);
			}
			$sql = $pdo->prepare("DELETE FROM noticias WHERE id=:id");
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
		$sql = $pdo->prepare("SELECT * FROM noticias WHERE id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="form" value="noticiaEditar" />
		<input type="hidden" name="back" value="true" />
		<input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Revisador:</p>
		<input type="text" value="<?php echo $user_view['usuario']; ?>" readonly />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Autor:</p>
		<input type="text" value="<?php echo $dados['autor']; ?>" readonly />
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
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione a imagem: (Deixe em branco caso não queira mudar)</p>
		<input type="file" accept="image/*" name="imagem" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Fixo</p>
		<select name="fixo">
			<option value="true" <?php if($dados['fixo'] == 'true'){ echo 'selected'; } ?>>Sim</option>
			<option value="false" <?php if($dados['fixo'] == 'false'){ echo 'selected'; } ?>>Não</option>
		</select>
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Status</p>
		<select name="status">
			<option value="true" <?php if($dados['status'] == 'true'){ echo 'selected'; } ?>>Ativo</option>
			<option value="false" <?php if($dados['status'] == 'false'){ echo 'selected'; } ?>>Inativo</option>
		</select>
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Texto:</p>
		<textarea id="tiny" name="texto"><?php echo $dados['texto']; ?></textarea>

		<input type="submit" style="margin-top: 10px" value="Salvar" />
	</form>
<?php
	}else{
?>
<div class="table"><table>
<tr>
	<th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
	<th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
	<th>Título</th>
	<th>Autor</th>
	<th>Revisador</th>
	<th>Status</th>
	<th>Fixo</th>
</tr>
<?php
	$sql = $pdo->query("SELECT * FROM noticias WHERE revisado='false' AND evento='false' ORDER BY id DESC");
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/editar/<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
    <td><?php echo $row['titulo']; ?></td>
    <td><?php echo $row['autor']; ?></td>
    <td><?php echo $row['revisador']; ?></td>
    <td><?php if($row['status'] == 'true'){ echo 'Ativo'; }else{ echo 'Inativo'; } ?></td>
    <td><?php if($row['fixo'] == 'true'){ echo 'Sim'; }else{ echo 'Não'; } ?></td>
  </tr>
<?php
	}

	$quantidade = 50;
    $registros = $pdo->query("SELECT * FROM noticias WHERE evento='false' AND revisado='true'")->rowCount();
    $pagina     = (isset ($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
    $inicio     = ($quantidade * $pagina) - $quantidade;
    $totalPagina = ceil($registros/$quantidade);
	$sql = $pdo->query("SELECT * FROM noticias WHERE revisado='true' AND evento='false' ORDER BY id DESC LIMIT $inicio, $quantidade");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="7">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>" style="opacity: 0.5;">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/editar/<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
    <td><?php echo $row['titulo']; ?></td>
    <td><?php echo $row['autor']; ?></td>
    <td><?php echo $row['revisador']; ?></td>
    <td><?php if($row['status'] == 'true'){ echo 'Ativo'; }else{ echo 'Inativo'; } ?></td>
    <td><?php if($row['fixo'] == 'true'){ echo 'Sim'; }else{ echo 'Não'; } ?></td>
  </tr>
<?php
		}
	}
?>
</table></div>
<div class="paginacao">
<?php
    for($i = 1; $i <= $totalPagina; $i++){
        if($i == $pagina){
            echo '<div class="pag theme" style="background: #EEE; color: #666">'.$i.'</div>';
        }else{
            echo '<a href="pagina/'.$url.'/lista/'.$i.'"><div class="theme pag">'.$i.'</div></a>';
        }
    }
?>
</div>
<?php
	}
?>