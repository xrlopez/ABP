<?php 

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $juradoPop = $view->getVariable("juradoPop");
 $pincho = $view->getVariable("pincho");
 $comentario = $view->getVariable("comentario");
 
 $view->setVariable("title", "Establecimientos");
 
?>

<div class="row">
		<h2>Comentar pincho</h2>
		<?= isset($errors["general"])?$errors["general"]:"" ?>
		<div class="comentarios col-xs-12 col-sm-12 col-md-10">
			<form action="index.php?controller=juradoPopular&amp;action=comentar" method="post">
				<span><a href="index.php?controller=pinchos&amp;action=pinchoEspecifico&amp;id=<?= $pincho->getId()?>"><?= $pincho->getNombre()?></a></span>
                <p><input name="usuario" type="hidden" value="<?= $juradoPop->getId()?> "/ ></p>
				<p><input name="pincho" type="hidden" value="<?= $pincho->getId()?> "/ ></p>
				<?php if($comentario!=null){ ?>
					<textarea name="coment" rows="7" cols="40" required><?= $comentario ?></textarea>
				<?php }else{ ?>
				<textarea name="coment" rows="7" cols="40" placeholder="comentario..." required></textarea>
				<?php } ?>
                <p><input name="submit" type="submit" id="boton" value="Comentar" class="boton"/></p>
	                <a href="index.php?controller=juradoPopular&amp;action=comentar">Cancelar</a>
			</form>
		</div>
</div>