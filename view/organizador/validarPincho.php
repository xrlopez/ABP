<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$pinchos = $view->getVariable("pinchos");


?>



    <div class="row registrarE">
		<div class="divLogin col-xs-12 col-sm-12 col-md-12">
			<h2>Valida los pinchos</h2>
<?php
foreach ($pinchos as $pincho) {
?>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<?php echo $pincho->getNombre() ?>
					
					</div>	
					<div class="col-xs-2 col-sm-2 col-md-2">
						<form method="post" action="index.php?controller=pinchos&amp;action=validarPincho" onclick="target='_self'">
							<input type="hidden" name="pinchoID" id="pinchoID" value="<?= $pincho->getId()?>"> 
							<input type="submit" name="boton" value="&#x2714;" />
						</form>	
					</div>	
					<div class="col-xs-2 col-sm-2 col-md-2">
						<form method="post" action="index.php?controller=pinchos&amp;action=eliminar" onclick="target='_self'">
							<input type="hidden" name="pinchoID" id="pinchoID" value="<?= $pincho->getId()?>"> 
							<input type="submit" name="boton" value="&#x2718;" />
						</form>
					</div>	
				</div>

<?php	
}
?>
		    </div>
    	</div>
	
				