<!DOCTYPE html>
<html>
<head>
<title>CryptoShare</title>
<link rel='shortcut icon' href='img/favicon.ico' type='image/ico' />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/style_enviar.css" />
<link rel="stylesheet" type="text/css" href="css/buttons.css" />
</head>
<body>
<?php
include 'php/conexion.php';
include 'seg/seguridad.php';
include 'php/menu_sup.php';
include 'php/menu_lat.php';

if (isset($_POST['grupo'])) {
	$grupo=$_POST['grupo'];
	$directorio='uploads/groups/'.$grupo.'/';
	//Comenzamos buscando los ficheros a borrar del grupo
	$ficheros=array_diff(scandir($directorio),array('..','.'));
	$x=0;
	echo "
	<div class='contenido'>
	";
	// Compruebo que no hubo errores durante una eliminación anterior
	if (count($ficheros)>=1) {
		echo '<h3 class="titulo">Pulsa sobre los elementos que quieras eliminar del grupo: '.$grupo.'</h3>';
	}
	//Presento los ficheros del grupo para que el usuario pueda escoger los que desea borrar
	echo "
		<form action='del_group.php' method='post'>
		<input type='hidden' name='grupo_borrar' value='".$grupo."'/>
			<table>";
	foreach ($ficheros as $fichero) {
		$ruta=$directorio.$fichero;
		echo "
				<tr>
					<td>
						<div class='squaredOne'><input id='squaredOne$x' type='checkbox' value='".$ruta."' name='borrar[]'/>
							<label for='squaredOne$x'></label>
						</div>
					</td>
					<td class='derecha'>$fichero</td>
				</tr>";
		$x++;
	}
	echo "
				</tr>
				<tr>
					<td class='derecha' colspan='2'><input type='submit' class='boton' value='Eliminar ficheros'/></td>
				</tr>
			</table>
		</form>
	</div>";
}

elseif (isset($_POST['grupo_borrar']) && isset($_POST['borrar'])) {
	$grupo_borrar=$_POST['grupo_borrar'];
	$sql_id='select id from grupos where nombre_grupo="'.$grupo_borrar.'"';
	$consulta_id=mysqli_query($conexion,$sql_id);
	$id_grupo=mysqli_fetch_array($consulta_id,MYSQLI_NUM);
	foreach ($_POST['borrar'] as $ruta) {
		//Comienzo borrando los registros de los ficheros en la base de datos, para ello debo eliminar la extensión .crypt
		$ruta_consulta=str_replace(".crypt","",'../../'.$ruta);
		$sql='delete from ficheros_grupos where id_grupo='.$id_grupo[0].' and ruta="'.$ruta_consulta.'"';
		mysqli_query($conexion,$sql);
		//Compruebo que se borraron los registros en la base de datos y procedo a eliminar los ficheros
		if (mysqli_affected_rows($conexion) > 0) {
			unlink($ruta);
			header('location:group.php?del');
		}
		//En caso de que hubiera un fallo envío al usuario a la pantalla anterior y muestro un mensaje de error
		else {
			header('location:group.php?error_del');
		}
	}
}
?>
</body>
</html>
