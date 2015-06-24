<?php
$usuario=$_SESSION['usuario'];
//Indico la ruta de almacenamiento del usuario
$directorio='uploads/'.$usuario.'/';
//Compruebo los ficheros que hay en el directorio excluyendo el propio directorio y el directorio padre
$ficheros=array_diff(scandir($directorio),array('..','.'));
echo "
<div class='contenido'>";
if (count($ficheros)>=1) {
	echo '
<h2 class="titulo">Pulsa sobre el fichero que quieras descargar</h2>';
}
echo "
	<form action='php/form/download.php' method='post'>
		<table>
			<tr>";
//Inicializo x para hacer los cambios de línea en la tabla
$x=1;
//Presento cada fichero cambiando la clase para que cambie el icono en función de la extensión del fichero
foreach ($ficheros as $fichero) {
	$ruta=str_replace(".crypt","",$directorio.$fichero);
	echo "
				<td class='scanner'>
					<div class='content'>
						<button class='";
						if (preg_match('~\.(jpeg.crypt|jpg.crypt|png.crypt|ico.crypt|gif.crypt)$~',$fichero)) {
							echo "img";
						}
						elseif (preg_match('~\.(txt.crypt|php.crypt|html.crypt|css.crypt|js.crypt)$~',$fichero)) {
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
	$x=$x+1;
}
echo "
			</tr>
		</table>
	</form>
</div>";
?>
