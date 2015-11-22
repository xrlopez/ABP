<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $establecimiento = $view->getVariable("esta");
 
 $view->setVariable("title", "Establecimiento");
 
?>

<div class="row">
	<div class="informacion col-xs-12 col-sm-12 col-md-12">
		<h2>Informacion del Establecimiento</h2>
		<div class="establecimientos col-xs-12 col-sm-12 col-md-5">
					<p><h2><a href="index.php?controller=establecimiento&amp;action=findPincho&amp;id=<?= $establecimiento->getId() ?>"><?= $establecimiento->getNombre()?></a></h2></p>
					<p class="des"><?= $establecimiento->getdescripcion()?></p>
					</br><p>Informacion:</p>
					<p class="des">Direccion: <?= $establecimiento->getLocalizacion()?></p>
					<p class="des">Contacto: <?= $establecimiento->getEmail()?></p>
		</div>
	</div>
</div>
