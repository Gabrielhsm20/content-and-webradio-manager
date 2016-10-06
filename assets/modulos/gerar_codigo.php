<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'gerar_codigo'){
    	$codigo = htmlspecialchars($_POST['codigo']);
		$valor = htmlspecialchars($_POST['valor']);
		$estoque = htmlspecialchars($_POST['estoque']);
		if($codigo == '' || $valor == '' || $estoque == ''){
			echo 2;
		}else{
			$sql = $pdo->prepare("INSERT INTO moedas(valor, estoque, codigo) VALUES(:valor, :estoque, :codigo)");
			$sql->bindParam(':valor', $valor);
			$sql->bindParam(':estoque', $estoque);
			$sql->bindParam(':codigo', $codigo);
			$sql->execute();
			if($sql){
				$log = $pdo->prepare("INSERT INTO aa_logs_moedas(valor, estoque, codigo, autor, time) VALUES(:valor, :estoque, :codigo, :autor, :time)");
				$log->bindParam(':valor', $valor);
				$log->bindParam(':estoque', $estoque);
				$log->bindParam(':codigo', $codigo);
				$log->bindParam(':autor', $user_view['usuario']);
				$log->bindParam(':time', $time);
				$log->execute();
				echo 1;
			}
		}
    }else if($_GET['formAjax'] == 'apagar'){
    	$id = (int) $_POST['id'];
		$sql = $pdo->prepare("DELETE FROM moedas WHERE id=:id");
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
	<input type="hidden" name="form" value="gerar_codigo" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Código:</p>
	<input type="text" value="<?php echo rand(10000,99999); ?>" name="codigo" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Valor:</p>
	<input type="number" min="1" name="valor"><br>
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Estoque:</p>
	<input type="number" min="1" name="estoque"><br>
	<input type="submit" value="Gerar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th>Valor</th>
    <th>Estoque</th>
    <th>Código</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM moedas ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="2">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$usados = $pdo->query("SELECT * FROM moedas_usadas WHERE codigo='{$row['codigo']}'")->rowCount();
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td><?php echo $row['valor']; ?></td>
    <td><?php echo $usados.'/'.$row['estoque']; ?></td>
    <td><?php echo $row['codigo']; ?></td>
  </tr>
<?php
		}
	}
?>
</table></div>