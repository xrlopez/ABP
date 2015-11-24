<?php 
 //file: view/users/register.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 $establecimiento = $view->getVariable("establecimiento");
 $errors = $view->getVariable("errors");
 $user = $view->getVariable("user");
 $view->setVariable("title", "Register");
?>
<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Pincho</h2>
			<form id="form-login" action="index.php?controller=pinchos&amp;action=register" method="POST">
				<label for="nombre">Nombre</label>
					<input name="nombre" class="registrar" type="text" id="nombre" required/></p>
												 
				<label for="celiaco">Celiaco</label>
					<input name="celiaco" class="registrar" type="checkbox" id="celaico"/></p>
					
				<!--<label for="ingredientes">Ingredientes </label>
					<input name="ingredientes" class="registrar" type="text" id="ingredientes" required/ ></p>-->
												 
				<p id="bot"><input name="submit" type="submit" id="boton" value="Registrar" class="boton"/></p>
			</form>
	</div>
</div>
