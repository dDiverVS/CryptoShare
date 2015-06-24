<?php
include 'php/conexion.php';
$id=$_SESSION['id'];
$sql = 'select id, nombre_completo from usuarios usu join contactos con on usu.id=con.id_contacto where con.id_usuario='.$id;
$consulta=mysqli_query($conexion,$sql);
$x=0;
echo "
	<div class='contenido'>";
if (count($consulta)>=1) {
	echo '
	<h2 class="titulo">Enviar a...</h2>';
}
if (isset($_GET['envio_correcto'])) {
	echo "
	<script type='text/javascript'>window.alert('Los archivos fueron enviados correctamente');
	window.location.assign('./enviar.php');
	</script>";
}
elseif (isset($_GET['error_contacto'])) {
	echo "
	<script type='text/javascript'>window.alert('Los archivos no se enviaron ya que el receptor no le ha agregado como contacto');
	window.location.assign('./enviar.php');
	</script>";
}
echo "
	<form action='php/form/send.php' method='post'>
		<table>";
while ($valor=mysqli_fetch_array($consulta,MYSQLI_NUM)) {
echo "
			<tr>
				<td>
					<div class='squaredOne'><input id='squaredOne$x' type='checkbox' value='".$valor[0]."' name='id[]'/>
						<label for='squaredOne$x'></label>
					</div>
				</td>
				<td class='derecha'>$valor[1]</td>
			</tr>";
$x=$x+1;
}
echo "
		</table>";
$usuario=$_SESSION['usuario'];
$directorio='uploads/'.$usuario.'/';
$ficheros=array_diff(scandir($directorio),array('..','.'));
if (count($ficheros)>=1) {
	echo '
		<h3 class="titulo2">Elige los ficheros que quieras enviar</h3>
		<table>';
	foreach ($ficheros as $fichero) {
		$ruta=$directorio.$fichero;
		echo "
				<tr>
					<td>
						<div class='squaredOne'><input id='squaredOne$x' type='checkbox' value='".$fichero."' name='fichero[]'/>
							<label for='squaredOne$x'></label>
						</div>
					</td>
					<td class='derecha'>$fichero</td>
				</tr>";
	$x=$x+1;
	}
	echo "
		</table>
		<p>
			<input class='boton' type='submit' name='' value='Enviar'/>
		</p>";
}
else {
	echo '
		<h3 class="titulo3">No tienes ningún fichero para enviar</h3>';
}
echo "
	</form>
</div>";
?>