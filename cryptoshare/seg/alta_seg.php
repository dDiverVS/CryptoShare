<?php
//Inicio la sesión
session_start();

//Compruebo si el usuario está autenticado
if ($_SESSION["autenticado"]!="SI") {
	//Si no lo está le envío a la página de inicio
	header("Location:./");
	//Finalizo el script completo
	exit();
}

//Si el usuario está autenticado procedo a comprobar si tiene o no nivel 1
elseif ($_SESSION["nivel"]!=1) {
	header("location:./app.php?forbidden=true");
}

//Por último en caso de que esté autenticado y sea de nivel 1 primero compruebo el tiempo transcurrido desde la última acción
else {
	$fechaGuardada = $_SESSION["ultimoAcceso"];
	$ahora = date("Y-n-j H:i:s");
	$tiempoTranscurrido = (strtotime($ahora)-strtotime($fechaGuardada));
	// Comparamos el tiempo transcurrido y en caso de que sea demasiado elevado procedo a cerrar la sesión y mandar al usuario a la página de inicio
	if($tiempoTranscurrido >= 300) {
		session_destroy();
		header("Location: ./");
	}
	//En caso contrario actualizamos la fecha de último acceso
	else {
		$_SESSION["ultimoAcceso"] = $ahora;
	}
}
?>
