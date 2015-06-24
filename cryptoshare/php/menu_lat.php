<div id='menuIzquierda'>
	<a href="./app.php"><img src="img/logo.png" alt="Logo CryptoShare"/></a>
	<ul class='izquierda'>
		<li><a class="boton_lat" href='./group.php'><b>Grupos</b></a></li>
		<li><a class="boton_lat" href='./contacts.php'><b>Contactos</b></a></li>
		<li><a class='boton_lat' href='./address_book.php'><b>Libreta de direcciones</b></a></li>
		<li><a class='boton_lat' href='./pass.php'><b>Cambiar contrase&ntilde;a</b></a></li>
		<?php
			// Compruebo el nivel del usuario y muestro el panel de administración en caso de que sea de nivel 1
			if ($_SESSION["nivel"]==1)	echo "<li><a class='boton_adm' href='./admin.php'><b>Administraci&oacute;n</b></a></li>";
		?>
	</ul>
</div>
