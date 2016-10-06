<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'membros'){
      $usuario = htmlspecialchars($_POST['usuario']);
      $senha = $_POST['senha'];
      $pin = htmlspecialchars($_POST['pin']);
      $status = htmlspecialchars($_POST['status']);

      $verifica = $pdo->prepare("SELECT * FROM aa_usuarios WHERE usuario=:usuario");
      $verifica->bindParam(':usuario', $usuario);
      $verifica->execute();
      if($usuario == '' || $senha == '' || $pin == '' || $_POST['cargo'] == ''){
        echo 2;
      }else if($verifica->rowCount() > 0){
        echo 5;
      }else{
        $i = 0;
        foreach ($_POST['cargo'] as $key => $cargo) {
          $ordem = $pdo->query("SELECT * FROM aa_cargos WHERE cargo_id='{$cargo}'")->fetch(PDO::FETCH_ASSOC);
          if($ordem['ordem'] >= $user_cargo['ordem']){
                      if($i == 0){
                        $senha = substr(md5($_POST['senha']), 4);
              $notificacao = $pdo->query("INSERT INTO aa_notificacao(usuario, texto, visto, time) VALUES('{$usuario}', 'Bem-vindo!', 'false', '{$time}')");
              $inserir = $pdo->prepare("INSERT INTO aa_usuarios(usuario, senha, pin, status, turno, programa, skype, twitter, facebook, advertencia, banido, motivo, ultimo_time, ultimo_ip, online, online_time) VALUES(:usuario, :senha, :pin, :status, 'Tarde', 'Nenhum', 'Nenhum', 'Nenhum', 'Nenhum', '0', 'false', '', '0', '0', 'false', '0')");
                        $inserir->bindParam(':usuario', $usuario);
                        $inserir->bindParam(':senha', $senha);
                        $inserir->bindParam(':pin', $pin);
                        $inserir->bindParam(':status', $status);
                        $inserir->execute();
            }
                      $usuario_c = $pdo->prepare("SELECT * FROM aa_usuarios WHERE usuario=:usuario");
            $usuario_c->bindParam(':usuario', $usuario);
            $usuario_c->execute();
            $usuario_view = $usuario_c->fetch(PDO::FETCH_ASSOC);
                      $sql = $pdo->prepare("INSERT INTO aa_usuarios_rel (user_id, cargo_id) VALUES(:user_id, :cargo_id)");
                      $sql->bindParam(':user_id', $usuario_view['id']);
                      $sql->bindParam(':cargo_id', $cargo);
                      $sql->execute();
          }
          $i++;
        }
        if($sql){
                  echo 1;
                }
      }
    }else if($_GET['formAjax'] == 'membrosEditar'){
      $senha = substr(md5($_POST['senha']), 4);
      $pin = htmlspecialchars($_POST['pin']);
      $status = htmlspecialchars($_POST['status']);
      $advertencia = htmlspecialchars($_POST['advertencia']);
      $banido = htmlspecialchars($_POST['banido']);
      $motivo = htmlspecialchars($_POST['motivo']);
      $motivo_ban = htmlspecialchars($_POST['motivo_ban']);
      $id = (int) $_POST['id'];

      if($id != '' && $id != '1'){
        $usuario_v = $pdo->prepare("SELECT * FROM aa_usuarios WHERE id=:id");
        $usuario_v->bindParam(':id', $id);
        $usuario_v->execute();
        $usuario_view = $usuario_v->fetch(PDO::FETCH_ASSOC);
        $usuario_cargo = $pdo->query("SELECT * FROM aa_usuarios_rel r, aa_cargos c WHERE r.cargo_id=c.cargo_id AND r.user_id='{$usuario_view['id']}' ORDER BY c.ordem ASC")->fetch(PDO::FETCH_ASSOC);
        if($_POST['senha'] == ''){ $senha = $usuario_view['senha']; }
        if($pin == '' || $_POST['cargo'] == ''){
          echo 2;
        }else if($usuario_cargo['ordem'] >= $user_cargo['ordem']){
          $i = 0;
          foreach ($_POST['cargo'] as $key => $cargo) {
            $ordem = $pdo->query("SELECT * FROM aa_cargos WHERE cargo_id='{$cargo}'")->fetch(PDO::FETCH_ASSOC);
            if($ordem['ordem'] >= $user_cargo['ordem']){
                        if($i == 0){
                if($advertencia > $usuario_view['advertencia'] && $motivo != ''){
                  $motivo = 'Você foi advertido! Motivo: '.$motivo;
                  $adv_inserir = $pdo->prepare("INSERT INTO aa_notificacao(usuario, texto, visto, time) VALUES(:usuario, :texto, 'false', :time)");
                              $adv_inserir->bindParam(':usuario', $usuario_view['usuario']);
                              $adv_inserir->bindParam(':texto', $motivo);
                              $adv_inserir->bindParam(':time', $time);
                              $adv_inserir->execute();
                }
                if($banido == 'false'){ $motivo_ban = ''; }
                $update = $pdo->prepare("UPDATE aa_usuarios SET senha=:senha, pin=:pin, status=:status, advertencia=:advertencia, motivo=:motivo, banido=:banido WHERE id=:id");
                          $update->bindParam(':senha', $senha);
                          $update->bindParam(':pin', $pin);
                          $update->bindParam(':status', $status);
                          $update->bindParam(':advertencia', $advertencia);
                          $update->bindParam(':motivo', $motivo_ban);
                          $update->bindParam(':banido', $banido);
                          $update->bindParam(':id', $id);
                          $update->execute();
                          $each_cargos = $pdo->prepare("DELETE FROM aa_usuarios_rel WHERE user_id=:id");
                          $each_cargos->bindParam(':id', $id);
                          $each_cargos->execute();
              }
                        $sql = $pdo->prepare("INSERT INTO aa_usuarios_rel (user_id, cargo_id) VALUES(:user_id, :cargo_id)");
                        $sql->bindParam(':user_id', $usuario_view['id']);
                        $sql->bindParam(':cargo_id', $cargo);
                        $sql->execute();
            }
            $i++;
          }
          if($sql){
            echo 1;
          }
        }
      }
    }else if($_GET['formAjax'] == 'apagar'){
      $id = (int) $_POST['id'];
      if($id > 1){
        $usuario_v = $pdo->prepare("SELECT * FROM aa_usuarios WHERE id=:id");
        $usuario_v->bindParam(':id', $id);
        $usuario_v->execute();
        $usuario_view = $usuario_v->fetch(PDO::FETCH_ASSOC);
        $usuario_cargo = $pdo->query("SELECT * FROM aa_usuarios_rel r, aa_cargos c WHERE r.cargo_id=c.cargo_id AND r.user_id='{$usuario_view['id']}' ORDER BY c.ordem ASC")->fetch(PDO::FETCH_ASSOC);
        if($usuario_cargo['ordem'] >= $user_cargo['ordem']){
          $sql = $pdo->prepare("DELETE FROM aa_usuarios WHERE id=:id");
          $sql_r = $pdo->prepare("DELETE FROM aa_usuarios_rel WHERE user_id=:id");
          $sql_r->bindParam(':id', $id);
          $sql_r->execute();
          $sql_n = $pdo->prepare("DELETE FROM aa_notificacao WHERE usuario=:usuario");
          $sql_n->bindParam(':usuario', $usuario_view['usuario']);
          $sql_n->execute();
        }
        $sql->bindParam(':id', $id);
        $sql->execute();
        if($sql){
          echo 1;
        }
      }
    }
  // FIM AJAX //
exit(); }else{ exit(); }}
?>
<?php
  $user_cargo = $pdo->query("SELECT * FROM aa_usuarios_rel r, aa_cargos c WHERE r.cargo_id=c.cargo_id AND r.user_id='{$user_view['id']}' ORDER BY c.ordem ASC")->fetch(PDO::FETCH_ASSOC);
  if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){
    $id = (int) $_GET['id'];
    $sql = $pdo->prepare("SELECT * FROM aa_usuarios WHERE id=:id");
    $sql->bindParam(':id', $id);
    $sql->execute();
    $dados = $sql->fetch(PDO::FETCH_ASSOC);
?>
 <form id="formPag" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="form" value="membrosEditar" />
    <input type="hidden" name="back" value="true" />
    <input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />

    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário:</p>
    <input type="text" name="usuario" value="<?php echo $dados['usuario']; ?>" readonly />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Senha: (Deixe em branco caso não queira mudar)</p>
    <input type="password" name="senha" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;PIN:</p>
    <input type="number" name="pin" value="<?php echo $dados['pin']; ?>" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Status:</p>
    <select name="status">
      <option value="true" <?php if($dados['status'] == 'true'){ echo 'selected'; } ?>>Ativo</option>
      <option value="false" <?php if($dados['status'] == 'false'){ echo 'selected'; } ?>>Inativo</option>
    </select>
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Cargo:</p>
    <div style="width: 100%; height: auto; float: left">
<?php
    $sql = $pdo->query("SELECT * FROM aa_cargos WHERE ordem >= '{$user_cargo['ordem']}'");
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
      $sql_c = $pdo->query("SELECT * FROM aa_usuarios_rel r, aa_cargos c WHERE r.cargo_id=c.cargo_id AND r.user_id='".$id."' ORDER BY c.ordem ASC");
?>
    <div class="cargo"><input type="checkbox" name="cargo[<?php echo $row['cargo_id']; ?>]" value="<?php echo $row['cargo_id']; ?>" <?php while($row_c = $sql_c->fetch(PDO::FETCH_ASSOC)){ if($row_c['cargo_id'] == $row['cargo_id']){ echo 'checked'; } }  ?>>&nbsp;&nbsp;<span><?php echo $row['cargo']; ?></span></div>
<?php
    }
?>
    </div>
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;IP:</p>
    <input type="text" name="ip" value="<?php echo $dados['ultimo_ip']; ?>" readonly />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Advertências:</p>
    <select name="advertencia">
        <option value="0" <?php if($dados['advertencia'] == '0'){ echo 'selected'; } ?>>0</option>
        <option value="1" <?php if($dados['advertencia'] == '1'){ echo 'selected'; } ?>>1</option>
        <option value="2" <?php if($dados['advertencia'] == '2'){ echo 'selected'; } ?>>2</option>
        <option value="3" <?php if($dados['advertencia'] == '3'){ echo 'selected'; } ?>>3</option>
        <option value="4" <?php if($dados['advertencia'] == '4'){ echo 'selected'; } ?>>4</option>
    </select>
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Motivo da advertência: (Deixe em branco caso não tenha acrescentado)</p>
    <input type="text" name="motivo" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Banido:</p>
    <select name="banido">
        <option value="true" <?php if($dados['banido'] == 'true'){ echo 'selected'; } ?>>Sim</option>
        <option value="false" <?php if($dados['banido'] == 'false'){ echo 'selected'; } ?>>Não</option>
    </select>
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Motivo do Banimento: (Deixe em branco caso não tenha sido banido)</p>
    <input type="text" name="motivo_ban" value="<?php echo $dados['motivo']; ?>" />

    <input type="submit" value="Salvar" />
  </form>
<?php
  }else{
?>
   <form id="formPag" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="form" value="membros" />
    <input type="hidden" name="back" value="false" />

    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário:</p>
    <input type="text" name="usuario" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Senha:</p>
    <input type="password" name="senha" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;PIN:</p>
    <input type="number" name="pin" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Status:</p>
    <select name="status">
      <option value="true">Ativo</option>
      <option value="false">Inativo</option>
    </select>
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Cargo:</p>
<?php
    $sql = $pdo->query("SELECT * FROM aa_cargos WHERE ordem >= '{$user_cargo['ordem']}'");
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
    <div class="cargo"><input type="checkbox" name="cargo[<?php echo $row['cargo_id']; ?>]" value="<?php echo $row['cargo_id']; ?>">&nbsp;&nbsp;<span><?php echo $row['cargo']; ?></span></div>
<?php
    }
?>

    <input type="submit" style="margin-top: 10px" value="Criar" />
  </form>

  <div class="table"><table>
    <tr>
      <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
      <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
      <th>Usuário</th>
      <th>Cargo</th>
      <th>Último login</th>
      <th>Status</th>
    </tr>
  <?php
  	$sql = $pdo->query("SELECT * FROM aa_usuarios ORDER BY id ASC");
  	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
      $sql_cargo = $pdo->query("SELECT * FROM aa_usuarios_rel r, aa_cargos c WHERE r.cargo_id=c.cargo_id AND r.user_id='{$row['id']}' ORDER BY c.ordem ASC");
      $row_cargo = $pdo->query("SELECT * FROM aa_usuarios_rel r, aa_cargos c WHERE r.cargo_id=c.cargo_id AND r.user_id='{$row['id']}' ORDER BY c.ordem ASC")->fetch(PDO::FETCH_ASSOC);
  ?>
    <tr id="<?php echo $row['id']; ?>">
      <td <?php if($row_cargo['ordem'] >= $user_cargo['ordem'] && $row['id'] > 1){ echo 'style="cursor: pointer" onclick="Registro.Apagar('.$row['id'].')"'; }else{ echo 'style="opacity: 0.5;"'; } ?>><i class="fa fa-trash-o" aria-hidden="true"></i></td>
      <td><a <?php if($row_cargo['ordem'] >= $user_cargo['ordem'] && $row['id'] > 1){ echo 'href="pagina/'.$url.'/editar/'.$row['id'].'" style="cursor: pointer"'; }else{ echo 'style="opacity: 0.5;"'; } ?>><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
      <td><?php echo $row['usuario']; ?></td>
      <td><?php while($row_cargo = $sql_cargo->fetch(PDO::FETCH_ASSOC)){ echo $row_cargo['cargo'].'<br>'; } ?></td>
      <td><?php if($row['ultimo_time'] > 0){ echo date('d/m/Y H:i', $row['ultimo_time']); }else{ echo 'Nunca logou!'; } ?></td>
      <td><?php if($row['status'] == 'true'){ echo 'Ativo'; }else{ echo 'Inativo'; } ?></td>
    </tr>
  <?php
  	}
  ?>
  </table></div>
<?php
  }
?>