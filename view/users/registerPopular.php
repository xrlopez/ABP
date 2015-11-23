<?php 
 //file: view/users/register.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $user = $view->getVariable("user");
 $view->setVariable("title", "Register");
?>
<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Jurado</h2>
			<form id="form-login" action="index.php?controller=users&amp;action=registerPopular" method="POST">
				<label for="usuario">Usuario</label>
					<input name="usuario" class="registrar" type="text" id="usuario" required/></p>

				<label for="nombre">Nombre</label>
					<input name="nombre" class="registrar" type="text" id="nombre" required/ ></p>
												 
				<label for="correo">Correo</label>
					<input name="correo" class="registrar" type="email" id="correo" required/></p>
												 
				<label for="residencia">Residencia</label>
					<input name="residencia" class="registrar" type="text" id="residencia" required/></p>

				<label for="pass">Contraseña</label>
					<input name="pass" class="registrar" type="password" id="pass" required/></p>

				<label for="repass">Repetir contraseña</label>
					<input name="repass" class="registrar" type="password" id="repass" required/></p>

				<p id="bot"><input name="submit" type="submit" id="boton" value="Registrar" class="boton"/></p>
			</form>
	</div>
</div>