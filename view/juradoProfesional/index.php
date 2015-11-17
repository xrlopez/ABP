<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $juradoProfesionals = $view->getVariable("juradoProfesional");
 
 $view->setVariable("title", "JuradoProfesional");
 
?>

<div class="row">
	<div class="informacion col-xs-12 col-sm-12 col-md-12">
		<h2>Informacion del jurado profesional</h2>
		<?= isset($errors["general"])?$errors["general"]:"" ?>
		<?php foreach ($juradoProfesionals as $juradoProfesional): ?>
			<p><?= $juradoProfesional->getId()?></p>
		<?php endforeach; ?>
	</div>
</div>
