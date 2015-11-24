<?php 
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 $pincho = $view->getVariable("pincho");
 $errors = $view->getVariable("errors");
?>
<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Pincho</h2>
			<form id="form-login" action="index.php?controller=establecimiento&amp;action=modificarPincho" method="POST">
				<label for="nombre">Nombre</label>
					<input name="nombre" class="registrar" type="text" id="nombre" value="<?= $pincho->getNombre()?>" required/></p>
												 
				<label for="descripcion">Descripcion</label>
					<input name="descripcion" class="registrar" type="text" id="descripcion" value="<?= $pincho->getDescripcion()?>" required/></p>
				<label for="celiaco">Celiaco</label>
					<input name="celiaco" class="registrar" type="checkbox" id="celaico"/></p>
					
				<!--<label for="ingredientes">Ingredientes </label>
					<input name="ingredientes" class="registrar" type="text" id="ingredientes" required/ ></p>-->
												 
				<p id="bot"><input name="submit" type="submit" id="boton" value="Modificar" class="boton"/></p>
			</form>
			<form id="form-delete" action="index.php?controller=establecimiento&amp;action=eliminarPincho" method="POST">
				<p id="bot"><a href="#" onclick="if (confirm('estas seguro?')) {document.getElementById('form-delete').submit()}">Eliminar</a></p>
			</form>
	</div>
</div>
