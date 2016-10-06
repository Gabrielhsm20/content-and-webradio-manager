<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'emblema'){
			$codigo = htmlspecialchars($_POST['codigo']);
			if($codigo == ''){
				echo 2;
			}else{
				$sql = $pdo->prepare("INSERT INTO ultimos_emblemas(codigo) VALUES(:codigo)");
		        $sql->bindParam(':codigo', $codigo);
		        $sql->execute();
		        if($sql){
		        	echo 1;
		        }
			}
		}else if($_GET['formAjax'] == 'apagar'){
			$id = (int) $_POST['id'];
			$sql = $pdo->prepare("DELETE FROM ultimos_emblemas WHERE id=:id");
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
	<input type="hidden" name="form" value="emblema" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Código:</p>
	<input type="text" name="codigo" />

	<input type="submit" value="Adicionar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th>Código</th>
    <th>Imagem</th>
  </tr>
<?php
	$quantidade = 50;
    $registros = $pdo->query("SELECT * FROM ultimos_emblemas")->rowCount();
    $pagina     = (isset ($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
    $inicio     = ($quantidade * $pagina) - $quantidade;
    $totalPagina = ceil($registros/$quantidade);
	$sql = $pdo->query("SELECT * FROM ultimos_emblemas ORDER BY id DESC LIMIT $inicio, $quantidade");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="5">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td><?php echo $row['codigo']; ?></td>
    <td><img src="https://habboo-a.akamaihd.net/c_images/album1584/<?php echo $row['codigo']; ?>.gif" /></td>
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