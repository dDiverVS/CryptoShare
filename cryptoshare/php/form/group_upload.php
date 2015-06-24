<?php
//Comenzamos iniciando sesión y accediendo a la base de datos para usar parámetros de la sesión y registrar las subidas
include'../../seg/seguridad.php';
include'../conexion.php';
$grupo=$_POST['grupo'];
$id_grupo=$_POST['id_grupo'];
$id=$_SESSION['id'];
//Defino la ruta donde se almacenarán los ficheros
$rutaDestino = '../../uploads/groups/'.$grupo.'/';

if (!empty($_FILES)) {
	$nombreFichero=$_FILES['file']['name'];
	$ficheroTemporal=$_FILES['file']['tmp_name'];
	$ficheroDestino =  $rutaDestino.$_FILES['file']['name'];
	//En caso de que funcione la subida, la registro, encripto el fichero, modifico sus permisos y el dueño y finalmente borro el fichero sin encriptar
	if (move_uploaded_file($ficheroTemporal,$ficheroDestino)) {
		$sql='insert into ficheros_grupos (id_grupo,id_usuario,nombre,ruta,fechahora) values ('.$id_grupo.','.$id.',"'.$nombreFichero.'","'.$ficheroDestino.'","'.date("Y-n-j H:i:s").'")';
		mysqli_query($conexion,$sql);
		exec ('sudo /cryptoshare/crypt/crypt.sh "'.$ficheroDestino.'"');
		exec ('sudo chmod 755 "'.$ficheroDestino.'.crypt"');
		exec ('sudo chown www-data "'.$ficheroDestino.'.crypt"');
		exec ('rm "'.$ficheroDestino.'"');
	}
}
?>