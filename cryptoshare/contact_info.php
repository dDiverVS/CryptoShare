<!DOCTYPE html>
<html>
<head>
<title>CryptoShare</title>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<link rel='shortcut icon' href='img/favicon.ico' type='image/ico' />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/style_contact_info.css" />
<link rel="stylesheet" type="text/css" href="css/buttons.css" />
</head>
<body>
<?php
include'seg/seguridad.php';
include'php/conexion.php';
include'php/menu_sup.php';
include'php/menu_lat.php';
$id=$_GET['id'];
//Buscamos la información del usuario a consultar
$sql='select nombre_completo, tlf, img, descripcion from usuarios join puesto on usuarios.puesto=puesto.id where usuarios.id='.$id;
$consulta=mysqli_query($conexion,$sql);
$valor=mysqli_fetch_array($consulta,MYSQLI_NUM);
//Presentamos la información en forma de tabla
echo "
<div class='contenido'>
<h3 class='titulo'>Información de contacto</h3>
	<table class='informacion'>
		<tr>
			<th colspan='2'>".$valor[0]."</th>
		</tr>
		<tr>
			<td class='left'>Teléfono:<br/>".$valor[1]."</td><td rowspan='2'><img src='".$valor[2]."' alt='Profile picture'/></td>
		</tr>
		<tr>
			<td class='left'>Puesto de trabajo:<br/>".$valor[3]."</td>
		</tr>
	</table>";
?>
<button class="boton" onclick="window.history.back()">Volver</button>
</div>
</body>
</html>