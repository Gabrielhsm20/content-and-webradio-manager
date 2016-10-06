<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'apagar'){
			$id = (int) $_POST['id'];
			$sql = $pdo->prepare("DELETE FROM timeline WHERE id=:id");
			$sql->bindParam(':id', $id);
			$sql->execute();
			if($sql){
				echo 1;
			}
		}
	// FIM AJAX //
exit(); }else{ exit(); }}
?>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th>Usuário</th>
    <th>Mensagem</th>
    <th>Data</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM timeline ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="4">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td><?php echo $row['usuario']; ?></td>
    <td><?php echo $row['mensagem']; ?></td>
    <td><?php echo date('d/m/Y H:i', $row['time']); ?></td>
  </tr>
<?php
		}
	}
?>
</table></div>