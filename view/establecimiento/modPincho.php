<?php 
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 $pincho = $view->getVariable("pincho");
 $errors = $view->getVariable("errors");
?>
<div class="row divInfo">
	<div class="divLogin col-xs-6 col-sm-6 col-md-6">
		<h2>Pincho</h2>
			<form enctype="multipart/form-data" id="form-login" action="index.php?controller=establecimiento&amp;action=modificarPincho" method="POST">
				<label for="nombre">Nombre</label>
					<input name="nombre" class="registrar" type="text" id="nombre" value="<?= $pincho->getNombre()?>" required/>
												 
				<label for="descripcion">Descripcion</label>
					<input name="descripcion" class="registrar" type="text" id="descripcion" value="<?= $pincho->getDescripcion()?>" required/>
				<label for="celiaco">Celiaco</label>
					<input name="celiaco" class="registrar" type="checkbox" id="celaico"/>
					
				<label for="ingredientes">Ingredientes </label>
				<?php $ingredientes = $pincho->getIngredientes();
						foreach($ingredientes as $ingrediente){ ?>
							<input name="ingredientesSelected[]" class="registrar" type="text" id="ingredientesSelected[]" value="<?= $ingrediente->getIngrediente()?>"/>

				<?php	}	?>
					<input name="ingredientesSelected[]" class="registrar" type="text" id="ingredientesSelected[]" />
					<input name="ingredientesSelected[]" class="registrar" type="text" id="ingredientesSelected[]" />
					<input name="ingredientesSelected[]" class="registrar" type="text" id="ingredientesSelected[]" />

				<label for="imagen">Imagen</label>
					<input type="file" name="img" id="imagen" size="70"/>
												 
				<p id="bot"><input name="submit" type="submit" id="boton" value="Modificar" class="boton"/></p>
			</form>
			<form id="form-delete" action="index.php?controller=establecimiento&amp;action=eliminarPincho" method="POST">
				<p id="bot"><a href="#" onclick="if (confirm('estas seguro?')) {document.getElementById('form-delete').submit()}">Eliminar</a></p>
			</form>
	</div>
	<div class ="col-xs-6 col-sm-6 col-md-6">
		<img class="imagen" src="imagenes/pincho_<?= $pincho->getImagen() ?>" alt="imagenPincho" width="300px">
	</div>
</div>
