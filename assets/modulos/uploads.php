<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'uploads'){
			$imagem = $_FILES['imagem'];
				if($imagem['tmp_name'] == ''){
					echo 2;
				}else{
					if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
						echo 4;
					}else{
						$diretorio = '../uploads/';
						preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
	       				$imagem_name = 'upload-'.md5(uniqid(time())) . "." . $ext[1];
				        $caminho_imagem = $diretorio.$imagem_name;
				        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);

				        $sql = $pdo->prepare("INSERT INTO aa_uploads(url, usuario) VALUES(:url, :usuario)");
				        $sql->bindParam(':url', $imagem_name);
				        $sql->bindParam(':usuario', $user_view['usuario']);
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
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="uploads" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione a imagem:</p>
	<input type="file" accept="image/*" name="imagem" />

	<input type="submit" value="Upar" />
</form>

<div class="table"><table>
  <tr>
    <th>Imagem</th>
    <th>Autor</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM aa_uploads ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="2">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$diretorio = 'assets/uploads/';
		if(!file_exists($diretorio.$row['url'])){ $pdo->query("DELETE FROM aa_uploads WHERE id='{$row['id']}'"); }
		if(file_exists($diretorio.$row['url'])){
?>
  <tr>
    <td><img src="<?php echo $diretorio.$row['url']; ?>" /></td>
    <td><?php echo $row['usuario']; ?></td>
  </tr>
<?php
		}
	}
}
?>
</table></div>