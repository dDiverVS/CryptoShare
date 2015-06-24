<?php
session_start();
session_destroy(); // destruyo la sesión
header("Location:../../"); //envío al usuario a la pag. de inicio
?>