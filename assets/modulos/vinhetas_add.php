<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'vinhetas_add'){
    	$nome = htmlspecialchars($_POST['nome']);
		$audio = $_FILES['audio'];
		if($audio['tmp_name'] == '' || $nome == ''){
			echo 2;
		}else{
			if(@!preg_match("/^audio\/(mp4|mp3|mpeg3|wma)$/", $audio["type"])){
				echo 6;
			}else{
				preg_match("/\.(mp4|mp3|mpeg3|wma){1}$/i", $audio["name"], $ext);
   				$audio_name = 'vinheta-'.Site::Url($audio["name"]).'-'.md5(uniqid(time())) . "." . $ext[1];
		        $caminho_audio = "../uploads/".$audio_name;
		        move_uploaded_file($audio["tmp_name"], $caminho_audio);

		        $sql = $pdo->prepare("INSERT INTO aa_vinhetas(nome, audio) VALUES(:nome, :audio)");
		        $sql->bindParam(':nome', $nome);
		        $sql->bindParam(':audio', $audio_name);
		        $sql->execute();
		        if($sql){
		        	echo 1;
		        }
			}
		}
    }else if($_GET['formAjax'] == 'apagar'){
		$id = (int) $_POST['id'];
		$vinheta_v = $pdo->prepare("SELECT * FROM aa_vinhetas WHERE id=:id");
		$vinheta_v->bindParam(':id', $id);
		$vinheta_v->execute();
		$vinheta_view = $vinheta_v->fetch(PDO::FETCH_ASSOC);

		$caminho_vinheta = '../uploads/'.$vinheta_view['audio'];
		if(file_exists($caminho_vinheta)){
			unlink($caminho_vinheta);
		}
		$sql = $pdo->prepare("DELETE FROM aa_vinhetas WHERE id=:id");
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
	<input type="hidden" name="form" value="vinhetas_add" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Nome:</p>
	<input type="text" name="nome" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Vinheta:</p>
	<input type="file" accept="audio/*" name="audio" />

	<input type="submit" value="Adicionar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th>Nome</th>
    <th>Vinheta</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM aa_vinhetas ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="3">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td><?php echo $row['nome']; ?></td>
    <td><audio controls src="assets/uploads/<?php echo $row['audio']; ?>"></audio></td>
  </tr>
<?php
		}
	}
?>
</table></div>