<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/JuradoProfesional.php");
 require_once(__DIR__."/../../model/JuradoProfesionalMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $juradoProfesional = $view->getVariable("juradoPro");
 
 
?>

<div class="row registrarE">
<div class="divLogin col-xs-12 col-sm-12 col-md-12">
    <h2>Jurado Profesional</h2>
	    <div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
			    	Usuario:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $juradoProfesional->getId()?>  
		    	</div>
	    	</div>
	    	<div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Nombre:
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $juradoProfesional->getNombre()?>  
		    	</div>
	    	</div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Correo:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $juradoProfesional->getEmail()?>  
		    	</div>
		    </div>
		    <div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Profesion:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $juradoProfesional->getProfesion()?>  
		    	</div>
		    </div>
			<div class="row consultarInfo">
		    	<div class="col-xs-4 col-sm-4 col-md-4 info">
		    		Organizador:  
		    	</div>
		    	<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $juradoProfesional->getOrganizador()?>  
		    	</div>
		    </div>
			
	    </div>
	    <div class="divFormulario">
	    	<p id="bot"><a href="index.php?controller=juradoProfesional&amp;action=modificar">Modificar</a></p>
		</div>
    </div>
</div>