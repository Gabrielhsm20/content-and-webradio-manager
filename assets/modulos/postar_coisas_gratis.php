<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'coisa'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$imagem = htmlspecialchars($_POST['imagem']);
			$url = $_POST['url'];
			if($titulo == '' || $imagem == '' || $url == ''){
				echo 2;
			}else{
				$sql = $pdo->prepare("INSERT INTO coisas_gratis(titulo, imagem, link) VALUES(:titulo, :imagem, :url)");
		        $sql->bindParam(':titulo', $titulo);
		        $sql->bindParam(':imagem', $imagem);
		        $sql->bindParam(':url', $url);
		        $sql->execute();
		        if($sql){
		        	echo 1;
		        }
			}
		}else if($_GET['formAjax'] == 'coisaEditar'){
			$titulo = htmlspecialchars($_POST['titulo']);
			$imagem = htmlspecialchars($_POST['imagem']);
			$url = $_POST['url'];
			$id = (int) $_POST['id'];
			if($id != ''){
				if($titulo == '' || $imagem == '' || $url == ''){
					echo 2;
				}else{
					$sql = $pdo->prepare("UPDATE coisas_gratis SET titulo=:titulo, imagem=:imagem, link=:url WHERE id=:id");
			        $sql->bindParam(':titulo', $titulo);
			        $sql->bindParam(':imagem', $imagem);
			        $sql->bindParam(':url', $url);
			        $sql->bindParam(':id', $id);
			        $sql->execute();
			        if($sql){
			        	echo 1;
			        }
				}
			}
		}else if($_GET['formAjax'] == 'apagar'){
			$id = (int) $_POST['id'];
			$sql = $pdo->prepare("DELETE FROM coisas_gratis WHERE id=:id");
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
		$sql = $pdo->prepare("SELECT * FROM coisas_gratis WHERE id=:id");
		$sql->bindParam(':id', $id);
		$sql->execute();
		$dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
	<form id="formPag" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="form" value="coisaEditar" />
		<input type="hidden" name="back" value="true" />
		<input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Título:</p>
		<input type="text" name="titulo" value="<?php echo $dados['titulo']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Atual Imagem:</p>
		<img src="<?php echo $dados['imagem']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Imagem:</p>
		<input type="text" name="imagem" value="<?php echo $dados['imagem']; ?>" />
		<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Url:</p>
		<input type="text" name="url" value="<?php echo $dados['link']; ?>" />

		<input type="submit" value="Adicionar" />
	</form>
<?php
	}else{
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="coisa" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Título:</p>
	<input type="text" name="titulo" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Imagem:</p>
	<input type="text" name="imagem" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Url:</p>
	<input type="text" name="url" />

	<input type="submit" value="Adicionar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
    <th>Título</th>
    <th>Imagem</th>
    <th>Url</th>
  </tr>
<?php
	$quantidade = 50;
    $registros = $pdo->query("SELECT * FROM coisas_gratis")->rowCount();
    $pagina     = (isset ($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
    $inicio     = ($quantidade * $pagina) - $quantidade;
    $totalPagina = ceil($registros/$quantidade);
	$sql = $pdo->query("SELECT * FROM coisas_gratis ORDER BY id DESC LIMIT $inicio, $quantidade");
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
    <td><img src="<?php echo $row['imagem']; ?>" /></td>
    <td><a href="<?php echo $row['link'] ?>" target="_blank">Url</a></td>
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