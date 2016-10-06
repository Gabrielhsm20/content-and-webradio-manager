<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'valores_cat'){
    	$nome = htmlspecialchars($_POST['nome']);
    	$imagem = $_FILES['imagem'];
		if($nome == '' || $imagem['tmp_name'] == ''){
			echo 2;
		}else{
			if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
				echo 4;
			}else{
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
   				$imagem_name = 'cat-valor-'.md5(uniqid(time())) . "." . $ext[1];
		        $caminho_imagem = "../uploads/".$imagem_name;
		        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
				$sql = $pdo->prepare("INSERT INTO valores_cat(categoria, icone) VALUES(:nome, :icone)");
				$sql->bindParam(':nome', $nome);
				$sql->bindParam(':icone', $imagem_name);
				$sql->execute();
				if($sql){
					echo 1;
				}
			}
		}
    }else if($_GET['formAjax'] == 'apagar'){
    	$id = (int) $_POST['id'];
		$icone_v = $pdo->prepare("SELECT * FROM valores_cat WHERE id=:id");
		$icone_v->bindParam(':id', $id);
		$icone_v->execute();
		$icone_view = $icone_v->fetch(PDO::FETCH_ASSOC);

		$caminho_icone = '../uploads/'.$icone_view['icone'];
		if(file_exists($caminho_icone)){
			unlink($caminho_icone);
		}
		$sql = $pdo->prepare("DELETE FROM valores_cat WHERE id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		if($sql){
			echo 1;
		}
    }
  // FIM AJAX //
exit(); }else{ exit(); }}
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="valores_cat" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Nome:</p>
	<input type="text" name="nome" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione a imagem:</p>
	<input type="file" accept="image/*" name="imagem" />

	<input type="submit" value="Adicionar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th>Nome</th>
    <th>Ícone</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM valores_cat ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="3">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td><?php echo $row['categoria']; ?></td>
    <td><img src="assets/uploads/<?php echo $row['icone']; ?>" /></td>
  </tr>
<?php
		}
	}
?>
</table></div>