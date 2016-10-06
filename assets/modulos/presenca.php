<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
	if($_GET['formAjax'] == 'presenca'){
		$codigo = rand(10000,99999);
		$inserir = $pdo->query("INSERT INTO aa_presenca(codigo, time) VALUES('{$codigo}', '{$time}')");
		$logs = $pdo->query("INSERT INTO aa_logs_presenca(usuario, codigo, time) VALUES('{$user_view['usuario']}', '{$codigo}', '{$time}')");
		echo 1;
	}else if($_GET['formAjax'] == 'apagar'){
		$id = (int) $_POST['id'];
		$sql = $pdo->prepare("DELETE FROM aa_presenca WHERE id=:id");
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
	<input type="hidden" name="form" value="presenca" />
	<input type="hidden" name="back" value="false" />
	<input type="submit" style="margin-bottom: 10px" value="Gerar Presença">
</form>
<div class="table"><table>
  <tr>
  	<th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th>Código</th>
    <th>Término</th>
  </tr>
<?php
	$time_five = time() - 5*60;
	$sql = $pdo->query("SELECT * FROM aa_presenca WHERE time>'{$time_five}' ORDER BY id DESC");
  if($sql->rowCount() == 0){
?>
  <tr><td colspan="3">Nenhum</td></tr>
<?php
  }else{
	 while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
  	<td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td><?php echo $row['codigo']; ?></td>
    <td><?php echo date('H:i:s', $row['time']+5*60); ?></td>
  </tr>
<?php
    }
  }
?>
</table></div>