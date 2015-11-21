<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $establecimientos = $view->getVariable("establecimiento");
 
 $view->setVariable("title", "Establecimiento");
 
?>

<div class="row">
	<div class="informacion col-xs-12 col-sm-12 col-md-12">
		<h2>Informacion del Establecimiento</h2>
		<?= isset($errors["general"])?$errors["general"]:"" ?>
		<?php foreach ($establecimientos as $establecimiento): ?>
			<p><?= $establecimiento->getId()?></p>
		<?php endforeach; ?>
	    	<p id="bot"><a href="index.php?controller=establecimiento&amp;action=generarCodigos">Generar codigos</a></p>
	</div>
</div>
