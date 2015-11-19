<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/JuradoPopular.php");
 require_once(__DIR__."/../../model/JuradoPopularMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $juradoPopular = $view->getVariable("juradoPop");
 $errors = $view->getVariable("errors");
 
 
?>
<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Jurado Popular</h2>
			<div>
				<form id="form-aceptar" action="index.php?controller=juradoPopular&amp;action=update" method="post" >
					<label for="usuario">Usuario</label><?= isset($errors["usuario"])?$errors["usuario"]:"" ?>
						<input name="usuario" class="registrar" type="text" id="usuario" readonly = "readonly" value="<?= $juradoPopular->getId()?>"/ ></p>
						
					<label for="nombre">Nombre</label><?= isset($errors["nombre"])?$errors["nombre"]:"" ?>
	                    <input name="nombre" class="registrar" type="text" id="nombre" value="<?= $juradoPopular->getNombre()?> "/ ></p>
					                    				 
	                <label for="correo">Correo</label><?= isset($errors["correo"])?$errors["correo"]:"" ?>
	                    <input name="correo" class="registrar" type="text" id="correo" value="<?= $juradoPopular->getEmail()?>"/></p>
					
					<label for="residencia">Residencia</label><?= isset($errors["residencia"])?$errors["residencia"]:"" ?>
	                    <input name="residencia" class="registrar" type="text" id="residencia" value="<?= $juradoPopular->getResidencia()?>"/></p>
						
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
	    		<p id="bot"><a href="index.php?controller=juradoPopular&amp;action=perfil">Cancelar</a></p>
			</div>
	</div>
</div>