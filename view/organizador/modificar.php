<?php 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/Organizador.php");
 require_once(__DIR__."/../../model/OrganizadorMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $organizador = $view->getVariable("organizador");
 $errors = $view->getVariable("errors");
 
 
?>
<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Organizador</h2>
			<div>
				<form id="form-aceptar" action="index.php?controller=organizador&amp;action=update" method="post" >
					<label for="usuario">Usuario</label>
						<input name="usuario" class="registrar" type="text" id="usuario" readonly = "readonly" value="<?= $organizador->getId()?>"/ ></p>
						
					<label for="nombre">Nombre</label>
	                    <input name="nombre" class="registrar" type="text" id="nombre" value="<?= $organizador->getNombre()?> "/ ></p>
					                    				 
	                <label for="correo">Correo</label>
	                    <input name="correo" class="registrar" type="email" id="correo" value="<?= $organizador->getEmail()?>"/></p>
					
					<label for="descripcion">Descripción</label>
	                    <input name="descripcion" class="registrar" type="text" id="descripcion" value="<?= $organizador->getDescripcionOrga()?>"/></p>
						
					<label for="pass">Contraseña actual</label><p class="error"><?= isset($errors["passActual"])?$errors["passActual"]:"" ?></p>
	                    <input name="passActual" class="registrar" type="password" id="passActual" / required></p>

	                <label for="pass">Contraseña nueva</label><p class="error"><?= isset($errors["pass"])?$errors["pass"]:"" ?></p>
	                    <input name="passNew" class="registrar" type="password" id="passNew"/ ></p>

	                <label for="repass">Repetir contraseña nueva</label>
	                    <input name="passNueva" class="registrar" type="password" id="passNueva"/></p>

	                <p id="bot"><input name="submit" type="submit" id="boton" value="Aceptar" class="boton"/></p>
				</form>
			</div>
			<div class="divFormulario">
	    		<p id="bot"><a href="index.php?controller=organizador&amp;action=perfil">Cancelar</a></p>
			</div>
	</div>
</div>
