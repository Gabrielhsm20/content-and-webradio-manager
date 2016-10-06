<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'permissoes'){
    	$cargo = (int) $_POST['id'];
		$pagina = (int) $_POST['pagina'];
		$ordem_c = $pdo->prepare("SELECT * FROM aa_cargos WHERE cargo_id=:id");
		$ordem_c->bindParam(':id', $cargo);
		$ordem_c->execute();
		$ordem = $ordem_c->fetch(PDO::FETCH_ASSOC);
		if($cargo == '' || $pagina == ''){
			echo 2;
		}else{
			if($ordem['ordem'] >= $user_cargo['ordem']){
				$sql = $pdo->prepare("INSERT INTO aa_permissao(cargo_id, canal_id) VALUES(:cargo_id, :canal_id)");
				$sql->bindParam(':cargo_id', $cargo);
				$sql->bindParam(':canal_id', $pagina);
				$sql->execute();
				if($sql){
					echo 1;
				}
			}
		}
    }else if($_GET['formAjax'] == 'apagar'){
		$id = (int) $_POST['id'];
		$sql = $pdo->prepare("DELETE FROM aa_permissao WHERE per_id=:id");
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
	if(isset($_GET['tipo']) && $_GET['tipo'] == 'cargo'){
		$id = (int) $_GET['car_id'];
		$sql = $pdo->prepare("SELECT * FROM aa_cargos WHERE cargo_id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="form" value="permissoes" />
	    <input type="hidden" name="back" value="false" />
	    <input type="hidden" name="id" value="<?php echo $dados['cargo_id']; ?>">

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Cargo:</p>
		<input type="text" value="<?php echo $dados['cargo'] ?>" readonly />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Página:</p>
		<select name="pagina">
			<option value="" selected>-</option>
		<?php
			$sql_c = $pdo->query("SELECT * FROM aa_canais WHERE status='true' ORDER BY pai");
			while($row = $sql_c->fetch(PDO::FETCH_ASSOC)){
				$sql_e = $pdo->query("SELECT * FROM aa_permissao WHERE canal_id='{$row['canal_id']}' AND cargo_id='{$dados['cargo_id']}'")->rowCount();
				if($sql_e == 0){
		?>
					<option value="<?php echo $row['canal_id']; ?>"><?php if($row['pai'] == 0){ echo $row['canal'].' (PAI)'; }else{ echo $row['canal']; } ?></option>
		<?php
				}
			}
		?>
		</select>

		<input type="submit" value="Adicionar" />
	</form>

	<div class="table"><table>
	  <tr>
	    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
	    <th>Página</th>
	  </tr>
	<?php
		$sql = $pdo->query("SELECT * FROM aa_permissao p, aa_cargos g, aa_canais c WHERE p.cargo_id = '{$dados['cargo_id']}' AND p.cargo_id = g.cargo_id AND p.canal_id = c.canal_id GROUP BY p.canal_id ORDER BY c.pai ASC");
		if($sql->rowCount() == 0){
?>
	<tr><td colspan="2">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
	?>
	  <tr id="<?php echo $row['cargo_id']; ?>">
	    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['per_id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
	    <td><?php if($row['pai'] == 0){ echo $row['canal'].' (PAI)'; }else{ echo $row['canal']; } ?></td>
	  </tr>
	<?php
		}
	}
	?>
	</table></div>
<?php
	}else{
?>
	<div class="table"><table>
	  <tr>
	    <th><i class="fa fa-plus" aria-hidden="true"></i></th>
	    <th>Cargo</th>
	  </tr>
	<?php
		$sql = $pdo->query("SELECT * FROM aa_cargos WHERE status='true' ORDER BY ordem ASC");
		if($sql->rowCount() == 0){
?>
	<tr><td colspan="2">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
	?>
	  <tr>
	    <td><a href="pagina/<?php echo $url; ?>/cargo/<?php echo $row['cargo_id']; ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
	    <td><?php echo $row['cargo']; ?></td>
	  </tr>
	<?php
		}
	}
	?>
	</table></div>
<?php
	}
?>