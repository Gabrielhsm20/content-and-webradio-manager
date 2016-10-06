<?php
$visto = $pdo->query("UPDATE aa_notificacao SET visto='true' WHERE usuario='{$user_view['usuario']}'");
$sql_r = $pdo->query("SELECT * FROM aa_notificacao WHERE usuario='{$user_view['usuario']}' ORDER BY visto, id DESC");
$i = 0;
if($sql_r->rowCount() == 0){
?>
	<li>
		<span>Nenhuma notificação!</span>
	</li>
<?php
}else{
	while ($row = $sql_r->fetch(PDO::FETCH_ASSOC)) {
	$i++;
	?>
		<li>
		<span><?php echo $row['texto']; ?></span>
		<p style="text-align: right; font-size: 11px; opacity: 0.8;">Notficado <?php echo 'dia <b>'.date('d/m', $row['time']).'</b> ás <b>'.date('H:i', $row['time']).'</b>'; ?></p>
		</li>
	<?php
		if($sql_r->rowCount() > $i){
			echo '<div style="width: 90%; height: 1px; background-color: rgba(0,0,0,0.1); margin: 15px 0 15px 5%"></div>';
		}
	}
}
?>