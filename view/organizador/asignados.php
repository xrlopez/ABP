<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $pinchos = $view->getVariable("pinchos");
 $jurado = $view->getVariable("jurado");

 
?>

<div class="row">
	<div class="informacion col-xs-12 col-sm-12 col-md-12">
		<h2>Pinchos asignados a <?php echo $jurado->getNombre() ?></h2>
		<?= isset($errors["general"])?$errors["general"]:"" ?>
		<?php
		if($pinchos!=null){
		 foreach ($pinchos as $pincho): ?>
			<p><?= $pincho->nombre?></p>
		<?php endforeach; 
		}else{?>
			<p>No se ha seleccionado ningun pincho.</p>
		<?php }?>
	</div>
</div>
