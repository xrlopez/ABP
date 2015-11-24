<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $juradoProfesionals = $view->getVariable("juradoProfesional");
 
 $view->setVariable("title", "JuradoProfesional");
 
?>

<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Selecciona un miembro del Jurado Profesional para eliminar</h2>
			<form id="asignarPincho" action="index.php?controller=juradoProfesional&amp;action=eliminar" method="post" >
				<?php
				foreach ($juradoProfesionals as $jurado) {
				?>	
					<p><input type="radio" name="usuario" id="usuario" value="<?= $jurado->getId()?>" checked><?php echo $jurado->getNombre() ?></p>
				<?php
				}
				?>
				<p id="bot"><input name="submit" type="submit" id="boton" value="Elegir" class="boton"/></p>
        </form>
	</div>
</div>
