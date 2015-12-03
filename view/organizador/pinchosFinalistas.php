<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/Organizador.php");
 require_once(__DIR__."/../../model/OrganizadorMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $pinchos = $view->getVariable("pinchos");
 
 
?>

<div class="row">
	<h2>Pinchos finalistas</h2>
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<?php
		foreach($pinchos as $pincho) {
		?>
        <p><a href="index.php?controller=pinchos&amp;action=pinchoEspecifico&amp;id=<?= $pincho->getID() ?>"><?php echo $pincho->nombre ?></a></p>

		<?php
		}
		?>
	</div>
</div>