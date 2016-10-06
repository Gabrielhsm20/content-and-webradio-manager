<?php
	$sql = $pdo->query("SELECT * FROM aa_avisos ORDER BY id DESC");
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
<div class="aviso" id="aviso_<?php echo $row['id']; ?>">
	<div class="titulo"><?php echo $row['titulo']; ?></div>
	<div class="texto">Postado por <b><?php echo $row['autor']; ?></b> dia <b><?php echo date('d/m/Y', $row['time']); ?></b> ás <b><?php echo date('H:i', $row['time']); ?></b>.</div>
	<div class="texto"><?php echo $row['texto']; ?></div>
	<div class="buttons">
		<?php
			$verifica_visto = $pdo->query("SELECT * FROM aa_avisos_visto WHERE aviso_id='{$row['id']}' AND usuario='{$user_view['usuario']}'")->rowCount();
			if($verifica_visto == 0){
		?>
			<div class="button" onclick="User.VerAviso('<?php echo $row['id']; ?>', '<?php echo $user_view['usuario']; ?>')">Marcar como lido</div>
		<?php
			}
		?>
		<div class="button ver_leitores" <?php if($verifica_visto > 0){ echo 'style="width: 100%"'; } ?>>Ver leitores</div>
		<div class="leitores">
			<div class="arrow"></div>
			<?php
				$sql_v = $pdo->query("SELECT * FROM aa_avisos_visto a, aa_usuarios u WHERE a.usuario=u.usuario AND u.status='true' AND a.aviso_id='{$row['id']}'");
				if($sql_v->rowCount() == 0){
					echo 'Nenhuma visualização!';
				}else{
					while($row_v = $sql_v->fetch(PDO::FETCH_ASSOC)){
			?>
					<div class="leitor theme"><?php echo $row_v['usuario']; ?></div>
			<?php
					}
				}
			?>
		</div>
	</div>
</div>
<?php
	}
?>
