<?php
	if(isset($_SESSION['userLoginKP'])){ unset($_SESSION['userLoginKP']); }
	if(isset($_SESSION['usuarioKP'])){ unset($_SESSION['usuarioKP']); }
	if(isset($_SESSION['senhaKP'])){ unset($_SESSION['senhaKP']); }

	if(isset($_COOKIE['userLoginKP'])){ setcookie('userLoginKP', 'Error', time()-1, "/"); }
	if(isset($_COOKIE['usuarioKP'])){ setcookie('usuarioKP', 'Error', time()-1, "/"); }
	if(isset($_COOKIE['senhaKP'])){ setcookie('senhaKP', 'Error', time()-1, "/"); }

	header("Location:".$base."login");
	exit();
?>