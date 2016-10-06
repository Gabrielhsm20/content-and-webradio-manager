<div class="table"><table>
  <tr>
    <th>Usuário</th>
    <th>Codigo</th>
    <th>Data</th>
  </tr>
<?php
$quantidade = 50;
$registros = $pdo->query("SELECT * FROM moedas_usadas WHERE time>'{$time_month}'")->rowCount();
$pagina     = (isset ($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
$inicio     = ($quantidade * $pagina) - $quantidade;
$totalPagina = ceil($registros/$quantidade);
$sql = $pdo->query("SELECT * FROM moedas_usadas WHERE time>'{$time_month}' ORDER BY id DESC LIMIT $inicio, $quantidade");
if($sql->rowCount() == 0){
?>
  <tr><td colspan="3">Nenhum</td></tr>
<?php
}else{
  while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr>
    <td><?php echo $row['usuario']; ?></td>
    <td><?php echo $row['codigo']; ?></td>
    <td><?php echo date('d/m/Y H:i', $row['time']); ?></td>
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