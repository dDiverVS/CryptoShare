<div class='contenido'>
<form action='admin.php' method='post'>
<?php
if (isset($_GET['usu_existe'])) {
	echo "
	<script type='text/javascript'>window.alert('Ya existe un usuario con este nombre, por favor intente crearlo con un nombre diferente');
	window.location.assign('admin.php');
	</script>";
}
if (isset($_GET['usu_creado'])) {
	echo "
	<script type='text/javascript'>window.alert('Usuario creado correctamente');
	window.location.assign('admin.php');
	</script>";
}
if (isset($_GET['usu_del'])) {
	echo "
	<script type='text/javascript'>window.alert('Los usuarios seleccionados han sido borrados correctamente');
	window.location.assign('admin.php');
	</script>";
}
if (isset($_GET['updated'])) {
	echo "
	<script type='text/javascript'>window.alert('Los cambios han sido efectuados exitosamente');
	window.location.assign('admin.php');
	</script>";
}
if (isset($_GET['gru_existe'])) {
	echo "
	<script type='text/javascript'>window.alert('Ya existe un grupo con este nombre, por favor intente crearlo con un nombre diferente');
	window.location.assign('admin.php');
	</script>";
}
if (isset($_GET['gru_creado'])) {
	echo "
	<script type='text/javascript'>window.alert('El grupo se ha creado correctamente');
	window.location.assign('admin.php');
	</script>";
}
if (isset($_GET['fallo_gru'])) {
	echo "
	<script type='text/javascript'>window.alert('El grupo se ha creado con algún error, por favor revísalo');
	window.location.assign('admin.php');
	</script>";
}
if (isset($_GET['gru_borrado'])) {
	echo "
	<script type='text/javascript'>window.alert('El grupo se ha borrado exitosamente');
	window.location.assign('admin.php');
	</script>";
}
if (isset($_GET['fallo_bor_gru'])) {
	echo "
	<script type='text/javascript'>window.alert('El grupo no se ha borrado debido a algún error, por favor revísalo');
	window.location.assign('admin.php');
	</script>";
}
?>
	<table>
		<tr>
			<td>
				<button class='boton_adm' name='add_user'>
					Añadir usuarios
				</button>
			</td>
			<td>
				<?php
				if (isset($_POST['admin'])) echo "<input type='hidden' name='admin'/>";
				?>
				<button class='boton_adm' name='del_user'>
					Eliminar usuarios
				</button>
			</td>
			<td>
				<button class='boton_adm' name='edit_user'>
					Editar usuarios
				</button>
			</td>
			<td>
				<button class='boton_adm' name="pro_picture">
					Cambiar imágenes de perfil
				</button>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
				<button class='boton_adm' name='add_group'>
					Crear grupo
				</button>
			</td>
			<td>
				<button class='boton_adm' name='del_group'>
					Eliminar grupos
				</button>
			</td>
			<td>
				<button class='boton_adm' name='edit_group'>
					Editar grupos
				</button>
			</td>
			<td>
				<button class='boton_adm' name="reset_pass">
					Restablecer contraseñas
				</button>
			</td>
		</tr>
	</table>
</form>
<?php
include'../php/conexion.php';
if (isset($_POST['add_user'])) {
	if (isset($_POST['nombre']) && isset($_POST['contrasenia']) && isset($_POST['nivel']) && isset($_POST['nombreCompleto']) && isset($_POST['tlf']) && isset($_POST['puesto'])) {
		$nombre=$_POST['nombre'];
		$contrasenia=hash('sha256', $_POST['contrasenia']);
		$nivel=$_POST['nivel'];
		$nombreCompleto=$_POST['nombreCompleto'];
		$tlf=$_POST['tlf'];
		$puesto=$_POST['puesto'];
		$sql='insert into usuarios (nombre, contrasenia, nivel, nombre_completo, tlf, puesto) values ("'.$nombre.'", "'.$contrasenia.'", '.$nivel.', "'.$nombreCompleto.'", '.$tlf.', "'.$puesto.'")';
		$sql_comprobacion='select nombre from usuarios where nombre="'.$nombre.'"';
		$consulta_comprobacion=mysqli_query($conexion,$sql_comprobacion);
		if (mysqli_num_rows($consulta_comprobacion)) {
			header('location:admin.php?usu_existe');
		}
		else {
			if (mysqli_query($conexion,$sql)) {
				exec('mkdir "uploads/'.$nombre.'"');
				header('location:admin.php?usu_creado');
			}
		}
	}
	else {
		$sql_puesto='select * from puesto';
		$consulta_puesto=mysqli_query($conexion,$sql_puesto);
		echo "
		<br/>
		<h3 class='titulo'>Rellene los datos para añadir un usuario</h3>
		<form action='admin.php' method='post'>
			<input type='hidden' name='add_user'/>
			<table>
				<tr>
					<td class='add_user'><input type='text' name='nombre' placeholder='Nombre de usuario' required/></td>
					<td class='add_user'><input type='text' name='nombreCompleto' placeholder='Nombre completo' required/></td>
					<td class='add_user'><input type='password' name='contrasenia' placeholder='Contraseña' required/></td>
				</tr>
				<tr>
					<td class='add_user'><input type='tel' name='tlf' placeholder='Teléfono' pattern='^[9|8|7|6]\d{8}$' title='Debe introducir un número de teléfono válido' required/></td>
					<td class='add_user'>
						<select name='puesto'>";
							while ($fila_puesto=mysqli_fetch_array($consulta_puesto)) {
								echo "
								<option value='".$fila_puesto[0]."'>";
								echo $fila_puesto[1]."</option>";
							}
							echo "
						</select>
					</td>
					<td class='add_user'>
						<select name='nivel'>
						<option value='0'>Usuario</option>
						<option value='1'>Administrador</option>
						</select>
					</td>
				</tr>
			</table>
			<input class='boton' type='submit' value='Crear usuario'/>
			<input class='boton' type='reset' value='Restablecer'/>
		</form>
		<br/>
		<form method='post'>
			<input type='hidden' name='add_user'/>
			<table class='random'>
				<tr>
					<td>
						<button class='boton' onclick='contrasena()'>Generar contrase&ntilde;a</button>
					</td>
					<td>
						<h3 class='titulo' id='ran_pass'></h3>
					</td>
				</tr>
			</table>
		</form>
<script>
function contrasena() {
    return Math.random().toString(36).slice(-10);
}
document.getElementById('ran_pass').innerHTML = contrasena();
</script>";
	}
}

elseif (isset($_POST['del_user'])) {
	if (isset($_POST['id'])) {
		$id=$_POST['id'];
		foreach ($id as $usuario) {
			$sql_nombre='select nombre from usuarios where id='.$usuario;
			$consulta_nombre=mysqli_query($conexion,$sql_nombre);
			$nombre=mysqli_fetch_array($consulta_nombre,MYSQLI_NUM);
			$sql='delete from usuarios where id='.$usuario;
			if (mysqli_query($conexion,$sql)) {
				exec('rm -Rf uploads/'.$nombre[0]);
				header('location:admin.php?usu_del');
			}
		}
	}
	else {
		echo "
		<br/>
		<h3 class='titulo'>Escoja los usuarios que desea borrar</h3>";
		if (isset($_POST['admin'])) {
			$sql='select id, nombre, nombre_completo from usuarios';
		}
		else $sql='select id, nombre, nombre_completo from usuarios where nivel<>1';
		$consulta=mysqli_query($conexion,$sql);
		if (mysqli_num_rows($consulta)) {
			$x=1;
			echo "
			<form method='post' action='admin.php'>
			<input type='hidden' name='del_user'/>
			<table>
				<tr>
					<th>Seleccionar</th>
					<th>Nombre usuario</th>
					<th>Nombre completo</th>
				</tr>";
			while ($fila=mysqli_fetch_array($consulta,MYSQLI_NUM)) {
				echo "
				<tr>
					<td>
						<div class='squaredOne'><input id='squaredOne$x' type='checkbox' value='".$fila[0]."' name='id[]'/>
								<label for='squaredOne$x'></label>
						</div>
					</td>
					<td class='derecha'>
						".$fila[1]."
					</td>
					<td class='derecha'>
						".$fila[2]."
					</td>
				</tr>";
				$x++;
			}
			if (isset($_POST['admin'])) {
				echo "
				</table>
				<input class='boton' type='submit' name='' value='Excluir administradores'/>
				<input class='boton' type='submit' value='Borrar usuarios'/>
				</form>";
			}
			else {
				echo "
				</table>
				<input class='boton' type='submit' name='admin' value='Incluir administradores'/>
				<input class='boton' type='submit' value='Borrar usuarios'/>
				</form>";
			}
		}
	}
}

elseif (isset($_POST['edit_user'])) {
	if (isset($_POST['id'])) {
		$id=$_POST['id'];
		$nombre=$_POST['nombre'];
		$nombre_original=$_POST['nombre_original'];
		$nivel=$_POST['nivel'];
		$nombre_completo=$_POST['nombreCompleto'];
		$tlf=$_POST['tlf'];
		$puesto=$_POST['puesto'];
		$x=0;
		foreach ($id as $usuario) {
			//Comprobar que al actualizar un nombre no existe ya!!!
			if ($nombre_original[$x]!=$nombre[$x]) {
				$sql_comprobacion='select * from usuarios where nombre="'.$nombre[$x].'"';
				$consulta_comprobacion=mysqli_query($conexion,$sql_comprobacion);
				if (mysqli_num_rows($consulta_comprobacion)) {
					header('location:admin.php?usu_existe');
				}
				else {
					$sql='update usuarios set nombre="'.$nombre[$x].'", nivel='.$nivel[$x].', nombre_completo="'.$nombre_completo[$x].'", tlf='.$tlf[$x].', puesto='.$puesto[$x].' where id='.$usuario;
					// Hay que actualizar las rutas de los ficheros con el nuevo nombre de la carpeta
					$sql_ruta='select ruta from ficheros where id_destino='.$usuario;
					$consulta_ruta=mysqli_query($conexion,$sql_ruta);
					if (mysqli_num_rows($consulta_ruta)) {
						while ($fila=mysqli_fetch_array($consulta_ruta,MYSQLI_NUM)) {
							$nueva_ruta=str_replace($nombre_original[$x],$nombre[$x],$fila[0]);
							$sql_update='update ficheros set ruta="'.$nueva_ruta.'" where id_destino='.$usuario.' and ruta="'.$fila[0].'"';
							mysqli_query($conexion,$sql_update);
						}
					}
					exec('mv "uploads/'.$nombre_original[$x].'" "uploads/'.$nombre[$x].'"');
					if (mysqli_query($conexion,$sql)) {
						header('location:admin.php?updated');
					}
				}
			}
			else {
				$sql='update usuarios set nombre="'.$nombre[$x].'", nivel='.$nivel[$x].', nombre_completo="'.$nombre_completo[$x].'", tlf='.$tlf[$x].', puesto='.$puesto[$x].' where id='.$usuario;
				// Hay que actualizar las rutas de los ficheros con el nuevo nombre de la carpeta
				$sql_ruta='select ruta from ficheros where id_destino='.$usuario;
				$consulta_ruta=mysqli_query($conexion,$sql_ruta);
				if (mysqli_num_rows($consulta_ruta)) {
					while ($fila=mysqli_fetch_array($consulta_ruta,MYSQLI_NUM)) {
						$nueva_ruta=str_replace($nombre_original[$x],$nombre[$x],$fila[0]);
						$sql_update='update ficheros set ruta="'.$nueva_ruta.'" where id_destino='.$usuario.' and ruta="'.$fila[0].'"';
						mysqli_query($conexion,$sql_update);
					}
				}
				exec('mv "uploads/'.$nombre_original[$x].'" "uploads/'.$nombre[$x].'"');
				if (mysqli_query($conexion,$sql)) {
					header('location:admin.php?updated');
				}
			}
			$x++;
		}
	}
	else {
		echo "
		<br/>
		<h3 class='titulo'>Cambie los campos que desee actualizar</h3>";
		$sql='select id, nombre, nivel, nombre_completo, tlf, puesto from usuarios';
		$consulta=mysqli_query($conexion,$sql);
		if (mysqli_num_rows($consulta)) {
			echo "
			<form method='post' action='admin.php'>
			<input type='hidden' name='edit_user'/>
			<table>
				<tr>
					<th>Nombre usuario</th>
					<th>Tipo usuario</th>
					<th>Nombre completo</th>
					<th>Teléfono</th>
					<th>Puesto</th>
				</tr>";
			while ($fila=mysqli_fetch_array($consulta,MYSQLI_NUM)) {
				$sql_puesto='select * from puesto';
				$consulta_puesto=mysqli_query($conexion,$sql_puesto);
				echo "
				<tr>
					<td>
						<input type='hidden' value='".$fila[0]."' name='id[]'/>
						<input type='hidden' value='".$fila[1]."' name='nombre_original[]'/>
						<input type='text' name='nombre[]' value='".$fila[1]."' required/>
					</td>
					<td>
						<select name='nivel[]'>
							<option value='0' ";
							if ($fila[2]==0) echo " selected='selected'";
							echo ">Usuario</option>
							<option value='1'";
							if ($fila[2]==1) echo " selected='selected'";
							echo ">Administrador</option>
						</select>
					</td>
					<td>
						<input type='text' name='nombreCompleto[]' value='".$fila[3]."' required/>
					</td>
					<td>
						<input type='tel' name='tlf[]' value='".$fila[4]."' placeholder='Teléfono' pattern='^[9|8|7|6]\d{8}$' title='Debe introducir un número de teléfono válido' required/>
					</td>
					<td>
						<select name='puesto[]'>";
						while ($fila_puesto=mysqli_fetch_array($consulta_puesto)) {
							echo "
								<option value='".$fila_puesto[0]."'";
								if ($fila_puesto[0]==$fila[5]) echo " selected='selected'>";
								else echo ">";
								echo $fila_puesto[1]."</option>";
						}
						echo "
						</select>";
					echo "
					</td>
				</tr>";
			}
			echo "
			</table>
			<input class='boton' type='submit' value='Guardar cambios'/>
			</form>";
		}
	}
}

elseif (isset($_POST['add_group'])) {
	if (isset($_POST['nombre_grupo']) && isset($_POST['id'])) {
		$sql_comprobacion='select * from grupos where nombre_grupo="'.$_POST['nombre_grupo'].'"';
		$consulta_comprobacion=mysqli_query($conexion,$sql_comprobacion);
		if (mysqli_num_rows($consulta_comprobacion)) {
			header('location:admin.php?gru_existe');
		}
		else {
			$id=$_POST['id'];
			$permisos=$_POST['permisos'];
			//Primero creo el grupo
			$sql='insert into grupos (nombre_grupo) values ("'.$_POST['nombre_grupo'].'")';
			mysqli_query($conexion,$sql);
			$sql_id='select id from grupos where nombre_grupo="'.$_POST['nombre_grupo'].'"';
			$consulta_id=mysqli_query($conexion,$sql_id);
			$id_grupo=mysqli_fetch_array($consulta_id,MYSQLI_NUM);
			$x=0;
			$y=0;
			foreach ($id as $usuario) {
				$sql='insert into usuarios_grupo (id_usuario, id_grupo, permiso) values ('.$usuario.', '.$id_grupo[0].', '.$permisos[$x].')';
				if (mysqli_query($conexion,$sql)) $y++;
				$x++;
			}
			if ($y==count($id)) {
				exec('mkdir "uploads/groups/'.$_POST['nombre_grupo'].'"');
				header('location:admin.php?gru_creado');
			}
			else header('location:admin.php?fallo_gru');
		}
	}

	else {
		echo "
		<br/>
		<h3 class='titulo'>Rellene los campos para crear un nuevo grupo</h3>";
		$sql='select usuarios.id, nombre_completo, descripcion from usuarios join puesto on usuarios.puesto=puesto.id';
		$consulta=mysqli_query($conexion,$sql);
		if (mysqli_num_rows($consulta)) {
			echo "
			<form action='admin.php' method='post'>
				<input type='hidden' name='add_group'/>
				<input type='text' name='nombre_grupo' placeholder='Nombre del grupo' required/>
				<h4 class='titulo'>Marca los usuarios que quieras agregar al grupo</h4>
				<table>
					<tr>
					<th>Selecciona</th>
					<th>Nombre completo</th>
					<th>Puesto de trabajo</th>
					<th>Permisos</th>
					</tr>";
				$x=0;
				while ($fila=mysqli_fetch_array($consulta,MYSQLI_NUM)) {
					echo "
					<tr>
						<td>
							<div class='squaredOne'>
								<input id='squaredOne$x' type='checkbox' value='".$fila[0]."' name='id[]'/>
								<label for='squaredOne$x'></label>
							</div>
						</td>
						<td>".$fila[1]."</td>
						<td>".$fila[2]."</td>
						<td>
							<select name='permisos[]'>
								<option value='1'>Lectura</option>
								<option value='2'>Lectura y escritura</option>
								<option value='3'>Control total</option>
							</select>
						</td>
					</tr>";
					$x++;
				}
				echo "
				</table>
				<input type='submit' class='boton' value='Crear grupo'/>
			</form>";
		}
	}
}

elseif (isset($_POST['del_group'])) {
	if (isset($_POST['id_grupo']) && !isset($_POST['no_borrar'])) {
		if (isset($_POST['borrar'])) {
			$sql_nombre='select nombre_grupo from grupos where id='.$_POST['id_grupo'];
			$consulta_nombre=mysqli_query($conexion,$sql_nombre);
			$sql='delete from grupos where id='.$_POST['id_grupo'];
			if (mysqli_query($conexion,$sql)) {
				$carpeta=mysqli_fetch_array($consulta_nombre);
				exec('rm -Rf "uploads/groups/'.$carpeta[0].'"');
				header('location:admin.php?gru_borrado');
			}
			else {
				header('location:admin.php?fallo_bor_gru');
			}
		}
		else {
			$id_grupo=$_POST['id_grupo'];
			$sql_usuarios='select nombre_completo, permiso from usuarios_grupo join usuarios on usuarios_grupo.id_usuario=usuarios.id where id_grupo='.$id_grupo.' group by nombre_completo';
			$consulta_usuarios=mysqli_query($conexion,$sql_usuarios);
			$sql_ficheros='select ficheros_grupos.nombre, fechahora, nombre_completo from ficheros_grupos join usuarios on ficheros_grupos.id_usuario=usuarios.id where id_grupo='.$id_grupo.' group by ficheros_grupos.nombre';
			$consulta_ficheros=mysqli_query($conexion,$sql_ficheros);
			if (mysqli_num_rows($consulta_usuarios)) {
				echo "
				<br/>
				<h3 class='titulo'>Estos son los usuarios del grupo</h3>
				<table>
					<tr>
					<th>Usuarios</th>
					<th>Permisos</th>
					</tr>";
				while ($fila=mysqli_fetch_array($consulta_usuarios)) {
					echo "
					<tr>
					<td class='borrar_grupo'>".$fila[0]."</td>
					<td class='borrar_grupo'>";
					if ($fila[1]==1) echo "Lectura";
					elseif ($fila[1]==2) echo "Lectura y escritura";
					else echo "Control total";
					echo "</td>
					</tr>";
				}
				echo "
				</table>";
			}
			if (mysqli_num_rows($consulta_ficheros)) {
				echo "
				<br/>
				<h3 class='titulo'>Estos son los ficheros del grupo</h3>
				<table>
					<tr>
					<th>Fichero</th>
					<th>Enviado por...</th>
					<th>Enviado el...</th>
					</tr>";
				while ($fila=mysqli_fetch_array($consulta_ficheros)) {
					echo "
					<tr>
					<td class='borrar_grupo'>".$fila[0]."</td>
					<td class='borrar_grupo'>".$fila[2]."</td>
					<td class='borrar_grupo'>".$fila[1]."</td>
					</tr>";
				}
				echo "
				</table>";
			}
			elseif (mysqli_num_rows($consulta_usuarios)==0 && mysqli_num_rows($consulta_ficheros)==0) {
				echo "
				<h3 class='titulo'>Este grupo no contiene usuarios ni ficheros</h3>";
			}
			elseif (mysqli_num_rows($consulta_usuarios)==0) {
				echo "
				<h3 class='titulo'>Este grupo no contiene usuarios</h3>";
			}
			else {
				echo "
				<h3 class='titulo'>Este grupo no contiene ficheros</h3>";
			}
			echo "
			<h2 class='titulo'>¿Quiere borrar este grupo?</h2>
			<form action='admin.php' method='post'>
				<input type='hidden' name='del_group'/>
				<input type='hidden' name='id_grupo' value='".$id_grupo."'/>
				<table>
					<tr>
						<td><input type='submit' class='boton_sup' name='borrar' value='Si'/></td>
						<td><input type='submit' class='boton_adm' name='no_borrar' value='No'/></td>
					</tr>
				</table>
			</form>";
		}
	}
	else {
		echo "
		<br/>
		<h3 class='titulo'>Estos son los grupos que hay actualmente</h3>";
		$sql='select * from grupos';
		$consulta=mysqli_query($conexion,$sql);
		if (mysqli_num_rows($consulta)) {
			echo "
			<form action='admin.php' method='post'>
			<input type='hidden' name='del_group'/>
			<table>
			";
			while ($fila=mysqli_fetch_array($consulta,MYSQLI_NUM)) {
				echo "
				<tr>
					<td class='del_group'>".$fila[1]."</td>
					<td>
						<button type='submit' class='boton_adm' name='id_grupo' value='".$fila[0]."'>Eliminar grupo</button>
					</td>
				</tr>";
			}
			echo "
			</table>
			</form>";
		}
	}
}

elseif (isset($_POST['edit_group'])) {
	if (isset($_POST['id_grupo'])) {
		if (isset($_POST['borrar_usuario'])) {
			$id_grupo=$_POST['id_grupo'];
			$id_usuario=$_POST['borrar_usuario'];
			$sql='delete from usuarios_grupo where id_usuario='.$id_usuario.' and id_grupo='.$id_grupo;
			$consulta=mysqli_query($conexion,$sql);
			if (mysqli_affected_rows($conexion)==1) {
				echo "
				<script type='text/javascript'>window.alert('El usuario ha sido removido del grupo correctamente');
				window.location.assign('admin.php');
				</script>";
			}
			else {
				echo "
				<script type='text/javascript'>window.alert('No se ha podido eliminar al usuario de este grupo, por favor inténtelo de nuevo');
				window.location.assign('admin.php');
				</script>";
			}
		}
		elseif (isset($_POST['add_usu_grupo'])) {
			if (isset($_POST['id'])) {
				$id=$_POST['id'];
				$id_grupo=$_POST['id_grupo'];
				$permisos=$_POST['permisos'];
				$x=0;
				foreach ($id as $id_usuario) {
					$sql='insert into usuarios_grupo values ('.$id_usuario.', '.$id_grupo.', '.$permisos[$x].')';
					if (mysqli_query($conexion,$sql)) {
						echo "
						<script type='text/javascript'>window.alert('Se han añadido correctamente los usuarios al grupo');
						window.location.assign('admin.php');
						</script>";
						$x++;
					}
					else {
						echo "
						<script type='text/javascript'>window.alert('Ha ocurrido un error agregando los usuarios al grupo');
						window.location.assign('admin.php');
						</script>";
						$x++;
					}
				}
			}
			else {
				echo "
				<form action='admin.php' method='post'>
				<input type='hidden' name='edit_group'/>
				<input type='hidden' name='id_grupo' value='".$_POST['id_grupo']."'/>
				<input type='hidden' name='add_usu_grupo'/>
				<h3 class='titulo'>Selecciona los usuarios que quieras añadir al grupo</h3>
				<table>
				";
				$sql_usuarios='select nombre_completo, id from usuarios';
				$consulta_usuarios=mysqli_query($conexion,$sql_usuarios);
				$x=0;
				while ($fila=mysqli_fetch_array($consulta_usuarios,MYSQLI_NUM)) {
					$existe=0;
					$sql_usuarios_grupo='select id from usuarios join usuarios_grupo on usuarios.id=usuarios_grupo.id_usuario where id_grupo='.$_POST['id_grupo'];
					$consulta_usuarios_grupo=mysqli_query($conexion,$sql_usuarios_grupo);
					while ($fila_grupo=mysqli_fetch_array($consulta_usuarios_grupo,MYSQLI_NUM)) {
						if ($fila_grupo[0]==$fila[1]) $existe=1;
					}
					if ($existe==0) {
						echo "
						<tr>
						<td>
							<div class='squaredOne'><input id='squaredOne$x' type='checkbox' value='".$fila[1]."' name='id[]'/>
								<label for='squaredOne$x'></label>
							</div>
						</td>
						<td>$fila[0]</td>
						<td>
							<select name='permisos[]'>
								<option value='1'>Lectura</option>
								<option value='2'>Lectura y escritura</option>
								<option value='3'>Control total</option>
							</select>
						</td>
						</tr>
						";
						$x++;
					}
				}
				echo "
				</table>
				<input class='boton' type='submit' value='Añadir usuarios al grupo'/>
				</form>";
			}
		}
		elseif (isset($_POST['guardar_grupo'])) {
			$cambios=0;
			$nombre_original=$_POST['nombre_original'];
			$nombre_grupo=$_POST['nombre_grupo'];
			if ($nombre_original!=$nombre_grupo) {
				$sql_comprobacion='select * from grupos where nombre_grupo="'.$nombre_grupo.'"';
				$consulta_comprobacion=mysqli_query($conexion,$sql_comprobacion);
				if (mysqli_num_rows($consulta_comprobacion)==0) {
					$sql='update grupos set nombre_grupo="'.$nombre_grupo.'" where id='.$_POST['id_grupo'];
					if (mysqli_query($conexion,$sql)) {
						exec('mv "uploads/groups/'.$nombre_original.'" "uploads/groups/'.$nombre_grupo.'"');
						$cambios++;
						$sql_actualizacion='select ruta from ficheros_grupos where id_grupo='.$_POST['id_grupo'];
						$consulta_actualizacion=mysqli_query($conexion,$sql_actualizacion);
						while ($fila=mysqli_fetch_array($consulta_actualizacion)) {
							$valor=str_replace($nombre_original,$nombre_grupo,$fila[0]);
							$sql_sustitucion='update ficheros_grupos set ruta="'.$valor.'" where id_grupo='.$_POST['id_grupo'].' and ruta="'.$fila[0].'"';
							mysqli_query($conexion,$sql_sustitucion);
						}
					}
				}
			}
			$id_grupo=$_POST['id_grupo'];
			$id_usuario=$_POST['id_usuario'];
			$permiso=$_POST['permiso'];
			$permiso_original=$_POST['permiso_original'];
			$x=0;
			foreach ($id_usuario as $usuario) {
				if ($permiso[$x]!=$permiso_original[$x]) {
					$sql='update usuarios_grupo set permiso='.$permiso[$x].' where id_usuario='.$usuario.' and id_grupo='.$id_grupo;
					mysqli_query($conexion,$sql);
					$cambios++;
				}
				$x++;
			}
			if ($cambios>0) {
				echo "
				<script type='text/javascript'>window.alert('Se han realizado ".$cambios." cambios correctamente');
				window.location.assign('admin.php');
				</script>";
			}
			else echo "
				<script type='text/javascript'>window.alert('No se ha realizado ningún cambio en el grupo');
				window.location.assign('admin.php');
				</script>";
		}
		else {
			echo "
			<form action='admin.php' method='post'>
			<input type='hidden' name='edit_group'/>
			<input type='hidden' name='id_grupo' value='".$_POST['id_grupo']."'/>";
			$sql_nombre='select nombre_grupo from grupos where id='.$_POST['id_grupo'];
			$consulta_nombre=mysqli_query($conexion,$sql_nombre);
			if (mysqli_num_rows($consulta_nombre)) {
				$fila=mysqli_fetch_array($consulta_nombre);
				echo "
				<h3 class='titulo'>Nombre del grupo</h3>
				<label class='titulo'>Modifique el nombre del grupo</label>
				<input type='hidden' name='nombre_original' value='".$fila[0]."'/>
				<input type='text' name='nombre_grupo' value='".$fila[0]."'/>";
			}
			$sql_usuarios='select nombre_completo, permiso, id_usuario from usuarios join usuarios_grupo on usuarios.id=usuarios_grupo.id_usuario where id_grupo='.$_POST['id_grupo'];
			$consulta_usuarios=mysqli_query($conexion,$sql_usuarios);
			if (mysqli_num_rows($consulta_usuarios)) {
				echo "
				<br/>
				<br/>
				<h3 class='titulo'>Usuarios del grupo</h3>
				<table>";
				while ($fila=mysqli_fetch_array($consulta_usuarios)) {
					echo "
					<tr>
						<td>$fila[0]</td>
						<td class='borrar_grupo'>
						<input type='hidden' name='id_usuario[]' value='$fila[2]'/>
						<input type='hidden' name='permiso_original[]' value='$fila[1]'/>
						<select name='permiso[]'>
							<option value='1' ";
							if ($fila[1]==1) echo " selected='selected'";
							echo ">Lectura</option>
							<option value='2'";
							if ($fila[1]==2) echo " selected='selected'";
							echo ">Lectura y escritura</option>
							<option value='3' ";
							if ($fila[1]==3) echo " selected='selected'";
							echo ">Control total</option>
							</select>";
						echo "
						</td>
						<td>
						<button class='boton_adm' type='submit' name='borrar_usuario' value='$fila[2]'>Quitar usuario</button>
						</td>
					</tr>";
				}
				echo "
				</table>
				<input type='submit' class='boton' name='guardar_grupo' value='Guardar cambios'/>
				<input type='submit' class='boton' name='add_usu_grupo' value='Añadir usuarios'/>
				</form>";
			}
		}
	}
	else {
		echo "
		<br/>
		<h3 class='titulo'>Escoja el grupo que desee editar</h3>";
		$sql='select * from grupos';
		$consulta=mysqli_query($conexion,$sql);
		echo "
		<form action='admin.php' method='post'>
		<input type='hidden' name='edit_group'/>
		<table>";
		while ($fila=mysqli_fetch_array($consulta)) {
			echo "
			<tr>
				<td class='del_group'>".$fila[1]."</td>
				<td><button type='submit' class='boton' name='id_grupo' value='".$fila[0]."'>Editar grupo</button></td>
			</tr>";
		}
		echo "
		</table>
		</form>";
	}
}

elseif (isset($_POST['reset_pass'])) {
	if (isset($_POST['id']) && isset($_POST['contrasena']) && isset($_POST['contrasena2'])) {
		$contrasena=$_POST['contrasena'];
		$contrasena2=$_POST['contrasena2'];
		$id=$_POST['id'];
		if ($contrasena==$contrasena2 && strlen($contrasena)>=5) {
			foreach ($id as $usuario) {
				$sql='update usuarios set contrasenia="'.hash('sha256',$contrasena).'" where id='.$usuario;
				mysqli_query($conexion,$sql);
			}
			echo "
				<script type='text/javascript'>window.alert('Las contraseñas han sido cambiadas correctamente');
				window.location.assign('admin.php');
				</script>";
		}
		else echo "
				<script type='text/javascript'>window.alert('No se ha seleccionado ningún usuario o las contraseña no son correctas, por favor revise sus datos.');
				window.location.assign('admin.php');
				</script>";
	}
	else {
		echo "
		<br/>
		<h3 class='titulo'>Selecciona los usuarios a los que desees restablecer la contraseña:</h3>
		";
		$sql='select id, nombre, nombre_completo from usuarios';
		$consulta=mysqli_query($conexion,$sql);
		if (mysqli_num_rows($consulta)) {
			$x=1;
			echo "
			<form method='post' action='admin.php'>
			<input type='hidden' name='reset_pass'/>
			<table>
				<tr>
					<th>Seleccionar</th>
					<th>Nombre usuario</th>
					<th>Nombre completo</th>
				</tr>";
			while ($fila=mysqli_fetch_array($consulta,MYSQLI_NUM)) {
				echo "
				<tr>
					<td>
						<div class='squaredOne'><input id='squaredOne$x' type='checkbox' value='".$fila[0]."' name='id[]'/>
								<label for='squaredOne$x'></label>
						</div>
					</td>
					<td class='derecha'>
						".$fila[1]."
					</td>
					<td class='derecha'>
						".$fila[2]."
					</td>
				</tr>";
				$x++;
			}
			echo "
			</table>
			<table>
				<tr>
					<td class='derecha'><input type='password' name='contrasena' placeholder='Nueva contraseña' pattern='.{5,}' required title='Mínimo 5 caracteres'/></td>
					<td class='derecha'><input type='password' name='contrasena2' placeholder='Repite la contraseña' pattern='.{5,}' required title='Mínimo 5 caracteres'/></td>
				</tr>
			</table>
			<input type='submit' class='boton' value='Cambiar contraseña'/>
			<br/>
			<br/>
			<table class='random'>
				<tr>
					<td>
						<button class='boton' onclick='contrasena()'>Generar contrase&ntilde;a</button>
					</td>
					<td>
						<h3 class='titulo' id='ran_pass'></h3>
					</td>
				</tr>
			</table>
		</form>
		<script>
			function contrasena() {
	    		return Math.random().toString(36).slice(-10);
			}
			document.getElementById('ran_pass').innerHTML = contrasena();
		</script>";
		}
	}
}
elseif (isset($_POST['pro_picture'])) {
	if (isset($_POST['id'])) {
		$id=$_POST['id'];
		$filename  = basename($_FILES['fichero_imagen']['name']);
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$new       = $id.'.'.$extension;
		$target_dir = "img/profile/";
		$target_file = $target_dir . basename($_FILES["fichero_imagen"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["fichero_imagen"]["tmp_name"]);
		    if($check !== false) {
		        echo "El fichero es una imagen - " . $check["mime"] . ".<br/>";
		        $uploadOk = 1;
		    } else {
		        echo "El fichero no es una imagen.<br/>";
		        $uploadOk = 0;
		    }
		}
		// Check file size
		if ($_FILES["fichero_imagen"]["size"] > 1500000) {
		    echo "El fichero es demasiado grande, inténtalo con otra imagen.<br/>";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		    echo "Solo se permiten imagenes jpg, png y jpeg<br/>";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Su fichero no se ha podido subir<br/>";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fichero_imagen"]["tmp_name"], "img/profile/{$new}")) {
		        $sql='update usuarios set img="img/profile/'.$new.'" where id='.$id;
		        mysqli_query($conexion,$sql);
		        echo "
				<script type='text/javascript'>window.alert('La imagen de perfil ha sido cambiada correctamente.');
				window.location.assign('admin.php');
				</script>";
		    } else {
		        echo "
				<script type='text/javascript'>window.alert('No se ha podido cambiar la imagen de perfil');
				window.location.assign('admin.php');
				</script>";
		    }
		}
	}
	else {
		echo "
		<br/>
		<h3 class='titulo'>Escoge el usuario al que cambiar la foto de perfil	</h3>
		";
		$sql='select id, nombre, nombre_completo from usuarios';
		$consulta=mysqli_query($conexion,$sql);
		if (mysqli_num_rows($consulta)) {
			echo "
			<form method='post' action='admin.php' enctype='multipart/form-data'>
			<input type='hidden' name='pro_picture'/>
			<table>
				<tr>
					<th>Seleccionar</th>
					<th>Nombre usuario</th>
					<th>Nombre completo</th>
				</tr>";
			while ($fila=mysqli_fetch_array($consulta,MYSQLI_NUM)) {
				echo "
				<tr>
					<td>
						<input type='radio' value='".$fila[0]."' name='id'/>
					</td>
					<td class='derecha'>
						".$fila[1]."
					</td>
					<td class='derecha'>
						".$fila[2]."
					</td>
				</tr>
				";
			}
			echo "
			</table>
			<label>Selecciona una imagen</label>
			<input type='file' name='fichero_imagen' id='fichero_imagen'/>
			<input type='submit' value='Subir imagen' name='submit'/>
			</form>
			";
		}
	}
}
?>
</div>