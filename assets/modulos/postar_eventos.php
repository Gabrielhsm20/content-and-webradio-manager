<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'evento'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$descricao = htmlspecialchars($_POST['descricao']);
			$texto = $_POST['texto'];
			$data = htmlspecialchars(strtotime($_POST['data']));
			$imagem = $_FILES['imagem'];
			$url = Site::Url($_POST['titulo']);
			if($titulo == '' || $descricao == '' || $data == '' || $texto == '' || $imagem['tmp_name'] == ''){
				echo 2;
			}else{
				if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
					echo 4;
				}else{
					$diretorio = '../uploads/';
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
       				$imagem_name = 'evento-'.md5(uniqid(time())) . "." . $ext[1];
			        $caminho_imagem = $diretorio.$imagem_name;
			        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
					$sql = $pdo->prepare("INSERT INTO noticias(titulo, descricao, autor, categoria, imagem, url, texto, evento, fixo, status, revisado, revisador, time, evento_time) VALUES(:titulo, :descricao, :autor, '0', :imagem, :url, :texto, 'true', 'false', 'false', 'false', '', :time, :data)");
					$sql->bindParam(':titulo', $titulo);
					$sql->bindParam(':descricao', $descricao);
					$sql->bindParam(':data', $data);
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
		}else if($_GET['formAjax'] == 'eventoEditar'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$descricao = htmlspecialchars($_POST['descricao']);
			$texto = $_POST['texto'];
			$data = htmlspecialchars(strtotime($_POST['data']));
			$imagem = $_FILES['imagem'];
			$url = Site::Url($_POST['titulo']);
			$id = (int) $_POST['id'];
			$evento_v = $pdo->prepare("SELECT * FROM noticias WHERE id=:id AND autor='{$user_view['usuario']}'");
			$evento_v->bindParam(':id', $id);
			$evento_v->execute();
			$evento_view = $evento_v->fetch(PDO::FETCH_ASSOC);
			if($id != '' && $evento_v->rowCount() > 0){
				if($titulo == '' || $descricao == '' || $data == '' || $texto == ''){
					echo 2;
				}else if($evento_view['revisado'] == 'true'){
					echo 8;
				}else{
					if($imagem['tmp_name'] != ''){
						if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
							echo 4;
						}else{
							$diretorio = '../uploads/';
							if(file_exists($diretorio.$evento_view['imagem'])){
								unlink($diretorio.$evento_view['imagem']);
							}
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
		       				$imagem_name = 'evento-'.md5(uniqid(time())) . "." . $ext[1];
					        $caminho_imagem = $diretorio.$imagem_name;
					        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
						}
					}else{
						$imagem_name = $evento_view['imagem'];
					}
					$sql = $pdo->prepare("UPDATE noticias SET titulo=:titulo, descricao=:descricao, imagem=:imagem, url=:url, texto=:texto, evento_time=:data WHERE id=:id");
					$sql->bindParam(':titulo', $titulo);
					$sql->bindParam(':descricao', $descricao);
					$sql->bindParam(':texto', $texto);
					$sql->bindParam(':data', $data);
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
		<input type="hidden" name="form" value="eventoEditar" />
		<input type="hidden" name="back" value="true" />
		<input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Título:</p>
		<input type="text" name="titulo" value="<?php echo $dados['titulo']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Descrição:</p>
		<input type="text" name="descricao" value="<?php echo $dados['descricao']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Data:</p>
		<input id="datepicker" type="text" name="data" value="<?php echo @date('d.m.Y H:i', $dados['evento_time']); ?>" />
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
	<input type="hidden" name="form" value="evento" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Título:</p>
	<input type="text" name="titulo" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Descrição:</p>
	<input type="text" name="descricao" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Data:</p>
	<input id="datepicker" type="text" name="data" />
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
    <th>Dia do Evento</th>
    <th>Data</th>
    <th>Revisado</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM noticias WHERE evento='true' AND autor='{$user_view['usuario']}' ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="6">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>" <?php if($row['revisado'] == 'true'){ echo 'style="opacity: 0.5;"'; } ?>>
    <td style="cursor: pointer"><a <?php if($row['revisado'] == 'false'){ echo 'href="pagina/'.$url.'/editar/'.$row['id'].'"'; } ?>><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
    <td><?php echo $row['titulo']; ?></td>
    <td><?php echo $row['descricao']; ?></td>
    <td><?php echo date('d/m/Y H:i', $row['evento_time']); ?></td>
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