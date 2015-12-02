<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/Codigo.php");
 require_once(__DIR__."/../../model/CodigoMapper.php");
 require_once(__DIR__."/../../model/JuradoPopularMapper.php");
  require_once(__DIR__."/../../model/Pincho.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $codigo1 = $view->getVariable("codigo1");
 $codigo2 = $view->getVariable("codigo2");
 $codigo3 = $view->getVariable("codigo3");
 $juradoPopulars = $view->getVariable("jPop");

$pincho1 = $view->getVariable("pincho1");
$pincho2 = $view->getVariable("pincho2");
$pincho3 = $view->getVariable("pincho3");

 $view->setVariable("title", "JuradoPopular");
 
?>

<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Vota por un pincho</h2>
			<form id="votarPincho" action="index.php?controller=juradoPopular&amp;action=votar" method="post" >
				<?php 
			if($pincho1 == $pincho2 AND $pincho2 == $pincho3){ ?>
				<p><input type="radio" name="pincho" value="<?= $codigo1->getId()?>" checked/><?= $pincho1->getNombre() ?></p>
			
			<?php
			}else if($pincho2 == $pincho3){ ?>
				<p><input type="radio" name="pincho" value="<?= $codigo1->getId()?>" checked/><?= $pincho1->getNombre() ?></p>
				<p><input type="radio" name="pincho" value="<?= $codigo2->getId()?>" checked/><?= $pincho2->getNombre() ?></p>
			<?php
			}else if($pincho1 == $pincho2 OR $pincho1 == $pincho3){ ?>
				<p><input type="radio" name="pincho" value="<?= $codigo2->getId()?>" checked/><?= $pincho2->getNombre() ?></p>
				<p><input type="radio" name="pincho" value="<?= $codigo3->getId()?>" checked/><?= $pincho3->getNombre() ?></p>
			<?php
			}else{ ?>
				<p><input type="radio" name="pincho" value="<?= $codigo1->getId()?>" checked/><?= $pincho1->getNombre() ?></p>
				<p><input type="radio" name="pincho" value="<?= $codigo2->getId()?>" checked/><?= $pincho2->getNombre() ?></p>
				<p><input type="radio" name="pincho" value="<?= $codigo3->getId()?>" checked/><?= $pincho3->getNombre() ?></p>
			<?php
			}
			?>

                <input type="hidden" name="usuario" value="<?= $juradoPopulars->getId() ?>"/>
                <p id="bot"><input name="submit" type="submit" id="boton" value="Votar" class="boton"/></p>
            </form>
	</div>
</div>