<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/Establecimiento.php");
 require_once(__DIR__."/../../model/EstablecimientoMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $establecimiento = $view->getVariable("establecimiento");
 $errors = $view->getVariable("errors");
 
 
?>
<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Establecimiento</h2>
			<div>
				<form id="form-aceptar" action="index.php?controller=establecimiento&amp;action=update" method="post" >
					<label for="usuario">Usuario</label><?= isset($errors["usuario"])?$errors["usuario"]:"" ?>
						<input name="usuario" class="registrar" type="text" id="usuario" readonly = "readonly" value="<?= $establecimiento->getId()?>"/ ></p>
						
					<label for="nombre">Nombre</label><?= isset($errors["nombre"])?$errors["nombre"]:"" ?>
	                    <input name="nombre" class="registrar" type="text" id="nombre" value="<?= $establecimiento->getNombre()?> "/ ></p>
					                    				 
	                <label for="correo">Correo</label><?= isset($errors["correo"])?$errors["correo"]:"" ?>
	                    <input name="correo" class="registrar" type="email" id="correo" value="<?= $establecimiento->getEmail()?>"/></p>
					
					<label for="localizacion">Localización</label><?= isset($errors["localizacion"])?$errors["localizacion"]:"" ?>
	                    <input name="localizacion" class="registrar" type="text" id="localizacion" value="<?= $establecimiento->getLocalizacion()?> "/></p>
						
					<label for="descripcion">Descripcion</label><?= isset($errors["descripcion"])?$errors["descripcion"]:"" ?>
						<input name="descripcion" class="registrar" type="text" id="descripcion" value="<?= $establecimiento->getDescripcion()?>"/></p>
						
					<label for="pass">Contraseña actual</label><?= isset($errors["passActual"])?$errors["passActual"]:"" ?>
	                    <input name="passActual" class="registrar" type="password" id="passActual" required/ ></p>

	                <label for="pass">Contraseña nueva</label>
	                    <input name="passNew" class="registrar" type="password" id="passNew"/ ></p>

	                <label for="repass">Repetir contraseña nueva</label>
	                    <input name="passNueva" class="registrar" type="password" id="passNueva"/></p>

	                <p id="bot"><input name="submit" type="submit" id="boton" value="Aceptar" class="boton"/></p>
				</form>
			</div>
			<div class="divFormulario">
	    		<p id="bot"><a href="index.php?controller=establecimiento&amp;action=perfil">Cancelar</a></p>
			</div>
	</div>
</div>