<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'paginas'){
		$categoria = $_POST['categoria'];
		if($categoria == ''){
			echo 2;
		}else{
			$sql = $pdo->prepare("INSERT INTO paginas_cat(categoria) VALUES(:categoria)");
			$sql->bindParam(':categoria', $categoria);
			$sql->execute();
			if($sql){
				echo 1;
			}
		}
    }else if($_GET['formAjax'] == 'paginasEditar'){
    	$categoria = $_POST['categoria'];
		$id = (int) $_POST['id'];
		if($id != ''){
			if($categoria == ''){
				echo 2;
			}else{
				$sql = $pdo->prepare("UPDATE paginas_cat SET categoria=:categoria WHERE id=:id");
				$sql->bindParam(':categoria', $categoria);
				$sql->bindParam(':id', $id);
				$sql->execute();
				if($sql){
					echo 1;
				}
			}
		}
	}else if($_GET['formAjax'] == 'paginasAdicionar'){
		$titulo = $_POST['titulo'];
		$link = Site::Url($titulo);
		$texto = $_POST['texto'];
		$id = (int) $_POST['id'];
		if($id != ''){
			if($titulo == '' || $texto == ''){
				echo 2;
			}else{
				$sql = $pdo->prepare("INSERT INTO paginas(ordem, icone, titulo, conteudo, url, categoria, status) VALUES('0', '', :titulo, :conteudo, :url, :categoria, 'true')");
				$sql->bindParam(':titulo', $titulo);
				$sql->bindParam(':url', $link);
				$sql->bindParam(':conteudo', $texto);
				$sql->bindParam(':categoria', $id);
				$sql->execute();
				if($sql){
					echo 1;
				}
			}
		}
	}else if($_GET['formAjax'] == 'paginasAdicionarEditar'){
		$titulo = $_POST['titulo'];
		$categoria = (int) $_POST['categoria'];
		$status = $_POST['status'];
		$texto = $_POST['texto'];
		$id = (int) $_POST['id'];
		if($id != ''){
			if($titulo == '' || $texto == ''){
				echo 2;
			}else{
				$sql = $pdo->prepare("UPDATE paginas SET titulo=:titulo, categoria=:categoria, status=:status, conteudo=:texto WHERE id=:id");
				$sql->bindParam(':titulo', $titulo);
				$sql->bindParam(':texto', $texto);
				$sql->bindParam(':categoria', $categoria);
				$sql->bindParam(':status', $status);
				$sql->bindParam(':id', $id);
				$sql->execute();
				if($sql){
					echo 1;
				}
			}
		}
    }else if($_GET['formAjax'] == 'apagar'){
      $id = (int) $_POST['id'];
      $sql = $pdo->prepare("DELETE FROM paginas WHERE id=:id");
      $sql->bindParam(':id', $id);
      $sql->execute();
      if($sql){
        echo 1;
      }
    }else if($_GET['formAjax'] == 'apagar_cat'){
    	$id = (int) $_POST['id'];
		$sql = $pdo->prepare("DELETE FROM paginas_cat WHERE id=:id");
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
		$id = (int) $_GET['id'];
		$sql = $pdo->prepare("SELECT * FROM paginas_cat WHERE id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	    <input type="hidden" name="form" value="paginasEditar" />
	    <input type="hidden" name="back" value="true" />
	    <input type="hidden" name="id" value="<?php echo $id; ?>">

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Categoria:</p>
	    <input type="text" name="categoria" value="<?php echo $dados['categoria'] ?>" />

	    <input type="submit" value="Salvar" />
	</form>
<?php
	}else if(isset($_GET['tipo']) && $_GET['tipo'] == 'categoria'){
		if(isset($_GET['pag_id'])){
			$id = (int) $_GET['pag_id'];
			$sql = $pdo->prepare("SELECT * FROM paginas WHERE id=:id");
			$sql->bindParam(':id', $id);
			$sql->execute();
			$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
			<form id="formPag" enctype="multipart/form-data" autocomplete="off">
			    <input type="hidden" name="form" value="paginasAdicionarEditar" />
			    <input type="hidden" name="back" value="true" />
			    <input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

			    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Titulo:</p>
			    <input type="text" name="titulo" value="<?php echo $dados['titulo']; ?>" />
			    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Categoria:</p>
				<select name="categoria">
				<?php
					$sql_c = $pdo->query("SELECT * FROM paginas_cat");
					while($row = $sql_c->fetch(PDO::FETCH_ASSOC)){
				?>
					<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $dados['categoria']){ echo 'selected'; } ?>><?php echo $row['categoria']; ?></option>
				<?php
					}
				?>
				</select>
				<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Status:</p>
				<select name="status">
			      <option value="true" <?php if($dados['status'] == 'true'){ echo 'selected'; } ?>>Ativo</option>
			      <option value="false" <?php if($dados['status'] == 'false'){ echo 'selected'; } ?>>Inativo</option>
			    </select>
			    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Texto:</p>
				<textarea id="tiny" name="texto"><?php echo $dados['conteudo']; ?></textarea>

				<input type="submit" style="margin-top: 10px" value="Salvar" />
			</form>
<?php
		}else{
			$id = (int) $_GET['cat_id'];
			$sql = $pdo->prepare("SELECT * FROM paginas_cat WHERE id=:id");
			$sql->bindParam(':id', $id);
			$sql->execute();
			$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
			<form id="formPag" enctype="multipart/form-data" autocomplete="off">
			    <input type="hidden" name="form" value="paginasAdicionar" />
			    <input type="hidden" name="back" value="false" />
			    <input type="hidden" name="id" value="<?php echo $id; ?>">

				<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Categoria:</p>
			    <input type="text" value="<?php echo $dados['categoria'] ?>" readonly />
			    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Titulo:</p>
			    <input type="text" name="titulo" />
			    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Texto:</p>
				<textarea id="tiny" name="texto"></textarea>

				<input type="submit" style="margin-top: 10px" value="Adicionar" />
			</form>

			<div class="table"><table>
			  <tr>
			    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
			    <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
			    <th>Titulo</th>
			    <th>Status</th>
			  </tr>
			<?php
				$sql = $pdo->query("SELECT * FROM paginas WHERE categoria='{$id}' ORDER BY id ASC");
				if($sql->rowCount() == 0){
?>
	<tr><td colspan="4">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
			?>
			  <tr id="<?php echo $row['id']; ?>">
			    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
			    <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/categoria/<?php echo $id; ?>/editar/<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
			    <td><?php echo $row['titulo']; ?></td>
			    <td><?php if($row['status'] == 'true'){ echo 'Ativo'; }else{ echo 'Inativo'; } ?></td>
			  </tr>
			<?php
				}
			}
			?>
			</table></div>
<?php
		}
	}else{
?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	    <input type="hidden" name="form" value="paginas" />
	    <input type="hidden" name="back" value="false" />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Categoria:</p>
	    <input type="text" name="categoria" />

	    <input type="submit" value="Adicionar" />
	</form>

	<div class="table"><table>
	  <tr>
	    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
	    <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
	    <th><i class="fa fa-plus" aria-hidden="true"></i></th>
	    <th>Categoria</th>
	  </tr>
	<?php
		$sql = $pdo->query("SELECT * FROM paginas_cat ORDER BY id ASC");
		if($sql->rowCount() == 0){
?>
	<tr><td colspan="4">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
	?>
	  <tr id="<?php echo $row['id']; ?>">
	    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>, 'apagar_cat')"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
	    <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/editar/<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
	    <td><a href="pagina/<?php echo $url; ?>/categoria/<?php echo $row['id']; ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
	    <td><?php echo $row['categoria']; ?></td>
	  </tr>
	<?php
		}
	}
	?>
	</table></div>
<?php
	}
?>