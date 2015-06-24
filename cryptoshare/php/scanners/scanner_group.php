<?php
$id=$_SESSION['id'];
//Busco los datos de los grupos que estén asociados a mi cuenta
$sql='select id_grupo, permiso, nombre_grupo from usuarios_grupo usu join grupos gru on usu.id_grupo=gru.id where usu.id_usuario='.$id;
$consulta=mysqli_query($conexion,$sql);
echo '
<div class="contenido">
	<h3 class="titulo">A continuación se muestran los grupos de los que formas parte:</h3>';
while ($valor=mysqli_fetch_array($consulta,MYSQLI_NUM)) {
$grupo=$valor[2];
//Configuro el directorio a analizar en busca de ficheros
$directorio='uploads/groups/'.$grupo.'/';
//A continuación analizo los ficheros y los listo en el grupo
$ficheros=array_diff(scandir($directorio),array('..','.'));
	echo "
	<div class='grupo'>
		<h2 class='titulo2'>".$valor[2]."</h2>
		<form action='php/form/download.php' method='post'>
			<table>";
			if (count($ficheros)==0) {
				echo "<tr><th class='titulo3'>Este grupo no contiene ficheros</th></tr>";
			}
			echo"
				<tr>
";
	$x=1;
	foreach ($ficheros as $fichero) {
		$ruta=str_replace(".crypt","",$directorio.$fichero);
		echo "
					<td class='scanner'>
						<div class='content'>
							<button class='";
							if (preg_match('~\.(jpeg.crypt.crypt|jpg.crypt.crypt|png.crypt.crypt|ico.crypt.crypt|gif.crypt)$~',$fichero)) {
								echo "img";
							}
							elseif (preg_match('~\.(txt.crypt.crypt|php.crypt.crypt|html.crypt.crypt|css.crypt.crypt|js.crypt)$~',$fichero)) {
								echo "html";
							}
							elseif (preg_match('~\.(doc.crypt|docx.crypt|pdf.crypt|xls.crypt|xlsx.crypt|cbr.crypt|cbz.crypt)$~',$fichero)) {
								echo "doc";
							}
							elseif (preg_match('~\.(mp3.crypt|mp4.crypt|mkv.crypt|avi.crypt|flv.crypt|aac.crypt|vob.crypt)$~',$fichero)) {
								echo "multi";
							}
							elseif (preg_match('~\.(exe.crypt|zip.crypt|rar.crypt|tar.crypt|gz.crypt)$~',$fichero)) {
								echo "exe";
							}
							else echo "scan";
							echo "' type='submit' value='$ruta' name='descargar'>$fichero</button>
						</div>
					</td>";
		if ($x % 5 ==0) {
			echo "
				</tr>
				<tr>";
		}
		$x++;
	}
	echo "
					<td></td>
				</tr>
			</table>
		</form>";
	//Compruebo los permisos del usuario y ofrezco la posibilidad de subir ficheros en función
	if ($valor[1]>=2) {
		echo "
		<div class='subir'>
			<form action='php/form/group_upload.php' class='dropzone'>
				<p><input type='hidden' name='grupo' value='".$grupo."'/>
				<input type='hidden' name='id_grupo' value='".$valor[0]."'/></p>
				<div class='fallback'>
					<input name='file' type='file'/>
				</div>
			</form>
		</div>";
	}
	//Compruebo los permisos del usuario y ofrezco la posibilidad de borrar ficheros en función
	if ($valor[1]==3 && count($ficheros)>=1) {
		echo "
		<div class='borrar'>
			<form action='del_group.php' method='post'>
				<table>
					<tr>
						<td>
							<button class='boton_adm' type='submit' name='grupo' value='".$grupo."'>Borrar ficheros</button>
						</td>
					</tr>
				</table>
			</form>
		</div>";
	}
echo"
	</div>";
}
echo "
</div>";
?>
