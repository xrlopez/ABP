<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $concurso = $view->getVariable("concursos");
 $currentuser = $view->getVariable("currentusername");
 
 $view->setVariable("title", "Concurso");
 
?>

<div class="row">
	<div class="informacion col-xs-12 col-sm-12 col-md-12">
		<h2>Informacion del concurso</h2>
		<?= isset($errors["general"])?$errors["general"]:"" ?>
		<?php if($concurso==NULL){?>
			<i style="color:black;font-size:30px;">
      			EN ESTE MOMENTO NO HAY CONCURSO </i>
		<?php }else{?>
		<p><?= $concurso->getDescripcionConcurso()?></p>
		<?php }?>
	</div>
</div>
