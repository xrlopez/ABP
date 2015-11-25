<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$pinchos = $view->getVariable("pinchos");
$premio = $view->getVariable("premio");
?>

<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Elige el pincho a premiar</h2>
			<?php 
				if($pinchos!=NULL){?>
					<form id="asignarPinchos2" action="index.php?controller=premios&amp;action=asignar" method="post" >
						<?php
						foreach($pinchos as $pincho) {
						?>
						<p><input type="radio" name="id_pincho" id="id_pincho" value="<?= $pincho->getId() ?>" checked><?php echo $pincho->getNombre() ." por ". $pincho->getNombreEstablecimiento() . " con " . $pincho->getVotos() . " votos. "?></p>
						<?php
						}
						?>
	 				    <input type="hidden" name="id_premio" id="id_premio" value="<?= $premio->getId()?>">
	 				    <label for="posicion">Posición:</label>
						<input name="posicion" class="registrar" type="posicion" id="posicion" required/></p>      				 
	                    <p id="bot"><input name="submit" type="submit" id="boton" value="Validar" class="boton"/></p>
	                </form>
				<?php }else{ ?>
					<p>No hay pinchos que asignar a <?=$jurado->getId()?></p>
				<?php }
			?>
	</div>
</div>
