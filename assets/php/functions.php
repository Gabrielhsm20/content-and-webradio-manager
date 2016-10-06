<?php
setlocale(LC_ALL, 'pt_BR.UTF8');

class Site {
	public static function Modulo($url){
		require 'config.php';
		$modulo_config = $pdo->query("SELECT * FROM aa_usuarios_rel r, aa_canais c, aa_permissao p WHERE r.user_id='{$user_view['id']}' AND r.cargo_id = p.cargo_id AND p.canal_id = c.canal_id AND c.status = 'true' AND c.diretorio='{$url}' AND p.canal_id = c.canal_id GROUP BY p.canal_id");
		if($modulo_config->rowCount() > 0){
			$retorno = 1;
		}else{
			$retorno = 0;
		}
		return $retorno;
	}

	public static function Url($str, $replace=array(), $delimiter='-') {
	    if( !empty($replace) ) { $str = str_replace((array)$replace, ' ', $str); }
	    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	    $clean = strtolower(trim($clean, '-'));
	    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	    return $clean;
	}
}
?>