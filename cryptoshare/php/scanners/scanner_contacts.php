<?php
include 'php/conexion.php';
$id=$_SESSION['id'];

// Comenzamos mostrando todos los contactos disponibles
$sql = 'select * from usuarios usu join contactos con on usu.id=con.id_contacto where con.id_usuario='.$id;
$consulta=mysqli_query($conexion,$sql);
// Compruebo que hay usuarios que cumplen las condiciones de la primera consulta y muestro el título de la página

echo "
<div class='contenido'>";
if (mysqli_num_rows($consulta)>=1) {
	echo '
	<h3 class="titulo">Contactos</h3>';
}
echo "
	<form action='php/form/contacts.php' method='post'>
		<table>";
while ($valor=mysqli_fetch_array($consulta,MYSQLI_NUM)) {
	echo "
			<tr>
				<td class='izquierda'><a href='contact_info.php?id=".$valor[0]."'>$valor[4]</a></td>
				<td><img src='$valor[5]' alt='Profile picture'/></td>
				<td class='derecha'><button class='boton_adm' onclick='php/form/contacts.php' name='del_address' value='$valor[0]'>Eliminar de contactos</button></td>";
	echo "
			</tr>";
}
echo "
		</table>
	</form>
</div>";
?>