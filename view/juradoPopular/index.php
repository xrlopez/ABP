<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $juradoPopulars = $view->getVariable("juradoPopular");
 
 $view->setVariable("title", "JuradoPopular");
 
?>

<div class="row">
	<div class="informacion col-xs-12 col-sm-12 col-md-12">
		<h2>Informacion del jurado popular</h2>
		<?= isset($errors["general"])?$errors["general"]:"" ?>
		<?php foreach ($juradoPopulars as $juradoPopular): ?>
			<p><?= $juradoPopular->getId()?></p>
		<?php endforeach; ?>
	</div>
</div>
