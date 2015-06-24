<!DOCTYPE html>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title>CryptoShare</title>
<link rel='shortcut icon' href='img/favicon.ico' type='image/ico' />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/style_pass.css" />
<link rel="stylesheet" type="text/css" href="css/buttons.css" />
<script type="text/javascript">
function contrasena() {
    return Math.random().toString(36).slice(-10);
}
</script>
</head>
<body>
<?php
include 'seg/seguridad.php';
include 'php/menu_sup.php';
include 'php/menu_lat.php';
echo '<div class="contenido">';
//Compruebo si se cambió la contraseña, y si el cambio fue correcto o no
if (isset($_GET['cambio'])) {
	echo "
	<script type='text/javascript'>window.alert('Contraseña cambiada correctamente');
	window.location.assign('./pass.php');
	</script>";
}
elseif (isset($_GET['error'])) {
	echo "
	<script type='text/javascript'>window.alert('Por favor revisa los datos proporcionados e inténtalo de nuevo');
	window.location.assign('./pass.php');
	</script>";
}
else {
	echo "<h3 class='titulo'>Rellena el formulario para cambiar la contrase&ntilde;a</h3>";
}
?>

<form action='php/form/cambio_pass.php' method='post'>
	<table class='contrasena'>
		<tr><td><input type='password' name='contrasena0' placeholder='Introduce tu contrase&ntilde;a actual' size="30" pattern=".{5,}" required title="Mínimo 5 caracteres"></td></tr>
		<tr><td><input type='password' name='contrasena1' placeholder='Nueva contrase&ntilde;a' size="30" pattern=".{5,}" required title="Mínimo 5 caracteres"></td></tr>
		<tr><td><input type='password' name='contrasena2' placeholder='Repite la contrase&ntilde;a' size="30" pattern=".{5,}" required title="Mínimo 5 caracteres"></td></tr>
		<tr><td><input type='Submit' value='Cambiar contrase&ntilde;a' class="boton"></td></tr>
	</table>
</form>
<form>
<table class="random">
	<tr><td><button class="boton" onclick="contrasena()">Generar contrase&ntilde;a</button></td><td><h3 class="titulo" id="ran_pass"></h3></td></tr>
</table>
</form>
<script>
document.getElementById("ran_pass").innerHTML = contrasena();
</script>
</div>
</body>
</html>