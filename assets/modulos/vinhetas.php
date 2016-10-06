<div class="table"><table>
  <tr>
    <th>Nome</th>
    <th>Vinheta</th>
    <th>Download</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM aa_vinhetas ORDER BY id DESC");
	if($sql->rowCount() == 0){
?>
	<tr><td colspan="3">Nenhum</td></tr>
<?php
	}else{
		while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
   	<td><?php echo $row['nome']; ?></td>
    <td><audio controls src="assets/uploads/<?php echo $row['audio']; ?>"></audio></td>
    <th><a href="assets/uploads/<?php echo $row['audio'] ?>" download><i class="fa fa-download"></i></a></th>
  </tr>
<?php
		}
	}
?>
</table></div>