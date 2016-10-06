<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
	if($_GET['formAjax'] == 'marcar'){
    	$id = (int) $_POST['id'];
    	$sql = $pdo->prepare("UPDATE aa_horarios SET user_id='{$user_view['id']}', fixo='false' WHERE id=:id");
    	$sql->bindParam(':id',$id);
    	$sql->execute();
    	if($sql){
			echo 1;
		}
    }
  // FIM AJAX //
exit(); }else{ exit(); }}
?>
<?php
	$number_today = date('N', time());
	if(isset($_GET['dia'])){
		$number_today = (int) $_GET['dia'];
	}
?>

<div class="dias">
	<a href="pagina/<?php echo $url; ?>/dia/1"><button <?php if($number_today == 1){ echo 'style="opacity: 0.8; cursor: default"'; } ?>>Segunda-Feira</button></a>
	<a href="pagina/<?php echo $url; ?>/dia/2"><button <?php if($number_today == 2){ echo 'style="opacity: 0.8; cursor: default"'; } ?>>Terça-Feira</button></a>
	<a href="pagina/<?php echo $url; ?>/dia/3"><button <?php if($number_today == 3){ echo 'style="opacity: 0.8; cursor: default"'; } ?>>Quarta-Feira</button></a>
	<a href="pagina/<?php echo $url; ?>/dia/4"><button <?php if($number_today == 4){ echo 'style="opacity: 0.8; cursor: default"'; } ?>>Quinta-Feira</button></a>
	<a href="pagina/<?php echo $url; ?>/dia/5"><button <?php if($number_today == 5){ echo 'style="opacity: 0.8; cursor: default"'; } ?>>Sexta-Feira</button></a>
	<a href="pagina/<?php echo $url; ?>/dia/6"><button <?php if($number_today == 6){ echo 'style="opacity: 0.8; cursor: default"'; } ?>>Sábado</button></a>
	<a href="pagina/<?php echo $url; ?>/dia/7"><button <?php if($number_today == 7){ echo 'style="opacity: 0.8; cursor: default"'; } ?>>Domingo</button></a>
</div>
<table class="horarios">
	<tr>
		<th>Horário</th>
		<th>Locutor</th>
		<th>Marcar</th>
	</tr>
	<?php
		$sql = $pdo->query("SELECT * FROM aa_horarios WHERE dia='{$number_today}'");
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
			$locutor = $pdo->query("SELECT * FROM aa_usuarios WHERE id='{$row['user_id']}'")->fetch(PDO::FETCH_ASSOC);
			$locutor = $locutor['usuario'];

			if($row['user_id'] == 0){ $locutor = 'AutoDJ'; }

			$horario = $row['hora'];
			$termino = $horario + 1;
			if(strlen($horario) == 1){ $horario = '0'.$horario.':00'; }else{ $horario = $horario.':00'; }
			if(strlen($termino) == 1){ $termino = '0'.$termino.':00'; }else{ $termino = $termino.':00'; }
	?>
	<tr id="<?php echo $row['id']; ?>">
		<td><?php echo $horario.' ás '.$termino; ?></td>
		<td><?php echo $locutor; ?></td>
		<td><button class="marc" <?php if($row['user_id'] != 0){ echo 'style="opacity: 0.8; cursor: default"'; }else{ echo 'onclick="Registro.Apagar(\''.$row['id'].'\',\'marcar\')"'; } ?>><i class="fa fa-tags" aria-hidden="true"></i></button></td>
	</tr>
	<?php
		}
	?>
</table>