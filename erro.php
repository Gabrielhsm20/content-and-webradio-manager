<?php
	include 'assets/php/config.php';
	if($conectado){ include 'assets/php/logout.php'; exit(); }
?>
<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo $base; ?>" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta name="author" content="Gabriel Henrique" />
	<title>Erro - KPanel Content Manager</title>
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="assets/css/all.css" />
	<style> .theme, input[type="submit"], .pin .button{ background-color: #293A4A; } </style>
</head>
<body class="theme">
	<div class="panel login">
		<div class="center">
			<div class="logo" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: auto"></div>
		</div>
	</div>
</body>
</html>