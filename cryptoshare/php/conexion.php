<?php
$servidor = "localhost";
$usuario = "root";
$clave = "inves";
$db = "cryptoshare";
// Crear Conexión
$conexion = mysqli_connect($servidor, $usuario, $clave, $db);
// Comprobamos que es exitosa
if (!$conexion) {
    die("Fallo en la conexión: " . mysqli_connect_error());
}
?>