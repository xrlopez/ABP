<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $juradoProfesionals = $view->getVariable("juradoProfesional");
 
 $view->setVariable("title", "JuradoProfesional");
 
?>

<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Miembros del Jurado Profesional</h2>
				<?php
				foreach ($juradoProfesionals as $jurado) {
				?>	
				<div class="row consultarInfo">
		    		<div class="col-xs-4 col-sm-4 col-md-4 info">
			    	Nombre:  
		    		</div>
		    		<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $jurado->getNombre()?>  
		    		</div>
		    	</div>
		    	<div class="row consultarInfo">
		    		<div class="col-xs-4 col-sm-4 col-md-4 info">
			    	Profesión:   
		    		</div>
		    		<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $jurado->getProfesion()?>  
		    		</div>
	    		</div>
	    		<br>
				<?php
				}
				?>
	</div>
</div>