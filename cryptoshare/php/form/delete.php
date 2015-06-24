<?php
include '../conexion.php';
include '../../seg/seguridad.php';
$id=$_SESSION['id'];
$ruta='../../'.$_POST['borrar'];
$ruta_base=str_replace(".crypt", "", $ruta);
//Compruebo que el fichero está registrado en la base de datos
$sql='delete from ficheros where id_destino='.$id.' and ruta="'.$ruta_base.'"';
mysqli_query($conexion,$sql);
if (mysqli_affected_rows($conexion) > 0) {
	//En caso de que haya funcionado la consulta, borro el fichero en cuestión
	unlink($ruta);
	header('location:../../eliminar.php');
}
else {
	header('location:../../eliminar.php?error');
}
?>