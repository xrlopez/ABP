<?php
 require_once(__DIR__."/../../core/ViewManager.php");

  $view = ViewManager::getInstance();

?>

<div class="row iniciarS">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Gestionar Premios</h2>
			<div>

				<div class="row consultarInfo">
					<h4>Estado Actual</h4>
					<div class="col-xs-4 col-sm-4 col-md-4 info">
			    	Popular: 
		    		</div>
			    	<div class="col-xs-8 col-sm-8 col-md-8">
				    	 <a href="index.php?controller=pinchos&amp;action=votosJPop">Estado actual</a>
			    	</div>
				</div>
				<div class="row consultarInfo">
					<div class="col-xs-4 col-sm-4 col-md-4 info">
			    	Profesional: 
		    		</div>
			    	<div class="col-xs-8 col-sm-8 col-md-8">
				    	 <a href="index.php?controller=organizador&amp;action=votacionPro&amp;ronda=1">Primera Ronda</a><br>
				    	 <a href="index.php?controller=organizador&amp;action=votacionPro&amp;ronda=2">Segunda Ronda</a>
			    	</div>

				</div>
			</div>
	</div>
</div>
				