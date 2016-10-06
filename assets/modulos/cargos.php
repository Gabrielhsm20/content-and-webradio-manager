<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'cargos'){
      $cargo = htmlspecialchars($_POST['cargo']);
      $imagem = $_FILES['imagem'];
      $ordem = (int) $_POST['ordem'];
      $status = htmlspecialchars($_POST['status']);
      if($cargo == '' || $ordem == '' || $status == ''){
          echo 2;
      }else{
        if($imagem['tmp_name']){
          preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
          $imagem_name = 'icone-cargo-'.md5(uniqid(time())) . "." . $ext[1];
          $caminho_imagem = "../uploads/".$imagem_name;
          move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
        }else{
          $imagem_name = 'Null';
        }
        $sql = $pdo->prepare("INSERT INTO aa_cargos(cargo, icone, ordem, status) VALUES(:cargo, :icone, :ordem, :status)");
        $sql->bindParam(':cargo', $cargo);
        $sql->bindParam(':icone', $imagem_name);
        $sql->bindParam(':ordem', $ordem);
        $sql->bindParam(':status', $status);
        $sql->execute();
        if($sql){
          echo 1;
        }
      }
    }else if($_GET['formAjax'] == 'cargosEditar'){
      $cargo = htmlspecialchars($_POST['cargo']);
      $imagem = $_FILES['imagem'];
      $ordem = (int) $_POST['ordem'];
      $status = htmlspecialchars($_POST['status']);
      $id = (int) $_POST['id'];
      $cargo_v = $pdo->prepare("SELECT * FROM aa_cargos WHERE cargo_id=:id");
      $cargo_v->bindParam(':id', $id);
      $cargo_v->execute();
      $cargo_view = $cargo_v->fetch(PDO::FETCH_ASSOC);
      if($id != ''){
        if($cargo == '' || $ordem == '' || $status == ''){
          echo 2;
        }else{
          if($imagem['tmp_name'] != ''){
            if(@!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])){
              echo 4;
            }else{
              $diretorio = '../uploads/';
              if(file_exists($diretorio.$cargo_view['icone'])){
                unlink($diretorio.$cargo_view['icone']);
              }
                  preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
                  $imagem_name = 'icone-cargo-'.md5(uniqid(time())) . "." . $ext[1];
                  $caminho_imagem = $diretorio.$imagem_name;
                  move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
            }
          }else{
            $imagem_name = $cargo_view['icone'];
          }
          $sql = $pdo->prepare("UPDATE aa_cargos SET cargo=:cargo, icone=:icone, ordem=:ordem, status=:status WHERE cargo_id=:id");
          $sql->bindParam(':cargo', $cargo);
          $sql->bindParam(':icone', $imagem_name);
          $sql->bindParam(':ordem', $ordem);
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
      $sql = $pdo->prepare("DELETE FROM aa_cargos WHERE cargo_id=:id");
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
    $sql = $pdo->prepare("SELECT * FROM aa_cargos WHERE cargo_id=:id");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
  <form id="formPag" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="form" value="cargosEditar" />
    <input type="hidden" name="back" value="true" />
    <input type="hidden" name="id" value="<?php echo $dados['cargo_id']; ?>" />

    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Cargo:</p>
    <input type="text" name="cargo" value="<?php echo $dados['cargo']; ?>" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Atual Ícone:</p>
    <img src="assets/uploads/<?php echo $dados['icone']; ?>" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione o ícone: (Deixe em branco caso não queira mudar)</p>
    <input type="file" accept="image/*" name="imagem" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Ordem:</p>
    <input type="number" name="ordem" value="<?php echo $dados['ordem']; ?>" />
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
    <input type="hidden" name="form" value="cargos" />
    <input type="hidden" name="back" value="false" />

    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Cargo:</p>
    <input type="text" name="cargo" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Selecione o ícone: (Deixe em branco caso não tenha ícone)</p>
    <input type="file" accept="image/*" name="imagem" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Ordem:</p>
    <input type="number" name="ordem" />
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
      <th>Cargo</th>
      <th>Ícone</th>
      <th>Ordem</th>
      <th>Status</th>
    </tr>
  <?php
    $sql = $pdo->query("SELECT * FROM aa_cargos ORDER BY ordem ASC");
    if($sql->rowCount() == 0){
?>
  <tr><td colspan="5">Nenhum</td></tr>
<?php
  }else{
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
  ?>
    <tr id="<?php echo $row['cargo_id']; ?>">
      <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['cargo_id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
      <td style="cursor: pointer"><a href="pagina/<?php echo $url; ?>/editar/<?php echo $row['cargo_id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
      <td><?php echo $row['cargo']; ?></td>
      <td><img src="assets/uploads/<?php echo $row['icone']; ?>" /></td>
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