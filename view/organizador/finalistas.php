<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/Organizador.php");
 require_once(__DIR__."/../../model/OrganizadorMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $votos = $view->getVariable("votos");
 $ronda = $view->getVariable("ronda");
 
?>

<div class="row">
	<h2>Elegir finalistas</h2>
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<form class="votarPincho" action="index.php?controller=organizador&amp;action=guardarFinalistas" method="post">
			<input type="number" name="quantity" min="1" max="99">
			<input type="submit" name="finalistas" value="Aceptar"/>
		</form>
		
	</div>
</div>