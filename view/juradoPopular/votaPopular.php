<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/Codigo.php");
 require_once(__DIR__."/../../model/CodigoMapper.php");
 require_once(__DIR__."/../../model/JuradoPopularMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $codigo1 = $view->getVariable("codigo1");
 $codigo2 = $view->getVariable("codigo2");
 $codigo3 = $view->getVariable("codigo3");
 $juradoPopulars = $view->getVariable("jPop");

 $view->setVariable("title", "JuradoPopular");
 
?>

<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Vota por un pincho</h2>
			<form id="votarPincho" action="index.php?controller=juradoPopular&amp;action=votar" method="post" >
				<p><input type="radio" name="pincho" value="<?= $codigo1->getId()?>" checked/><?= $codigo1->getId()?></p>
				<p><input type="radio" name="pincho" value="<?= $codigo2->getId()?>" checked/><?= $codigo2->getId()?></p>
				<p><input type="radio" name="pincho" value="<?= $codigo3->getId()?>" checked/><?= $codigo3->getId()?></p>
                <input type="hidden" name="usuario" value="<?= $juradoPopulars->getId() ?>"/>
                <p id="bot"><input name="submit" type="submit" id="boton" value="Votar" class="boton"/></p>
            </form>
	</div>
</div>