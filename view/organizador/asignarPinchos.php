<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$pinchos = $view->getVariable("pinchos");
$jurado = $view->getVariable("jurado");

?>

		<div class="row registrarE">
			<div class="divLogin col-xs-12 col-sm-12 col-md-12">
				<h2>Introduce los pinchos a asignar</h2>

					<form id="asignarPinchos2" action="index.php?controller=organizador&amp;action=asignarPinchos" method="post" >
						<?php
						foreach($pinchos as $pincho) {
						?>

	                    <p><input type="checkbox" name="selectedPinchos[]" value="<?= $pincho->id_pincho ?>"checked><?php echo $pincho->nombre ?></p>

						<?php
						}
						?>
	 				    <input type="hidden" name="usuario" id="usuario" value="<?= $jurado->getId()?>">       				 
	                    <p id="bot"><input name="submit" type="submit" id="boton" value="Validar" class="boton"/></p>
	                </form>
			</div>
		</div>
