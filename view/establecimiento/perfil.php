<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/Establecimiento.php");
 require_once(__DIR__."/../../model/Pincho.php");
 require_once(__DIR__."/../../model/EstablecimientoMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $establecimiento = $view->getVariable("establecimiento");
 $pincho = $view->getVariable("pinchoEstab");
 
 
?>

<div class="row registrarE">
<div class="divLogin col-xs-12 col-sm-12 col-md-12">
    <h2>Establecimiento</h2>
    <form id="form-aceptar" method="POST" action="index.php?controller=establecimiento&amp;action=eliminar">
	    <div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
			    	Establecimiento:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $establecimiento->getId()?>  
		    	</div>
	    	</div>
	    	<div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Nombre:
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $establecimiento->getNombre()?>  
		    	</div>
	    	</div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Correo:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $establecimiento->getEmail()?>  
		    	</div>
		    </div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Localizacion:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $establecimiento->getLocalizacion()?>  
		    	</div>
		    </div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Descripción:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $establecimiento->getDescripcion()?>  
		    	</div>
		    </div>
	    </div>
	    <div class="divFormulario">
	    	<p id="bot"><a href="index.php?controller=establecimiento&amp;action=modificar">Modificar</a></p>
	    	<?php
	    		if($pincho==NULL){ ?>
	    			<p id="bot"><a href="#" onclick="if (confirm('estas seguro?')) {document.getElementById('form-aceptar').submit()}">Eliminar</a></p>
	    	<?php }
	    	?>
		</div>
    </form>
    </div>
</div>
