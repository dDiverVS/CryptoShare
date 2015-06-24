<?php
if (isset($_POST['id']) && isset($_POST['fichero'])) {
	include'../conexion.php';
	include'../../seg/seguridad.php';
	//Obtengo los datos tanto del destinatario como del remitente
	$id=$_POST['id'];
	$fichero=$_POST['fichero'];
	$usuario=$_SESSION['usuario'];
	$id_usuario=$_SESSION['id'];
	//Creo un bucle para cada destinatario
	foreach ($id as $destinatario) {
		//Realizo las mismas acciones para cada fichero a enviar
		foreach ($fichero as $fichero_origen) {
			$sql='select nombre from usuarios where id='.$destinatario;
			$consulta=mysqli_query($conexion,$sql);
			$resultado=mysqli_fetch_array($consulta,MYSQLI_NUM);
			//Defino la ruta del fichero de origen y la del de destino
			$origen='../../uploads/'.$usuario.'/'.$fichero_origen;
			$destino='../../uploads/'.$resultado[0].'/'.$fichero_origen;
			//Defino el nombre del fichero registrado en la base de datos
			$fichero_origen_base=str_replace(".crypt", "", $fichero_origen);
			$destino_base=str_replace(".crypt", "", $destino);
			//A continuación llevo a cabo la transferencia del fichero de un usuario a otro
			copy($origen,$destino);
			//Inserto en la base de datos la información del fichero, quien lo envía, quien lo recibe, el nombre, la ruta...
			$sql2='insert into ficheros (id_origen,id_destino,nombre,ruta,fechahora) values ('.$id_usuario.','.$destinatario.',"'.$fichero_origen_base.'","'.$destino_base.'","'.date("Y-n-j H:i:s").'")';
			//Compruebo que haya funcionado todo y cambio los permisos en el fichero copiado
			if (mysqli_query($conexion,$sql2)) {
				exec ('sudo chmod 770 "'.$destino.'"');
				exec ('sudo chown root:www-data "'.$destino.'"');
			}
			else echo "Ha ocurrido un error al ejecutar la consulta";
		}
	}
	header('location:../../enviar.php?envio_correcto');
}
?>
