<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/JuradoPopular.php");
 require_once(__DIR__."/../../model/JuradoPopularMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $juradoPopular = $view->getVariable("juradoPop");
 
 
?>

<div class="row registrarE">
<div class="divLogin col-xs-12 col-sm-12 col-md-12">
    <h2>Jurado Popular</h2>
    <form id="form-aceptar" method="POST" action="index.php?controller=juradoPopular&amp;action=eliminar">
		<div>
    	    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
			    	Usuario:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $juradoPopular->getId()?>  
		    	</div>
	    	</div>
	    	<div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Nombre:
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $juradoPopular->getNombre()?>  
		    	</div>
	    	</div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Correo:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $juradoPopular->getEmail()?>  
		    	</div>
		    </div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Residencia:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $juradoPopular->getResidencia()?>  
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
