<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'parceiros'){
        $quarto = htmlspecialchars($_POST['quarto']);
        $url = htmlspecialchars($_POST['url']);
        $dono = htmlspecialchars($_POST['dono']);

        if($quarto == '' || $url == '' || $dono == ''){
            echo 2;
        }else{
            $sql = $pdo->prepare("INSERT INTO quartos_parceiros(quarto, dono, link) VALUES(:quarto, :dono, :url)");
            $sql->bindParam(':quarto', $quarto);
            $sql->bindParam(':dono', $dono);
            $sql->bindParam(':url', $url);
            $sql->execute();
            if($sql){
                echo 1;
            }
        }
    }else if($_GET['formAjax'] == 'apagar'){
            $id = (int) $_POST['id'];
            $sql = $pdo->prepare("DELETE FROM quartos_parceiros WHERE id=:id");
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

    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Quarto:</p>
    <input type="text" name="quarto" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Dono:</p>
    <input type="text" name="dono" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Url:</p>
    <input type="text" name="url" />
    <input type="submit" value="Adicionar" />
</form>

<div class="table"><table>
  <tr>
    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
    <th>Quarto</th>
    <th>Dono</th>
    <th>Url</th>
  </tr>
<?php
    $sql = $pdo->query("SELECT * FROM quartos_parceiros ORDER BY id DESC");
    if($sql->rowCount() == 0){
?>
    <tr><td colspan="4">Nenhum</td></tr>
<?php
    }else{
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr id="<?php echo $row['id']; ?>">
    <td style="cursor: pointer" onclick="Registro.Apagar(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    <td><?php echo $row['quarto']; ?></td>
    <td><?php echo $row['dono']; ?></td>
    <td><a href="<?php echo $row['link'] ?>" target="_blank">Url</a></td>
  </tr>
<?php
        }
    }
?>
</table></div>