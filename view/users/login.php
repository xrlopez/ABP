<?php 
 //file: view/users/login.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $view->setVariable("title", "Iniciar Sesion");
 $errors = $view->getVariable("errors");
?>


<div class="row iniciarS">
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<h2>Iniciar Sesion</h2>
		<?= isset($errors["general"])?$errors["general"]:"" ?>
		<form class="formLogin col-md-12" name="login" action="index.php?controller=users&amp;action=login" method="POST">
			<div class="divFormulario">
				<p>Usuario</p>
              	<input type="text" class="login" name="username" required>
			</div>
			<div class="divFormulario">
				<p>Contraseña</p>
				<input type="password" class="login" name="passwd" required>
			</div>
			<div class="divFormulario">
				<a href="index.php?controller=users&amp;action=register">Registrarse</a>
				<input type="submit" value="Iniciar Sesión"/>
			</div>
		</form>
	</div>
</div>