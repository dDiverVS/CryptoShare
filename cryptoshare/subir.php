<!DOCTYPE html>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title>CryptoShare</title>
<link rel='shortcut icon' href='img/favicon.ico' type='image/ico' />
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/buttons.css"/>
<link rel="stylesheet" type="text/css" href="css/dropzone.css"/>
<script type="text/javascript" src="js/dropzone.js"></script>
</head>
<body>
<?php
include 'seg/seguridad.php';
include 'php/menu_sup.php';
include 'php/menu_lat.php';
?>
<div class="contenido">
	<form action="php/form/upload.php" class="dropzone">
	  <div class="fallback">
	    <input name="file" type="file"/>
	  </div>
	</form>
</div>
</body>
</html>
