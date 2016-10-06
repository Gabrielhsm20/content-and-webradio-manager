<?php
if(isset($_GET['formAjax']) && isset($_GET['formUrl'])){include '../php/config.php';include '../php/functions.php';if(Site::Modulo($_GET['formUrl']) > 0){
  // AJAX
    if($_GET['formAjax'] == 'destaques'){
        $usuario = htmlspecialchars($_POST['usuario']);
        $u_motivo = htmlspecialchars($_POST['u_motivo']);
        $membro = htmlspecialchars($_POST['membro']);
        $m_motivo = htmlspecialchars($_POST['m_motivo']);

        $sql = $pdo->prepare("UPDATE destaques SET usuario=:usuario, u_motivo=:u_motivo, membro=:membro, m_motivo=:m_motivo");
        $sql->bindParam(':usuario', $usuario);
        $sql->bindParam(':u_motivo', $u_motivo);
        $sql->bindParam(':membro', $membro);
        $sql->bindParam(':m_motivo', $m_motivo);
        $sql->execute();
        if($sql){
            echo 1;
        }
    }
  // FIM AJAX //
exit(); }else{ exit(); }}
?>
<?php
    $ver = $pdo->query("SELECT * FROM destaques")->fetch(PDO::FETCH_ASSOC);
?>
<form id="formPag" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="form" value="destaques" />
    <input type="hidden" name="back" value="false" />

    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Usuário:</p>
    <input type="text" name="usuario" value="<?php echo $ver['usuario']; ?>" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Motivo:</p>
    <input type="text" name="u_motivo" value="<?php echo $ver['u_motivo']; ?>" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Membro:</p>
    <input type="text" name="membro" value="<?php echo $ver['membro']; ?>" />
    <p><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;&nbsp;Motivo:</p>
    <input type="text" name="m_motivo" value="<?php echo $ver['m_motivo']; ?>" />
    <input type="submit" value="Salvar" />
</form>