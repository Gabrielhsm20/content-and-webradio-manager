<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'quarto'){
    	$url = htmlspecialchars($_POST['url']);
		$sql = $pdo->prepare("UPDATE aa_quarto_dj SET url=:url");
		$sql->bindParam(':url', $url);
		$sql->execute();
		if($sql){
			echo 1;
		}
    }
  // FIM AJAX //
exit(); }else{ exit(); }}
?>
<?php
	$dados = $pdo->query("SELECT * FROM aa_quarto_dj")->fetch(PDO::FETCH_ASSOC);
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="form" value="quarto" />
	<input type="hidden" name="back" value="false" />

	<p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Url:</p>
	<input type="text" name="url" value="<?php echo $dados['url']; ?>" />

	<input type="submit" value="Salvar" />
</form>