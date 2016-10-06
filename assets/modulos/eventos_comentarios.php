<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
	// AJAX
		if($_GET['formAjax'] == 'apagar'){
			$id = (int) $_POST['id'];
			$sql = $pdo->prepare("DELETE FROM noticias_comentarios WHERE coment_id=:id");
			$sql->bindParam(':id', $id);
			$sql->execute();
			if($sql){
				echo 1;
			}
		}
	// FIM AJAX //
exit(); }else{ exit(); }}
?>
<div class="table"><table>
	<tr>
		<th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
		<th>Título</th>
		<th>Autor</th>
		<th>Comentário</th>
		<th>Data</th>
	</tr>
	<?php
		$quantidade = 50;
	    $registros = $pdo->query("SELECT * FROM noticias_comentarios c, noticias n WHERE n.id=c.noticia_id AND n.evento='true' AND n.status='true' AND c.time>'{$time_month}'")->rowCount();
	    $pagina     = (isset ($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
	    $inicio     = ($quantidade * $pagina) - $quantidade;
	    $totalPagina = ceil($registros/$quantidade);
		$sql = $pdo->query("SELECT * FROM noticias_comentarios c, noticias n WHERE n.id=c.noticia_id AND n.evento='true' AND n.status='true' AND c.time>'{$time_month}' ORDER BY c.coment_id DESC LIMIT $inicio, $quantidade");
		if($sql->rowCount() == 0){
?>
	<tr><td colspan="5">Nenhum</td></tr>
<?php
	}else{
			while($row = $sql->fetch(PDO::FETCH_ASSOC)){
			$coment_row = $pdo->query("SELECT * FROM noticias_comentarios WHERE coment_id='{$row['coment_id']}'")->fetch(PDO::FETCH_ASSOC);
	?>
	<tr id="<?php echo $row['coment_id']; ?>">
		<td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['coment_id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
		<td><?php echo $row['titulo']; ?></td>
		<td><?php echo $coment_row['autor']; ?></td>
		<td><?php echo $row['comentario']; ?></td>
		<td><?php echo date('d/m/Y H:i',$coment_row['time']); ?></td>
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