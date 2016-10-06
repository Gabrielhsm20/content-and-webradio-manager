<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'tickets'){
      $resp = htmlspecialchars($_POST['texto']);
      $status = htmlspecialchars($_POST['status']);
      $id = (int) $_POST['id'];
      if($id != ''){
        if($status == ''){
          echo 2;
        }else{
          if($resp != ''){
            $inserir = $pdo->prepare("INSERT INTO aa_tickets_resp(ticket_id, autor, texto, time) VALUES(:id, :autor, :texto, :time)");
            $inserir->bindParam(':id',$id);
            $inserir->bindParam(':autor', $user_view['usuario']);
            $inserir->bindParam(':texto', $resp);
            $inserir->bindParam(':time', $time);
            $inserir->execute();
          }
          $update = $pdo->prepare("UPDATE aa_tickets SET status=:status WHERE id=:id");
          $update->bindParam(':status', $status);
          $update->bindParam(':id', $id);
          $update->execute();
          if($update){
            echo 1;
          }
        }
      }
    }
  // FIM AJAX //
exit(); }else{ exit(); }}
?>
<?php
if(isset($_GET['tipo']) && $_GET['tipo'] == 'acompanhar'){
    $id = (int) $_GET['id'];
    $sql = $pdo->prepare("SELECT * FROM aa_tickets WHERE id=:id");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off" >
  <input type="hidden" name="form" value="tickets" />
  <input type="hidden" name="back" value="true" />
  <input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

  <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Assunto:</p>
  <input type="text" value="<?php echo $dados['assunto']; ?>" readonly />
  <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Autor:</p>
  <input type="text" value="<?php echo $dados['autor']; ?>" readonly />
  <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Status:</p>
  <select name="status">
    <option value="true" <?php if($dados['status'] == 'true'){ echo 'selected'; } ?>>Aberto</option>
    <option value="answ" <?php if($dados['status'] == 'answ'){ echo 'selected'; } ?>>Respondido</option>
    <option value="sorted" <?php if($dados['status'] == 'sorted'){ echo 'selected'; } ?>>Resolvido</option>
    <option value="false" <?php if($dados['status'] == 'false'){ echo 'selected'; } ?>>Inativo</option>
  </select>
  <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Texto:</p>
  <p><?php echo $dados['mensagem']; ?></p>
  <div style="width: 90%; height: 1px; background-color: rgba(0,0,0,0.1); margin: 15px 0 15px 5%"></div>
  <?php
  $sql_r = $pdo->query("SELECT * FROM aa_tickets_resp WHERE ticket_id='{$dados['id']}' ORDER BY id ASC");
  $i = 0;
  while ($row = $sql_r->fetch(PDO::FETCH_ASSOC)) {
    $i++;
  ?>
  <li>
    <span><?php echo $row['texto']; ?></span>
    <p style="text-align: right; font-size: 11px; opacity: 0.8;">Resposta por <?php echo '<b>'.$row['autor'].'</b> dia <b>'.date('d/m', $row['time']).'</b> ás '.date('H:i', $row['time']); ?></p>
  </li>
  <?php
    if($sql_r->rowCount() > $i){
      echo '<div style="width: 90%; height: 1px; background-color: rgba(0,0,0,0.1); margin: 15px 0 15px 5%"></div>';
    }
  }
  ?>

  <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Responder:</p>
  <textarea id="tiny" name="texto" style="margin-top: 15px"></textarea>

  <input type="submit" style="margin-top: 10px" value="Responder/Salvar" />
</form>
<?php
}else{
?>
  <div class="table"><table>
    <tr>
      <th><i class="fa fa-comments" aria-hidden="true"></i></th>
      <th>Autor</th>
      <th>Assunto</th>
      <th>Status</th>
      <th>Data</th>
    </tr>
  <?php
  	$sql = $pdo->query("SELECT * FROM aa_tickets ORDER BY id DESC");
  	if($sql->rowCount() == 0){
?>
  <tr><td colspan="5">Nenhum</td></tr>
<?php
  }else{
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
  ?>
    <tr <?php if($row['status'] != 'true'){ echo 'style="opacity: 0.5"'; } ?>>
     <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/acompanhar/<?php echo $row['id']; ?>"><i class="fa fa-comments" aria-hidden="true"></i></a></td>
      <td><?php echo $row['autor']; ?></td>
      <td><?php echo $row['assunto']; ?></td>
      <td><?php if($row['status'] == 'true'){ echo 'Aberto'; }else if($row['status'] == 'answ'){ echo 'Respondido'; }else if($row['status'] == 'sorted'){ echo 'Resolvido'; }else if($row['status'] == 'false'){ echo 'Inativo'; } ?></td>
      <td><?php echo date('d/m/Y - H:i', $row['time']); ?></td>
    </tr>
  <?php
  	}
  }
  ?>
  </table></div>
<?php
}
?>