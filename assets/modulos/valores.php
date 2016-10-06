<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'valores'){
			$mobi = htmlspecialchars($_POST['nome']);
			$categoria = (int) $_POST['categoria'];
			$imagem = $_FILES['imagem'];
			$preco = htmlspecialchars($_POST['preco']);
			if($mobi == '' || $categoria == '' || $imagem['tmp_name'] == '' || $preco == ''){
				echo 2;
			}else{
				if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
					echo 4;
				}else{
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
       				$imagem_name = 'valor-'.md5(uniqid(time())) . "." . $ext[1];
			        $caminho_imagem = "../uploads/".$imagem_name;
			        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);

			        $sql = $pdo->prepare("INSERT INTO valores(mobi, categoria, preco, estado, icone, valorista) VALUES(:mobi, :categoria, :preco, 'manteve', :icone, :valorista)");
			        $sql->bindParam(':mobi', $mobi);
			        $sql->bindParam(':categoria', $categoria);
			        $sql->bindParam(':icone', $imagem_name);
			        $sql->bindParam(':preco', $preco);
			        $sql->bindParam(':valorista', $user_view['usuario']);
			        $sql->execute();
			        if($sql){
			        	echo 1;
			        }
				}
			}
		}else if($_GET['formAjax'] == 'valorEditar'){
			$mobi = htmlspecialchars($_POST['nome']);
			$categoria = (int) $_POST['categoria'];
			$imagem = $_FILES['imagem'];
			$preco = htmlspecialchars($_POST['preco']);
			$estado = htmlspecialchars($_POST['estado']);
			$id = (int) $_POST['id'];
			$valor_v = $pdo->prepare("SELECT * FROM valores WHERE id=:id");
			$valor_v->bindParam(':id', $id);
			$valor_v->execute();
			$valor_view = $valor_v->fetch(PDO::FETCH_ASSOC);
			if($id != ''){
				if($mobi == '' || $categoria == '' || $preco == '' || $estado == ''){
					echo 2;
				}else{
					if($imagem['tmp_name'] != ''){
						if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
							echo 4;
						}else{
							$diretorio = '../uploads/';
							if(file_exists($diretorio.$valor_view['icone'])){
								unlink($diretorio.$valor_view['icone']);
							}
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
		       				$imagem_name = 'valor-'.md5(uniqid(time())) . "." . $ext[1];
					        $caminho_imagem = $diretorio.$imagem_name;
					        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
						}
					}else{
						$imagem_name = $valor_view['icone'];
					}
					$sql = $pdo->prepare("UPDATE valores SET mobi=:mobi, categoria=:categoria, icone=:imagem, preco=:preco, estado=:estado WHERE id=:id");
					$sql->bindParam(':mobi', $mobi);
					$sql->bindParam(':categoria', $categoria);
					$sql->bindParam(':imagem', $imagem_name);
					$sql->bindParam(':preco', $preco);
					$sql->bindParam(':estado', $estado);
					$sql->bindParam(':id', $id);
					$sql->execute();
					if($sql){
			        	echo 1;
			        }
				}
			}
		}else if($_GET['formAjax'] == 'apagar'){
			$id = (int) $_POST['id'];
			$icone_v = $pdo->prepare("SELECT * FROM valores WHERE id=:id");
			$icone_v->bindParam(':id', $id);
			$icone_v->execute();
			$icone_view = $icone_v->fetch(PDO::FETCH_ASSOC);

			$caminho_icone = '../uploads/'.$icone_view['icone'];
			if(file_exists($caminho_icone)){
				unlink($caminho_icone);
			}
			$sql = $pdo->prepare("DELETE FROM valores WHERE id=:id");
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
		$sql = $pdo->prepare("SELECT * FROM valores WHERE id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="form" value="valorEditar" />
		<input type="hidden" name="back" value="true" />
		<input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Nome:</p>
		<input type="text" name="nome" value="<?php echo $dados['mobi']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Categoria:</p>
		<select name="categoria">
		<?php
			$sql_c = $pdo->query("SELECT * FROM valores_cat ORDER BY id");
			while($row = $sql_c->fetch(PDO::FETCH_ASSOC)){
		?>
			<option value="<?php echo $row['id']; ?>" <?php if($dados['categoria'] == $row['id']){ echo 'selected'; } ?>><?php echo $row['categoria']; ?></option>
		<?php
			}
		?>
		</select>
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Atual Imagem:</p>
		<img src="assets/uploads/<?php echo $dados['icone']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione a imagem: (Deixe em branco caso não queira mudar)</p>
		<input type="file" accept="image/*" name="imagem" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Preço:</p>
		<input type="number" name="preco" value="<?php echo $dados['preco']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Estado:</p>
		<select name="estado">
			<option value="subiu" <?php if($dados['estado'] == 'subiu'){ echo 'selected'; } ?>>Subiu</option>
			<option value="manteve" <?php if($dados['estado'] == 'manteve'){ echo 'selected'; } ?>>Manteve</option>
			<option value="caiu" <?php if($dados['estado'] == 'caiu'){ echo 'selected'; } ?>>Caiu</option>
		</select>

		<input type="submit" value="Salvar" />
	</form>
<?php
	}else{
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="valores" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Nome:</p>
	<input type="text" name="nome" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Categoria:</p>
	<select name="categoria">
	<?php
		$sql_c = $pdo->query("SELECT * FROM valores_cat ORDER BY id");
		while($row = $sql_c->fetch(PDO::FETCH_ASSOC)){
	?>
		<option value="<?php echo $row['id']; ?>"><?php echo $row['categoria']; ?></option>
	<?php
		}
	?>
	</select>
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione a imagem:</p>
	<input type="file" accept="image/*" name="imagem" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Preço:</p>
	<input type="number" name="preco" />

	<input type="submit" value="Adicionar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
    <th>Nome</th>
    <th>Categoria</th>
    <th>Preço</th>
    <th>Estado</th>
    <th>Imagem</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM valores ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="7">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
			$categoria = $pdo->query("SELECT * FROM valores_cat WHERE id='{$row['categoria']}'")->fetch(PDO::FETCH_ASSOC);
			$categoria = $categoria['categoria'];
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/editar/<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
    <td><?php echo $row['mobi']; ?></td>
    <td><?php echo $categoria; ?></td>
    <td><?php echo $row['preco'].' moedas'; ?></td>
    <td><?php if($row['estado'] == 'subiu'){ echo 'Subiu'; }else if($row['estado'] == 'manteve'){ echo 'Manteve'; }else{ echo 'Caiu'; } ?></td>
    <td><img src="assets/uploads/<?php echo $row['icone']; ?>" /></td>
  </tr>
<?php
		}
	}
?>
</table></div>
<?php
	}
?>