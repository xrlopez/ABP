<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $errors = $view->getVariable("errors");
 $currentuser = $view->getVariable("currentusername");
 $juradoPopulars = $view->getVariable("juradoPop");
 
 $view->setVariable("title", "JuradoPopular");
 
?>


<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Introduce los códigos de los pinchos</h2>
			<form id="form-login" action="index.php?controller=juradoPopular&amp;action=addCodigos" method="post" >
                <p class="error"><?= isset($errors["pincho"])?$errors["pincho"]:"" ?></p>
                <label for="pincho1">Pincho 1</label><p class="error"><?= isset($errors["pincho1"])?$errors["pincho1"]:"" ?></p>
                    <input name="pincho1" class="registrar" type="text" id="pincho1" required/></p>

                <label for="pincho2">Pincho 2</label><p class="error"><?= isset($errors["pincho2"])?$errors["pincho2"]:"" ?></p>
                    <input name="pincho2" class="registrar" type="text" id="pincho2" required/></p>

                <label for="pincho3">Pincho 3</label><p class="error"><?= isset($errors["pincho3"])?$errors["pincho3"]:"" ?></p>
                    <input name="pincho3" class="registrar" type="text" id="pincho3" required/></p>
				                    				 
                <p id="bot">
                    <input type="hidden" name="usuario" value="<?= $juradoPopulars->getId() ?>"/>
                    <input name="submit" type="submit" id="boton" value="Introducir" class="boton"/>
                </p>
            </form>
	</div>
</div>