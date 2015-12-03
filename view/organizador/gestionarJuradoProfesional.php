<?php
 require_once(__DIR__."/../../core/ViewManager.php");

  $view = ViewManager::getInstance();
  $ronda = $view->getVariable("ronda");
?>

<div class="row iniciarS">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Gestionar Jurado Profesional</h2>
			<div class="divFormulario">	
				<p id="bot"><a href="index.php?controller=juradoProfesional&amp;action=listar">Listar Jurado Profesional</a></p>			
				<?php if($ronda==1){?>
				<p id="bot"><a href="index.php?controller=users&amp;action=registerProfesional">Alta Jurado</a></p>
				<p id="bot"><a href="index.php?controller=juradoProfesional&amp;action=listarEliminar">Baja Jurado</a></p>
				<?php }?>
			</div>
		</div>
</div>