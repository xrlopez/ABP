<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $juradoPopulars = $view->getVariable("juradoPopular");
 
 $view->setVariable("title", "JuradoPopular");
 
?>

<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Vota por un pincho</h2>
			<form id="votarPincho" action="#" method="post" >
                <p><input type="radio" name="votarPincho" checked> Pincho 1</p>
                <p><input type="radio" name="votarPincho">  Pincho 2</p>
                <p><input type="radio" name="votarPincho" checked> Pincho 3</p>
				                    				 
                <p id="bot"><input name="submit" type="submit" id="boton" value="Votar" class="boton"/></p>
            </form>
	</div>
</div>