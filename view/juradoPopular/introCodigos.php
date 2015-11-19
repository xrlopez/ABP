<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $juradoPopulars = $view->getVariable("juradoPopular");
 
 $view->setVariable("title", "JuradoPopular");
 
?>


<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Introduce los códigos de los pinchos</h2>
			<form id="form-login" action="#" method="post" >
                <label for="pincho1">Pincho 1</label>
                    <input name="pincho1" class="registrar" type="text"/ ></p>

                <label for="pincho2">Pincho 2</label>
                    <input name="pincho2" class="registrar" type="text"/></p>

                <label for="pincho3">Pincho 3</label>
                    <input name="pincho3" class="registrar" type="text"/></p>
				                    				 
                <p id="bot"><input name="submit" type="submit" id="boton" value="Introducir" class="boton"/></p>
            </form>
	</div>
</div>