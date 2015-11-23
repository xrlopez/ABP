<?php
 require_once(__DIR__."/../../core/ViewManager.php");

  $view = ViewManager::getInstance();

?>

<div class="row iniciarS">
	<div class="divLoginRegistrar col-xs-12 col-sm-12 col-md-12">
		<h2>Gestionar Premios</h2>
			<form class="formLogin col-md-12" name="login" method="post">
				<div class="divFormulario">
					<a href="index.php?controller=pinchos&amp;action=votosJPop">Votacion Jurado Popular</a>
					<a href="index.php?controller=organizador&amp;action=votacionPro&amp;ronda=1">Votacion Jurado Profesional en Primera Ronda</a>
					<a href="index.php?controller=organizador&amp;action=votacionPro&amp;ronda=2">Votacion Jurado Profesional en Segunda Ronda</a>
				</div>
			</form>
	</div>
</div>
				