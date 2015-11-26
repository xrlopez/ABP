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
		<h2>Jurado Profesional</h2>
			<form id="form-login" action="index.php?controller=premios&amp;action=register" method="POST">
				<label for="id_premio">ID premio</label>
					<input name="id_premio" class="registrar" type="text" id="id_premio" required/></p>
				<label for="tipo">Tipo</label>
					<SELECT NAME="tipo" class="registrar" SIZE="1" required> 
					   <OPTION VALUE="popular">Popular</OPTION> 
					   <OPTION VALUE="profesional">Profesional</OPTION> 
					</SELECT>
				<p id="bot"><input name="submit" type="submit" id="boton" value="Registrar" class="boton"/></p>
			</form>
	</div>
</div>
