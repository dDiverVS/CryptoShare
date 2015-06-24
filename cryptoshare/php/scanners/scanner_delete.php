<?php
$usuario=$_SESSION['usuario'];
$directorio='uploads/'.$usuario.'/';
$ficheros=array_diff(scandir($directorio),array('..','.'));
// Compruebo que no hubo errores durante una eliminación anterior
echo "
<div class='contenido'>";
if (isset($_GET['error'])) {
	echo '<h2 class="titulo">Se produjo un error al eliminar un fichero</h2>';
}
if (count($ficheros)>=1) {
	echo '<h2 class="titulo">Pulsa sobre los elementos que quieras eliminar</h2>';
}
echo "
	<form action='php/form/delete.php' method='post'>
		<table>
			<tr>";
$x=1;
foreach ($ficheros as $fichero) {
	$ruta=$directorio.$fichero;
	echo "<td class='scanner'><div class='content'><button class='";
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
						echo "' type='submit' value='$ruta' name='borrar'>$fichero</button></div></td>";
	if ($x % 5 ==0) {
		echo "</tr><tr>";
	}
	$x=$x+1;
}
echo "</tr></table></form></div>";
?>
