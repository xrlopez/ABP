<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/Establecimiento.php");
 require_once(__DIR__."/../../model/EstablecimientoMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $Establecimiento = $view->getVariable("Establecimiento");
 $errors = $view->getVariable("errors");
 
 
?>
<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Establecimiento</h2>
			<div>
				<form id="form-aceptar" action="index.php?controller=Establecimiento&amp;action=update" method="post" >
					<label for="usuario">Usuario</label><?= isset($errors["usuario"])?$errors["usuario"]:"" ?>
						<input name="usuario" class="registrar" type="text" id="usuario" readonly = "readonly" value="<?= $Establecimiento->getId()?>"/ ></p>
						
					<label for="nombre">Nombre</label><?= isset($errors["nombre"])?$errors["nombre"]:"" ?>
	                    <input name="nombre" class="registrar" type="text" id="nombre" value="<?= $Establecimiento->getNombre()?> "/ ></p>
					                    				 
	                <label for="correo">Correo</label><?= isset($errors["correo"])?$errors["correo"]:"" ?>
	                    <input name="correo" class="registrar" type="text" id="correo" value="<?= $Establecimiento->getEmail()?>"/></p>
					
					<label for="localizacion">Direccion</label><?= isset($errors["residencia"])?$errors["residencia"]:"" ?>
	                    <input name="residencia" class="registrar" type="text" id="residencia" value="<?= $Establecimiento->getLocalizacion()?>"/></p>
						
					<label for="descripcion">Descripcion</label><?= isset($errors["descripcion"])?$errors["residencia"]:"" ?>
						<input name="descripcion" class="registrar" type="text" id="descripcion" value="<?= $Establecimiento->getDescripcion()?>"/></p>
						
					<label for="pass">Contraseña actual</label><?= isset($errors["passActual"])?$errors["passActual"]:"" ?>
	                    <input name="passActual" class="registrar" type="password" id="passActual" / ></p>

	                <label for="pass">Contraseña nueva</label>
	                    <input name="passNew" class="registrar" type="password" id="passNew"/ ></p>

	                <label for="repass">Repetir contraseña nueva</label>
	                    <input name="passNueva" class="registrar" type="password" id="passNueva"/></p>

	                <p id="bot"><input name="submit" type="submit" id="boton" value="Aceptar" class="boton"/></p>
				</form>
			</div>
			<div class="divFormulario">
	    		<p id="bot"><a href="index.php?controller=Establecimiento&amp;action=perfil">Cancelar</a></p>
			</div>
	</div>
</div>