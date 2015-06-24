<?php
include("../conexion.php");
// Obtenemos usuario y contraseña
$usuario=$_POST['usuario'];
$contrasena=$_POST['contrasena'];
//Encripto la contraseña para evitar su envío en texto plano en todo momento
$hash=hash('sha256', $contrasena);
//Definimos la consulta de comprobación
$sql= "select * from usuarios where nombre='$usuario' and contrasenia='$hash'";

// Ejecutamos la conexión
$resultado=mysqli_query($conexion,$sql);

// Comprobamos que se nos devuelve un valor válido
if (mysqli_num_rows($resultado)){
	//usuario y contraseña válidos
	//defino una sesion y guardo datos
	session_start($usuario);
	$_SESSION["autenticado"]="SI";
	//Defino la fecha y hora de inicio de sesión en formato aaaa-mm-dd hh:mm:ss
	$_SESSION["ultimoAcceso"]=date("Y-n-j H:i:s");
	//Obtenemos el nivel de la sesión y lo pasamos a través de la variable $_SESSION
	$fila=mysqli_fetch_array($resultado, MYSQLI_NUM);
	$_SESSION['id']=$fila[0];
	$_SESSION["nivel"]=$fila[3];
	$_SESSION['nombre']=$fila[4];
	$_SESSION['img']=$fila[5];
	$_SESSION["usuario"]=$usuario;
	header ("location:../../app.php");
}
else {
	//si no existe le mando otra vez a la portada
	header("location:../../index.php?error_acceso=si");
}
?>