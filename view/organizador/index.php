<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $organizadores = $view->getVariable("organizador");
 
 $view->setVariable("title", "Organizador");
 
?>

<div class="row">
	<div class="informacion col-xs-12 col-sm-12 col-md-12">
		<h2>Informacion del concurso</h2>
		<?= isset($errors["general"])?$errors["general"]:"" ?>
		<?php foreach ($organizadores as $organizador): ?>
			<p><?= $organizador->getId()?></p>
		<?php endforeach; ?>
		<a href="index.php?controller=organizador&action=asignar">Asignar pinchos al jurado profesional</a>
	</div>
</div>
