<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'canais'){
      $canal = htmlspecialchars($_POST['canal']);
      $diretorio = htmlspecialchars($_POST['diretorio']);
      $pai = (int) $_POST['pai'];
      $status = htmlspecialchars($_POST['status']);
      $ordem = $pdo->prepare("SELECT * FROM aa_canais WHERE pai=:pai ORDER BY ordem DESC LIMIT 1");
      $ordem->bindParam(':pai',$pai);
      $ordem->execute();
      $ordem = $ordem->fetch(PDO::FETCH_ASSOC);
      $ordem = $ordem['ordem'] + 1;

      if($canal == '' || $pai == '' || $status == ''){
          echo 2;
      }else{
        $sql = $pdo->prepare("INSERT INTO aa_canais(canal, diretorio, ordem, pai, status) VALUES(:canal, :diretorio, :ordem, :pai, :status)");
        $sql->bindParam(':canal', $canal);
        $sql->bindParam(':diretorio', $diretorio);
        $sql->bindParam(':ordem', $ordem);
        $sql->bindParam(':pai', $pai);
        $sql->bindParam(':status', $status);
        $sql->execute();
        if($sql){
          echo 1;
        }
      }
    }else if($_GET['formAjax'] == 'canaisEditar'){
      $canal = htmlspecialchars($_POST['canal']);
      $diretorio = htmlspecialchars($_POST['diretorio']);
      $pai = (int) $_POST['pai'];
      $ordem = (int) $_POST['ordem'];
      $status = htmlspecialchars($_POST['status']);
      $id = (int) $_POST['id'];
      if($id != ''){
        if($canal == '' || $status == ''){
          echo 2;
        }else{
          $sql = $pdo->prepare("UPDATE aa_canais SET canal=:canal, diretorio=:diretorio, pai=:pai, ordem=:ordem, status=:status WHERE canal_id=:id");
          $sql->bindParam(':canal', $canal);
          $sql->bindParam(':diretorio', $diretorio);
          $sql->bindParam(':ordem', $ordem);
          $sql->bindParam(':pai', $pai);
          $sql->bindParam(':status', $status);
          $sql->bindParam(':id', $id);
          $sql->execute();
          if($sql){
            echo 1;
          }
        }
      }
    }else if($_GET['formAjax'] == 'apagar'){
      $id = (int) $_POST['id'];
      $sql = $pdo->prepare("DELETE FROM aa_canais WHERE canal_id=:id");
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
    $sql = $pdo->prepare("SELECT * FROM aa_canais WHERE canal_id=:id");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
  <form id="formPag" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="form" value="canaisEditar" />
    <input type="hidden" name="back" value="true" />
    <input type="hidden" name="id" value="<?php echo $dados['canal_id']; ?>" />

    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Canal:</p>
    <input type="text" name="canal" value="<?php echo $dados['canal']; ?>" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Diretorio:</p>
    <input type="text" name="diretorio" value="<?php echo $dados['diretorio']; ?>" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Ordem:</p>
    <input type="text" name="ordem" value="<?php echo $dados['ordem']; ?>" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Pai:</p>
    <select name="pai">
      <option value="0" <?php if($dados['pai'] == '0'){ echo 'selected'; } ?>>Pai</option>
    <?php
      $sql_p = $pdo->query("SELECT * FROM aa_canais WHERE pai='0' AND canal_id!='{$row['canal_id']}' ORDER BY pai, ordem");
      while ($row = $sql_p->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <option value="<?php echo $row['canal_id']; ?>" <?php if($dados['pai'] == $row['canal_id']){ echo 'selected'; } ?>><?php echo $row['canal']; ?></option>
    <?php
      }
    ?>
    </select>
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Status:</p>
    <select name="status">
      <option value="true" <?php if($dados['status'] == 'true'){ echo 'selected'; } ?>>Ativo</option>
      <option value="false" <?php if($dados['status'] == 'false'){ echo 'selected'; } ?>>Inativo</option>
    </select>

    <input type="submit" value="Salvar" />
  </form>
<?php
  }else{
?>
   <form id="formPag" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="form" value="canais" />
    <input type="hidden" name="back" value="false" />

    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Canal:</p>
    <input type="text" name="canal" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Diretorio:</p>
    <input type="text" name="diretorio" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Pai:</p>
    <select name="pai">
      <option value="0">Pai</option>
    <?php
      $sql_p = $pdo->query("SELECT * FROM aa_canais WHERE pai='0' ORDER BY ordem");
      while ($row = $sql_p->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <option value="<?php echo $row['canal_id']; ?>"><?php echo $row['canal']; ?></option>
    <?php
      }
    ?>
    </select>
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Status:</p>
    <select name="status">
      <option value="true">Ativo</option>
      <option value="false">Inativo</option>
    </select>

    <input type="submit" value="Criar" />
  </form>

  <div class="table"><table>
    <tr>
      <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
      <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
      <th>Canal</th>
      <th>Pai</th>
      <th>Ordem</th>
      <th>Status</th>
    </tr>
  <?php
  	$sql = $pdo->query("SELECT * FROM aa_canais ORDER BY pai, ordem ASC");
    if($sql->rowCount() == 0){
?>
  <tr><td colspan="6">Nenhum</td></tr>
<?php
  }else{
  	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
      $pai = $pdo->query("SELECT * FROM aa_canais WHERE canal_id='{$row['pai']}'")->fetch(PDO::FETCH_ASSOC);
      if($pai['canal'] == ''){
        $pai = 'Pai';
      }else{
        $pai = $pai['canal'];
      }
  ?>
    <tr id="<?php echo $row['canal_id']; ?>">
      <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['canal_id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
      <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/editar/<?php echo $row['canal_id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
      <td><?php echo $row['canal']; ?></td>
      <td><?php echo $pai; ?></td>
      <td><?php echo $row['ordem']; ?></td>
      <td><?php echo $row['status']; ?></td>
    </tr>
  <?php
  	}
  }
  ?>
  </table></div>
<?php
  }
?>