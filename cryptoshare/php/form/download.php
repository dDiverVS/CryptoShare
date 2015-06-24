<?php
include '../conexion.php';
include '../../seg/seguridad.php';
$fichero = '../../'.$_POST['descargar'];
//Es necesario primero descifrar el contenido del fichero
exec('sudo /cryptoshare/crypt/decrypt.sh "'.$fichero.'"');
//Fuerzo la descarga del fichero en cuestión
if (file_exists($fichero)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($fichero).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fichero));
    if (readfile($fichero)) {
    	//Una vez descargado borro el fichero desencriptado
    	exec('rm "'.$fichero.'"');
    }
}
?>
