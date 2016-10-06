<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'top_music'){
    	$titulo = htmlspecialchars($_POST['titulo']);
		$banda = htmlspecialchars($_POST['banda']);
		$url = htmlspecialchars($_POST['url']);
		$imagem = $_FILES['imagem'];
		$id = (int) $_POST['id'];
		$top_v = $pdo->prepare("SELECT * FROM top_music WHERE id=:id");
		$top_v->bindParam(':id', $id);
		$top_v->execute();
		$top_view = $top_v->fetch(PDO::FETCH_ASSOC);
		if($id != ''){
			if($titulo == '' || $banda == '' || $url == ''){
				echo 2;
			}else{
				if($imagem['tmp_name'] != ''){
					if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
						echo 4;
					}else{
						$diretorio = '../uploads/';
						if(file_exists($diretorio.$top_view['imagem'])){
							unlink($diretorio.$top_view['imagem']);
						}
						preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
	       				$imagem_name = 'topmusic-'.md5(uniqid(time())) . "." . $ext[1];
				        $caminho_imagem = $diretorio.$imagem_name;
				        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
					}
				}else{
					$imagem_name = $top_view['imagem'];
				}
				$sql = $pdo->prepare("UPDATE top_music SET titulo=:titulo, banda=:banda, imagem=:imagem, url=:url WHERE id=:id");
				$sql->bindParam(':titulo', $titulo);
				$sql->bindParam(':banda', $banda);
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
		$sql = $pdo->prepare("SELECT * FROM top_music WHERE id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="top_music" />
	<input type="hidden" name="back" value="true" />
	<input type="hidden" name="id" value="<?php echo $dados['id']; ?>">

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Titulo:</p>
	<input type="text" value="<?php echo $dados['titulo']; ?>" name="titulo" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Banda:</p>
	<input type="text" value="<?php echo $dados['banda']; ?>" name="banda" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Atual Imagem:</p>
	<img src="assets/uploads/<?php echo $dados['imagem']; ?>" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione uma capa: (Deixe em branco caso não queira mudar)</p>
	<input type="file" accept="image/*" name="imagem" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Url:</p>
	<input type="text" value="<?php echo $dados['url']; ?>" name="url" />

	<input type="submit" style="margin-top: 10px" value="Enviar" />
</form>
<?php
	}else{
?>
	<div class="table"><table>
	  <tr>
	    <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
	    <th>Música</th>
	    <th>Banda</th>
	    <th>Capa</th>
	    <th>Url</th>
	  </tr>
	<?php
		$sql = $pdo->query("SELECT * FROM top_music ORDER BY id DESC");
		if($sql->rowCount() == 0){
?>
	<tr><td colspan="5">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
	?>
	  <tr>
	    <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/editar/<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
	    <td><?php echo $row['titulo'] ?></td>
	    <td><?php echo $row['banda'] ?></td>
	    <td><img src="assets/uploads/<?php echo $row['imagem']; ?>"></td>
	    <td><a href="<?php echo $row['url'] ?>" target="_blank">Url</a></td>
	  </tr>
	<?php
		}
	}
	?>
	</table></div>
<?php } ?>