<?php
include '../../seg/seguridad.php';
include '../conexion.php';
// Comienzo configurando el comportamiento a la hora de añadir un contacto
if (isset($_POST['add_address'])) {
	$id=$_SESSION['id'];
	$id_contacto=$_POST['add_address'];
	// Evito que los usuarios se añadan a si mismos
	if ($id==$id_contacto) {
		header('location:../../address_book.php?no_self');
	}
	// A continuación creo la consulta que añadirá un usuario a los contactos
	else {
		$sql_insertar='insert into contactos values ('.$id.','.$id_contacto.')';
		mysqli_query($conexion,$sql_insertar);
		header('location:../../address_book.php?usu_anadido='.$id_contacto);
	}
}

// Ahora configuramos el formulario para eliminar contactos
elseif (isset($_POST['del_address'])) {
	$id=$_SESSION['id'];
	$id_contacto=$_POST['del_address'];
	$sql='delete from contactos where id_usuario='.$id.' and id_contacto='.$id_contacto;
	mysqli_query($conexion,$sql);
	header('location:../../address_book.php?usu_borrado='.$id_contacto);
}

// Tras esto definimos la búsqueda de usuarios a través del nombre
elseif (isset($_POST['busca'])) {
	$busca=$_POST['busca'];
	if ($busca=='') {
		$sql='select * from usuarios where nombre_completo like "%Administrador%"';
	}
	else {
		$sql='select * from usuarios where nombre_completo like "%'.$busca.'%"';
	}
	$consulta=mysqli_query($conexion,$sql);
	if (mysqli_num_rows($consulta)) {
		$valor=mysqli_fetch_array($consulta,MYSQLI_NUM);
		header('location:../../address_book.php?busca='.$valor[0]);
	}
	else {
		header('location:../../address_book.php?no_encontrado');
	}
}

// Finalmente damos una salida a errores y accesos forzosos al formulario
else {
	header('location:../../address_book.php?error');
}

?>