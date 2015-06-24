<!DOCTYPE html>
<html>
<?php
session_start();

if (isset($_SESSION["autenticado"])) {
	header("location:app.php");
}
?>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>CryptoShare</title>
	<link rel='stylesheet' type='text/css' href='./css/style_index.css'/>
	<link rel='stylesheet' type='text/css' href='./css/buttons.css'/>
	<link rel='shortcut icon' href='img/favicon.ico' type='image/ico'/>
</head>
<body>
		<h1 class='titulo'>CryptoShare</h1>
		<form action='php/form/acceso.php' method='POST' class='acceso'>
				<fieldset>
						<table>
								<tr>
										<td><input type='text' name='usuario' placeholder='Usuario' required></td>
								</tr>
								<tr>
										<td><input type='password' name='contrasena' placeholder='Contraseña' required></td>
								</tr>
								<tr>
										<td><input type='Submit' value='Acceder' class="boton"></td>
								</tr>
						</table>
				</fieldset>
		</form>
<?php
	if (isset($_GET["error_acceso"]))
		if ($_GET["error_acceso"]=="si") echo "<h2 align='center' class='titulo'>Datos incorrectos, revisa tus datos e intenta acceder de nuevo</h2>";
?>
</body>
</html>