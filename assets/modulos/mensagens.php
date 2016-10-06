<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'usuario'){
			$user = htmlspecialchars($_POST['userView']);
			if($user == ''){
				echo 2;
			}else{
				$usuario_view_sql = $pdo->prepare("SELECT * FROM usuarios WHERE usuario=:usuario");
				$usuario_view_sql->bindParam(':usuario', $user);
				$usuario_view_sql->execute();
				if($usuario_view_sql->rowCount() == 0){
					echo 7;
				}else{
					echo 9;
				}
			}
		}else if($_GET['formAjax'] == 'apagar'){
			$id = (int) $_POST['id'];
			$sql = $pdo->prepare("DELETE FROM usuarios_mensagens WHERE id=:id");
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
		$user = $_GET['id'];
		$sql = $pdo->prepare("SELECT * FROM usuarios WHERE usuario=:user");
		$sql->bindParam(':user', $user);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
<form>
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário:</p>
	<input type="text" value="<?php echo $dados['usuario']; ?>" readonly />
</form>
<div class="table"><table>
  <tr>
  	<th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th>Autor</th>
    <th>Mensagem</th>
    <th>Data</th>
  </tr>
<?php
	$time_five = time() - 5*60;
	$sql = $pdo->query("SELECT * FROM usuarios_mensagens WHERE usuario_id={$dados['id']} ORDER BY id DESC");
  if($sql->rowCount() == 0){
?>
  <tr><td colspan="4">Nenhum</td></tr>
<?php
  }else{
	 while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
  	<td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td><?php echo $row['autor']; ?></td>
    <td><?php echo $row['mensagem']; ?></td>
    <td><?php echo date('d/m/Y H:i', $row['time']); ?></td>
  </tr>
<?php
    }
  }
?>
</table></div>
<?php
	}else{
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="usuario" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário:</p>
	<input type="text" name="userView" />

	<input type="submit" value="Ver" />
</form>
<?php
	}
?>