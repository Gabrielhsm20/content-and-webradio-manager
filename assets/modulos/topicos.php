<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'topicoEditar'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$texto = nl2br(htmlspecialchars($_POST['texto']));
			$categoria = (int) $_POST['categoria'];
			$fixo = htmlspecialchars($_POST['fixo']);
			$moderado = htmlspecialchars($_POST['estado']);
			$status = htmlspecialchars($_POST['status']);
			$id = (int) $_POST['id'];
			$topico_v = $pdo->prepare("SELECT * FROM topicos WHERE id=:id");
			$topico_v->bindParam(':id', $id);
			$topico_v->execute();
			$topico_view = $topico_v->fetch(PDO::FETCH_ASSOC);
			if($id != ''){
				if($titulo == '' || $texto == '' || $categoria == '' || $fixo == '' || $status == '' || $moderado == ''){
					echo 2;
				}else{
					$sql = $pdo->prepare("UPDATE topicos SET titulo=:titulo, categoria=:categoria, texto=:texto, fixo=:fixo, status=:status, moderado=:moderado WHERE id=:id");
					$sql->bindParam(':titulo', $titulo);
					$sql->bindParam(':categoria', $categoria);
					$sql->bindParam(':texto', $texto);
					$sql->bindParam(':fixo', $fixo);
					$sql->bindParam(':status', $status);
					$sql->bindParam(':moderado', $moderado);
					$sql->bindParam(':id', $id);
					$sql->execute();
					if($sql){
			        	echo 1;
			        }
				}
			}
		}else if($_GET['formAjax'] == 'apagar'){
	    	$id = (int) $_POST['id'];
			$sql = $pdo->prepare("DELETE FROM topicos WHERE id=:id");
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
		$sql = $pdo->prepare("SELECT * FROM topicos WHERE id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="form" value="topicoEditar" />
		<input type="hidden" name="back" value="true" />
		<input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Moderador:</p>
		<input type="text" value="<?php echo $dados['moderador']; ?>" readonly />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Autor:</p>
		<input type="text" value="<?php echo $dados['autor']; ?>" readonly />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Titulo:</p>
		<input type="text" name="titulo" value="<?php echo $dados['titulo']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Categoria:</p>
		<select name="categoria">
		<?php
			$sql_c = $pdo->query("SELECT * FROM topicos_cat ORDER BY id");
			while($row = $sql_c->fetch(PDO::FETCH_ASSOC)){
		?>
			<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $dados['categoria']){ echo 'selected'; } ?>><?php echo $row['categoria']; ?></option>
		<?php
			}
		?>
		</select>
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Fixo</p>
		<select name="fixo">
			<option value="true" <?php if($dados['fixo'] == 'true'){ echo 'selected'; } ?>>Sim</option>
			<option value="false" <?php if($dados['fixo'] == 'false'){ echo 'selected'; } ?>>Não</option>
		</select>
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Estado</p>
		<select name="estado">
			<option value="fechado" <?php if($dados['moderado'] == 'fechado'){ echo 'selected'; } ?>>Fechado</option>
			<option value="moderado" <?php if($dados['moderado'] == 'moderado'){ echo 'selected'; } ?>>Moderado</option>
		</select>
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Status</p>
		<select name="status">
			<option value="true" <?php if($dados['status'] == 'true'){ echo 'selected'; } ?>>Ativo</option>
			<option value="false" <?php if($dados['status'] == 'false'){ echo 'selected'; } ?>>Inativo</option>
		</select>
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Texto:</p>
		<textarea name="texto"><?php echo strip_tags($dados['texto']); ?></textarea>

		<input type="submit" style="margin-top: 10px" value="Salvar" />
	</form>
<?php
	}else{
?>
<div class="table"><table>
<tr>
	<th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
	<th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
	<th>Titulo</th>
	<th>Autor</th>
	<th>Moderador</th>
	<th>Status</th>
	<th>Fixo</th>
</tr>
<?php
	$quantidade = 50;
    $registros = $pdo->query("SELECT * FROM topicos WHERE moderado!='pendente'")->rowCount();
    $pagina     = (isset ($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
    $inicio     = ($quantidade * $pagina) - $quantidade;
    $totalPagina = ceil($registros/$quantidade);
	$sql = $pdo->query("SELECT * FROM topicos WHERE moderado!='pendente' ORDER BY id DESC LIMIT $inicio, $quantidade");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="7">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>" style="opacity: 0.5;">
  	<td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/editar/<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
    <td><?php echo $row['titulo']; ?></td>
    <td><?php echo $row['autor']; ?></td>
    <td><?php echo $row['moderador']; ?></td>
    <td><?php if($row['status'] == 'true'){ echo 'Ativo'; }else{ echo 'Inativo'; } ?></td>
    <td><?php if($row['fixo'] == 'true'){ echo 'Sim'; }else{ echo 'Não'; } ?></td>
  </tr>
<?php
		}
	}
?>
</table></div>
<div class="paginacao">
<?php
    for($i = 1; $i <= $totalPagina; $i++){
        if($i == $pagina){
            echo '<div class="pag theme" style="background: #EEE; color: #666">'.$i.'</div>';
        }else{
            echo '<a href="pagina/'.$url.'/lista/'.$i.'"><div class="theme pag">'.$i.'</div></a>';
        }
    }
?>
</div>
<?php
	}
?>