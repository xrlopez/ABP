<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$premios = $view->getVariable("premios");
$tipo = $view->getVariable("tipo");


?>

<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Selecciona un premio a asignar</h2>
			<form id="asignarPincho" action="index.php?controller=premios&amp;action=<?= $tipo ?>" method="post" >
				<?php
				foreach ($premios as $premio) {
				?>	
					<p><input type="radio" name="id_premio" id="id_premio" value="<?= $premio->getId()?>" checked><?php echo $premio->getId() ."-". $premio->getTipo() ?></p>
				<?php
				}
				?>
				<p id="bot"><input name="submit" type="submit" id="boton" value="Elegir" class="boton"/></p>
        </form>
	</div>
</div>


