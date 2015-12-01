<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/JuradoProfesional.php");
 require_once(__DIR__."/../../model/JuradoProfesionalMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $juradoProfesional = $view->getVariable("juradoPro");
 $errors = $view->getVariable("errors");
 
 
?>
<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Jurado Profesional</h2>
			<div>
				<form id="form-aceptar" action="index.php?controller=juradoProfesional&amp;action=update" method="post" >
					
					<label for="usuario">Usuario</label></br>
						<input name="usuario" class="registrar" type="text" id="usuario" readonly = "readonly" value="<?= $juradoProfesional->getId()?>"/ ></p>
						
					<label for="nombre">Nombre</label>
	                    <input name="nombre" class="registrar" type="text" id="nombre" value="<?= $juradoProfesional->getNombre()?> "/ ></p>
					                    				 
	                <label for="correo">Correo</label>
	                    <input name="correo" class="registrar" type="email" id="correo" value="<?= $juradoProfesional->getEmail()?>"/></p>
					
					<label for="profesion">Profesion</label>
	                    <input name="profesion" class="registrar" type="text" id="profesion" value="<?= $juradoProfesional->getProfesion()?>"/></p>
										
					<label for="organizador">Organizador</label>
	                    <input name="organizador" class="registrar" type="text" id="organizador" readonly = "readonly" value="<?= $juradoProfesional->getOrganizador()?>"/></p>
						
					<label for="passActual">Contraseña actual</label><label style="color:red">*</label><p class="error"><?= isset($errors["passActual"])?$errors["passActual"]:"" ?></p>
	                    <input name="passActual" class="registrar" type="password" id="passActual" required/ ></p>

	                <label for="passNueva">Contraseña nueva</label><p class="error"><?= isset($errors["pass"])?$errors["pass"]:"" ?></p>
	                    <input name="passNueva" class="registrar" type="password" id="passNueva"/ ></p>

	                <label for="passNew">Repetir contraseña nueva</label>
	                    <input name="passNew" class="registrar" type="password" id="passNew"/></p>

	                <p id="bot"><input name="submit" type="submit" id="boton" value="Aceptar" class="boton"/></p>
				</form>
			</div>
			<div class="divFormulario">
	    		<p id="bot"><a href="index.php?controller=juradoProfesional&amp;action=perfil">Cancelar</a></p>
			</div>
	</div>
</div>