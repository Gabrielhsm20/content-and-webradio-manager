<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'adc_lista_negra'){
    	$usuario = htmlspecialchars($_POST['usuario']);
		$motivo = htmlspecialchars($_POST['motivo']);
		if($usuario == '' || $motivo == ''){
			echo 2;
		}else{
			$sql = $pdo->prepare("INSERT INTO aa_lista_negra(usuario, motivo) VALUES(:usuario, :motivo)");
			$sql->bindParam(':usuario', $usuario);
			$sql->bindParam(':motivo', $motivo);
			$sql->execute();
			if($sql){
				echo 1;
			}
		}
	}else if($_GET['formAjax'] == 'apagar'){
		$id = (int) $_POST['id'];
		$sql = $pdo->prepare("DELETE FROM aa_lista_negra WHERE id=:id");
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
	<input type="hidden" name="form" value="adc_lista_negra" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário:</p>
	<input type="text" name="usuario" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Motivo:</p>
	<input type="text" name="motivo" />

	<input type="submit" value="Adicionar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th>Usuário</th>
    <th>Motivo</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM aa_lista_negra ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="3">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td><?php echo $row['usuario']; ?></td>
    <td><?php echo $row['motivo']; ?></td>
  </tr>
<?php
		}
	}
?>
</table></div>