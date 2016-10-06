<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
	if($_GET['formAjax'] == 'temaPainel'){
		$cor = htmlspecialchars($_POST['cor']);
		if($cor == ''){
			echo 2;
		}else{
			$sql = $pdo->prepare("UPDATE aa_ktema SET tema=:tema");
			$sql->bindParam(':tema', $cor);
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
	<input type="hidden" name="form" value="temaPainel" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Escolha uma cor:</p>
	<input class="jscolor {styleElement:'styleInput', onFineChange:'Color.Update(this)'}" name="cor" value="<?php echo $tema_ver['tema']; ?>" readonly />

	<div class="button theme" onclick="Color.Original()">Original</div>
	<input type="submit" value="Salvar">
</form>