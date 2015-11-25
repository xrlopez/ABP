<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");


 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $premios = $view->getVariable("premios");
 
 $view->setVariable("title", "Premios");
 
?>

<div class="row registrarE">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Premios</h2>
				<?php
				foreach ($premios as $premio) {
				?>	
				<div class="row consultarInfo">
		    		<div class="col-xs-4 col-sm-4 col-md-4 info">
			    	ID Premio:  
		    		</div>
		    		<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $premio->getId()?>  
		    		</div>
		    	</div>
		    	<div class="row consultarInfo">
		    		<div class="col-xs-4 col-sm-4 col-md-4 info">
			    	Tipo:   
		    		</div>
		    		<div class="col-xs-8 col-sm-8 col-md-8">
			    	<?= $premio->getTipo()?>  
		    		</div>
	    		</div>
	    		<?php $posiciones = $premio->getPosiciones();
	    		if($posiciones!=NULL){
	    			foreach ($posiciones as $info) { ?>
	    		<div class="row consultarInfo">
		    		<div class="col-xs-4 col-sm-4 col-md-4 info">
			    	<?php 
			    		echo $info[0] . ": ";	
			    	?>   
		    		</div>
		    		<div class="col-xs-8 col-sm-8 col-md-8">
		    		<?php 
			    	 echo $info[1];
			    	 ?> 
		    		</div>
	    		</div>
	    		<?php
	    			}

	    		}else{ ?>
	    			<p>No hay ningun pincho premiado</p>
	    		<?php }
	    		?>
	    		<br>
				<?php
				}
				?>
	</div>
</div>