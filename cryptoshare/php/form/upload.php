<?php
//Comenzamos iniciando sesión y accediendo a la base de datos para usar parámetros de la sesión y registrar las subidas
include'../../seg/seguridad.php';
include'../conexion.php';
$usuario=$_SESSION['usuario'];
$id=$_SESSION['id'];
//Defino la ruta de subida de los ficheros
$rutaDestino = '../../uploads/'.$usuario.'/';

//Compruebo que se han enviado ficheros
if (!empty($_FILES)) {
	//Defino el nombre del fichero, el nombre temporal y la ruta de destino
	$nombreFichero=$_FILES['file']['name'];
	$ficheroTemporal=$_FILES['file']['tmp_name'];
	$ficheroDestino =  $rutaDestino.$nombreFichero;
	//Compruebo que la subida es correcta
	if (move_uploaded_file($ficheroTemporal,$ficheroDestino)) {
		//A continuación registro la subida del fichero, encripto el fichero, borro el fichero original y modifico el dueño y los permisos sobre el fichero encriptado
		$sql='insert into ficheros (id_origen,id_destino,nombre,ruta,fechahora) values ('.$id.','.$id.',"'.$nombreFichero.'","'.$ficheroDestino.'","'.date("Y-n-j H:i:s").'")';
		mysqli_query($conexion,$sql);
		exec ('sudo /cryptoshare/crypt/crypt.sh "'.$ficheroDestino.'"');
		exec ('rm "'.$ficheroDestino.'"');
		exec ('sudo chmod 755 "'.$ficheroDestino.'.crypt"');
		exec ('sudo chown www-data "'.$ficheroDestino.'.crypt"');
	}
}
?>
