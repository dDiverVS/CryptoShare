<?php
include 'php/conexion.php';
$id=$_SESSION['id'];
echo '
	<div class="contenido">';
// Comienzo comprobando si se ha hecho una búsqueda y cambiando los resultados en función
// Primero mostramos en pantalla el usuario buscado en caso de que lo encontremos
if (isset($_GET['busca'])) {
	$sql='select * from usuarios where id='.$_GET["busca"].' order by nombre_completo';
	echo '<h2 class="titulo">Estos son los usuarios que se han encontrado</h2>';
}
// En caso contrario indicamos que no se ha encontrado
elseif (isset($_GET['no_encontrado'])) {
	$sql = 'select * from usuarios where id!='.$id.' order by nombre_completo';
	echo '<h2 class="titulo">Ningún usuario coincide con la búsqueda indicada</h2>';
}
// Asimismo evitamos que los usuarios añadan su propia cuenta a sus contactos
elseif (isset($_GET['no_self'])) {
	$sql = 'select * from usuarios where id!='.$id.' order by nombre_completo';
	echo '<h2 class="titulo">No puedes agregarte a ti mismo como contacto</h2>';
}
// Finalmente si no hay búsqueda mostramos todos los contactos disponibles
else {
	$sql = 'select * from usuarios where id!='.$id.' order by nombre_completo';
}
// Mediante una segunda consulta podremos ver si el usuario es ya o no un contacto, para en función del resultado ofrecer añadirlo o eliminarlo
$sql2 = 'select * from contactos where id_usuario='.$id;
$consulta=mysqli_query($conexion,$sql);
$consulta2=mysqli_query($conexion,$sql2);
// Compruebo que hay usuarios que cumplen las condiciones de la primera consulta y muestro el título de la página
if (mysqli_num_rows($consulta)>=1) {
	
	echo '
	<h3 class="titulo">Libreta de direcciones</h3>';
	// Compruebo si se ha añadido un usuario mediante el formulario correctamente y lo muestro en pantalla
	if (isset($_GET['usu_anadido'])) {
		$id_contacto=$_GET['usu_anadido'];
		$sql_contacto='select nombre_completo from usuarios where id='.$id_contacto;
		$consulta3=mysqli_query($conexion,$sql_contacto);
		$resultado=mysqli_fetch_array($consulta3,MYSQLI_NUM);
		echo '
	<h3 class="titulo2">El usuario '.$resultado[0].' ha sido añadido correctamente a tus contactos</h3>';
	}
	// Asimismo compruebo si se ha borrado algún usuario
	elseif (isset($_GET['usu_borrado'])) {
		$id_contacto=$_GET['usu_borrado'];
		$sql_contacto='select nombre_completo from usuarios where id='.$id_contacto;
		$consulta3=mysqli_query($conexion,$sql_contacto);
		$resultado=mysqli_fetch_array($consulta3,MYSQLI_NUM);
		echo '
	<h3 class="titulo3">El usuario '.$resultado[0].' ha sido borrado correctamente de tus contactos</h3>';
	}
	// Finalmente doy una salida a operaciones de adición o eliminación con errores
	elseif (isset($_GET['error'])) {
		echo '
	<h3 class="titulo3">Ha ocurrido un error procesando la solicitud, por favor, inténtalo de nuevo</h3>';
	}
}

echo "
	<form action='php/form/contacts.php' method='post'>
	<input type='text' placeholder='Buscar por nombre' name='busca'></input>
	<input class='boton' id='buscar' type='submit' name='' value='Buscar'/>
		<table>";
while ($valor=mysqli_fetch_array($consulta,MYSQLI_NUM)) {
echo "
			<tr>
				<td class='izquierda'><a href='contact_info.php?id=".$valor[0]."'>$valor[4]</a></td>
				<td><img src='$valor[5]' alt='Profile picture'/></td>";
				while ($valor2=mysqli_fetch_array($consulta2,MYSQLI_NUM)) {
					if ($valor[0]==$valor2[1]) {
					 	echo "
				<td class='derecha'><button class='boton_adm' onclick='php/form/contacts.php' name='del_address' value='$valor[0]'>Eliminar de contactos</button></td>";
					 	break;
					}
				}
				if ($valor[0]!=$valor2[1]) {
					echo "
				<td class='derecha'><button class='boton' onclick='php/form/contacts.php' name='add_address' value='$valor[0]'>Añadir a contactos</button></td>";
				}
				$consulta2=mysqli_query($conexion,$sql2);
echo "
			</tr>";
}
echo "
		</table>
	</form>
</div>";
?>