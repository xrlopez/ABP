<?php 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/Organizador.php");
 require_once(__DIR__."/../../model/OrganizadorMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $organizador = $view->getVariable("organizador");
 
 
?>

<div class="row registrarE">
<div class="divLogin col-xs-12 col-sm-12 col-md-12">
    <h2>Organizador</h2>
    <form id="form-aceptar" method="POST" action="index.php?controller=organizador&amp;action=eliminar">
	    <div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
			    	Usuario:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $organizador->getId()?>  
		    	</div>
	    	</div>
	    	<div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Nombre:
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $organizador->getNombre()?>  
		    	</div>
	    	</div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Correo:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $organizador->getEmail()?>  
		    	</div>
		    </div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Descripción:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $organizador->getDescripcionOrga()?>  
		    	</div>
		    </div>
	    </div>
	    <div class="divFormulario">
	    	<p id="bot"><a href="index.php?controller=juradoPopular&amp;action=modificar">Modificar</a></p>
			<p id="bot"><a href="#" onclick="if (confirm('estas seguro?')) {document.getElementById('form-aceptar').submit()}">Eliminar</a></p>
		</div>
    </form>
    </div>
</div>
