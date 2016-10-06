<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'parceiros'){
        $nome = htmlspecialchars($_POST['nome']);
        $url = htmlspecialchars($_POST['url']);
        $banner = htmlspecialchars($_POST['banner']);

        if($nome == '' || $url == '' || $banner == ''){
            echo 2;
        }else{
            $sql = $pdo->prepare("INSERT INTO parceiros(nome, banner, url) VALUES(:nome, :banner, :url)");
            $sql->bindParam(':nome', $nome);
            $sql->bindParam(':banner', $banner);
            $sql->bindParam(':url', $url);
            $sql->execute();
            if($sql){
                echo 1;
            }
        }
    }else if($_GET['formAjax'] == 'apagar'){
            $id = (int) $_POST['id'];
            $sql = $pdo->prepare("DELETE FROM parceiros WHERE id=:id");
            $sql->bindParam(':id', $id);
            $sql->execute();
            if($sql){
                echo 1;
            }
        }
  // FIM AJAX //
exit(); }else{ exit(); }}
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="form" value="parceiros" />
    <input type="hidden" name="back" value="false" />

    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Nome:</p>
    <input type="text" name="nome" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Url:</p>
    <input type="text" name="url" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Banner:</p>
    <input type="text" name="banner" />
    <input type="submit" value="Adicionar" />
</form>

<div class="table"><table>
  <tr id="<?php echo $row['id']; ?>">
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th>Nome</th>
    <th>Banner</th>
  </tr>
<?php
    $sql = $pdo->query("SELECT * FROM parceiros ORDER BY id DESC");
    if($sql->rowCount() == 0){
?>
    <tr><td colspan="3">Nenhum</td></tr>
<?php
    }else{
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr>
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td><?php echo $row['nome']; ?></td>
    <td><img src="<?php echo $row['banner']; ?>" /></td>
    <td><a href="<?php echo $row['url'] ?>" target="_blank">Url</a></td>
  </tr>
<?php
        }
    }
?>
</table></div>