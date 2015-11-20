<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $concursos = $view->getVariable("concursos");
 $currentuser = $view->getVariable("currentusername");
 
 $view->setVariable("title", "Concurso");
 
?>

<div class="row">
	<div class="informacion col-xs-12 col-sm-12 col-md-12">
		<h2>Informacion del concurso</h2>
		<?= isset($errors["general"])?$errors["general"]:"" ?>
		<?php foreach ($concursos as $concurso): ?>
			<p><?= $concurso->getDescripcionConcurso()?></p>
		<?php endforeach; ?>
	</div>
</div>
