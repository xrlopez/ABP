<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$pinchos = $view->getVariable("pinchos");
$pinchosAsignados = $view->getVariable("pinchosAsignados");
$jurado = $view->getVariable("jurado");

?>

		<div class="row registrarE">
			<div class="divLogin col-xs-12 col-sm-12 col-md-12">
				<h2>Introduce los pinchos a asignar a <?php echo $jurado->getNombre() ?></h2>
					<?php 
						if($pinchos!=NULL){?>
							<form id="asignarPinchos2" action="index.php?controller=organizador&amp;action=asignarPinchos" method="post" >
								<?php
								foreach($pinchos as $pincho) {
								?>

			                    <p><input type="checkbox" name="selectedPinchos[]" value="<?= $pincho->id_pincho ?>"><?php echo $pincho->nombre ?></i></p>

								<?php
								}
								?>
			 				    <input type="hidden" name="usuario" id="usuario" value="<?= $jurado->getId()?>">       				 
			                    <p id="bot"><input name="submit" type="submit" id="boton" value="Validar" class="boton"/></p>
			                </form>
						<?php }else{ ?>
							<p> <i style="color:red;font-size:20px;"> No hay pinchos que asignar a <?=$jurado->getId()?></i></p>
						<?php }
					?>
				<h2>Pinchos asignados</h2>
					<?php 
						if($pinchosAsignados!=NULL){?>
							<?php foreach($pinchosAsignados as $pinchoAsignado) { ?>
									<p><?php echo $pinchoAsignado->nombre ?></p>
							<?php } ?>
						<?php }else{ ?>
							<p><i style="color:red;font-size:20px;">No hay pinchos asignados a <?=$jurado->getNombre()?></i></p>
						<?php }
					?>
					<form id="asignarPinchos2" action="index.php?controller=organizador&action=asignar" method="post" >
			 						 
			            <p id="bot"><input name="submit" type="submit" id="boton" value="Atras" class="boton"/></p>
			        </form>
			</div>
		</div>
