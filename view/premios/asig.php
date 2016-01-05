<?php 
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $user = $view->getVariable("user");
?>
<div class="row iniciarS">
	<div class="divLoginRegistrar col-xs-12 col-sm-12 col-md-12">
		<h2>Asignar premio</h2>
		<form class="formLogin col-md-12" name="login" method="post">
			<div class="divFormulario">
				<p><a href="index.php?controller=premios&amp;action=premiosPop">Asignar a jurado popular</a></p>
				<p><a href="index.php?controller=premios&amp;action=premiosPro">Asignar a jurado profesional</a></p>
			</div>
		</form>
	</div>
</div>
