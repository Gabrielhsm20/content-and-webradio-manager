<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'alerta'){
      $titulo = htmlspecialchars($_POST['titulo']);
      $texto = $_POST['texto'];
      if($titulo == '' || $texto == ''){
        echo 2;
      }else{
        $sql = $pdo->prepare("INSERT INTO alertas(titulo, texto, autor, time) VALUES(:titulo, :texto, :autor, :time)");
        $sql->bindParam(':titulo', $titulo);
        $sql->bindParam(':texto', $texto);
        $sql->bindParam(':autor', $user_view['usuario']);
        $sql->bindParam(':time', $time);
        $sql->execute();
        if($sql){
          echo 1;
        }
      }
    }
  // FIM AJAX //
exit(); }else{ exit(); }}
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="alerta" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Titulo:</p>
	<input type="text" name="titulo" />
	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Texto:</p>
	<textarea id="tiny" name="texto"></textarea>

	<input type="submit" style="margin-top: 10px" value="Enviar" />
</form>

<div class="table"><table>
  <tr>
    <th>Vis.</th>
    <th>Titulo</th>
    <th>Texto</th>
    <th>Autor</th>
    <th>Data</th>
  </tr>
<?php
	$sql = $pdo->query("SELECT * FROM alertas ORDER BY id DESC");
  if($sql->rowCount() == 0){
?>
  <tr><td colspan="5">Nenhum</td></tr>
<?php
  }else{
	 while($row = $sql->fetch(PDO::FETCH_ASSOC)){
?>
  <tr>
    <td><?php echo $pdo->query("SELECT * FROM alertas_visto WHERE alerta_id='{$row['id']}'")->rowCount(); ?></td>
    <td><?php echo $row['titulo']; ?></td>
    <td><?php echo $row['texto']; ?></td>
    <td><?php echo $row['autor']; ?></td>
    <td><?php echo date('d/m/Y H:i', $row['time']); ?></td>
  </tr>
<?php
    }
  }
?>
</table></div>