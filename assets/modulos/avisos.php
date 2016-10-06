<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'avisos'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$texto = $_POST['texto'];
			if($titulo == '' || $texto == ''){
				echo 2;
			}else{
				$sql = $pdo->prepare("INSERT INTO aa_avisos(titulo, texto, autor, time) VALUES(:titulo, :texto, :autor, :time)");
				$sql->bindParam(':titulo', $titulo);
				$sql->bindParam(':texto', $texto);
				$sql->bindParam(':autor', $user_view['usuario']);
				$sql->bindParam(':time', $time);
				$sql->execute();
				if($sql){
					echo 1;
				}
			}
		}else if($_GET['formAjax'] == 'avisosEditar'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$texto = $_POST['texto'];
			$id = (int) $_POST['id'];

			if($id != ''){
				if($titulo == '' || $texto == ''){
					echo 2;
				}else{
					$sql = $pdo->prepare("UPDATE aa_avisos SET titulo=:titulo, texto=:texto WHERE id=:id");
					$sql->bindParam(':titulo', $titulo);
					$sql->bindParam(':texto', $texto);
					$sql->bindParam(':id', $id);
					$sql->execute();
					if($sql){
						echo 1;
					}
				}
			}
		}else if($_GET['formAjax'] == 'apagar'){
			$id = (int) $_POST['id'];
			$sql = $pdo->prepare("DELETE FROM aa_avisos WHERE id=:id");
			$sql->bindParam(':id', $id);
			$sql->execute();
			if($sql){
				$sql_a = $pdo->prepare("DELETE FROM aa_avisos_visto WHERE aviso_id=:id");
				$sql_a->bindParam(':id', $id);
				$sql_a->execute();
				echo 1;
			}
		}
	// FIM AJAX //
exit(); }else{ exit(); }}
?>
<?php
	if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){
		$id = (int) $_GET['id'];
		$sql = $pdo->prepare("SELECT * FROM aa_avisos WHERE id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);

?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="form" value="avisosEditar" />
		<input type="hidden" name="back" value="true" />
		<input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Titulo:</p>
		<input type="text" name="titulo" value="<?php echo $dados['titulo']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Texto:</p>
		<textarea id="tiny" name="texto"><?php echo $dados['texto']; ?></textarea>

		<input type="submit" style="margin-top: 10px" value="Salvar" />
	</form>
<?php
	}else{
?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="form" value="avisos" />
		<input type="hidden" name="back" value="false" />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Titulo:</p>
		<input type="text" name="titulo" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Texto:</p>
		<textarea id="tiny" name="texto"></textarea>

		<input type="submit" style="margin-top: 10px" value="Criar" />
	</form>

	<div class="table"><table>
	  <tr>
	    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
	    <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
	    <th>Titulo</th>
	    <th>Autor</th>
	    <th>Data</th>
	  </tr>
	<?php
		$sql = $pdo->query("SELECT * FROM aa_avisos ORDER BY id DESC");
		if($sql->rowCount() == 0){
?>
	<tr><td colspan="5">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
	?>
	  <tr id="<?php echo $row['id']; ?>">
	    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
	    <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/editar/<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
	    <td><?php echo $row['titulo']; ?></td>
	    <td><?php echo $row['autor']; ?></td>
	    <td><?php echo date('d/m/Y - H:i', $row['time']); ?></td>
	  </tr>
	<?php
		}
	}
	?>
	</table></div>
<?php
	}
?>