<?php 

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $juradoPop = $view->getVariable("juradoPop");
 $pinchos = $view->getVariable("pinchos");
 
 $view->setVariable("title", "Establecimientos");
 
?>

<div class="row">
		<h2>Pinchos probados</h2>
		<?= isset($errors["general"])?$errors["general"]:"" ?>
		<div class="establecimientos col-xs-12 col-sm-12 col-md-5">
			<?php 
			if($pinchos!=null){
			foreach ($pinchos as $pincho): ?>
				<form action="index.php?controller=juradoPopular&amp;action=comentar" method="post">
					<input name="usuario" type="hidden" value="<?= $juradoPop->getId()?> "/ >
					<input name="pincho" type="hidden" value="<?= $pincho->getId()?> "/ >
					<span class="desd"><a href="index.php?controller=pinchos&amp;action=pinchoEspecifico&amp;id=<?= $pincho->getId()?>"><?= $pincho->getNombre()?></a></span>
	                <span id="bot"><input name="submit" type="submit" id="boton" value="Comentar" class="boton"/></span>
				</form>
			<?php endforeach; 
			}else{?>
				<span>No has probado ningun pincho</span>
			<?php }?>
		</div>
</div>