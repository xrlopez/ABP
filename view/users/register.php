<?php 
 //file: view/users/register.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $user = $view->getVariable("user");
 $view->setVariable("title", "Register");
?>
<div class="row iniciarS">
	<div class="divLoginRegistrar col-xs-12 col-sm-12 col-md-12">
		<h2>Registrarse</h2>
		<form class="formLogin col-md-12" name="login" method="post">
			<div class="divFormulario">
				<a href="index.php?controller=users&amp;action=registerEstablecimiento">Registrarme como establecimiento</a>
				<a href="index.php?controller=users&amp;action=registerPopular">Registrarme como jurado</a>
			</div>
		</form>
	</div>
</div>
<!--
<form action="index.php?controller=users&amp;action=register" method="POST">
      <?= i18n("Username")?>: <input type="text" name="username" 
			value="<?= $user->getUsername() ?>">
      <?= isset($errors["username"])?$errors["username"]:"" ?><br>
      
      <?= i18n("Password")?>: <input type="password" name="passwd" 
			value="">
      <?= isset($errors["passwd"])?$errors["passwd"]:"" ?><br>
      
      <input type="submit" value="<?= i18n("Register")?>">
</form>
-->