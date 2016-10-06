<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'cat_noticias'){
    	$nome = htmlspecialchars($_POST['nome']);
		if($nome == ''){
			echo 2;
		}else{
			$sql = $pdo->prepare("INSERT INTO noticias_cat(categoria) VALUES(:nome)");
			$sql->bindParam(':nome', $nome);
			$sql->execute();
			if($sql){
				echo 1;
			}
		}
    }else if($_GET['formAjax'] == 'apagar'){
    	$id = (int) $_POST['id'];
		$sql = $pdo->prepare("DELETE FROM noticias_cat WHERE id=:id");
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
	<input type="hidden" name="form" value="cat_noticias" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Nome:</p>
	<input type="text" name="nome" />

	<input type="submit" value="Adicionar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th>Nome</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM noticias_cat ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="2">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td><?php echo $row['categoria']; ?></td>
  </tr>
<?php
		}
	}
?>
</table></div>