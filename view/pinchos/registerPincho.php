<?php 
 //file: view/users/register.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 $errors = $view->getVariable("errors");
 $user = $view->getVariable("user");
 $view->setVariable("title", "Register");
?>
<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Pincho</h2>
			<form id="form-login" action="index.php?controller=pinchos&amp;action=register" method="POST">
				<label for="nombre">Nombre</label>
					<input name="nombre" class="registrar" type="text" id="nombre"/ ></p>
												 
				<label for="descripcion">Descripción</label>
					<input name="descripcion" class="registrar" type="boolean" id="descripcion"/></p>

				<label for="celiaco">Celiaco</label>
					<input name="celiaco" type="checkbox" id="celiaco"/></p>
												 
				<p id="bot"><input name="submit" type="submit" id="boton" value="Registrar" class="boton"/></p>
			</form>
	</div>
</div>
