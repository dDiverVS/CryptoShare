<?php
include("../conexion.php");
include'../../seg/seguridad.php';
// Obtenemos usuario y las contraseñas
$usuario=$_SESSION['usuario'];
$contrasena0=$_POST['contrasena0'];
$contrasena1=$_POST['contrasena1'];
$contrasena2=$_POST['contrasena2'];
//Encripto la contraseña para evitar su envío en texto plano en todo momento
$hash0=hash('sha256', $contrasena0);
$hash1=hash('sha256', $contrasena1);
//Definimos la consulta de comprobación
$sql= "select * from usuarios where nombre='$usuario' and contrasenia='$hash0'";
// Ejecutamos la conexión
$resultado=mysqli_query($conexion,$sql);
// Comprobamos que efectivamente el usuario ha introducido la contraseña correcta y que la nueva contraseña es idéntica en ambos casos
if (mysqli_num_rows($resultado) && $contrasena1==$contrasena2){
	$sql="update usuarios set contrasenia='$hash1' where nombre='$usuario'";
	mysqli_query($conexion,$sql);
	header('location:../../pass.php?cambio');
}
else {
	header('location:../../pass.php?error');
}
?>