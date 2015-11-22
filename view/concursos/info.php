<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $concursos = $view->getVariable("concursos");
 $resultados = $view->getVariable("informacion");
 $currentuser = $view->getVariable("currentusername");
 
 $view->setVariable("title", "Concurso");
 $flag=0;
?>

<div class="row">
	<div class="informacion col-xs-12 col-sm-12 col-md-12">
		<h2>Resultados de la busqueda</h2>
		<?= isset($errors["general"])?$errors["general"]:"" ?>
		<?php if($resultados==null){?>
			<p>No se ha encontrado informacion</p>
		<?php } ?>
		<?php foreach ($resultados as $resultado): 
					if($resultado=="cambiar"){
						$flag=1;
						continue;
					}
					if($flag==0){?>
						<p>Establecimiento: <a href="index.php?controller=establecimiento&amp;action=getInfo&amp;id=<?= $resultado->getId() ?>"><?= $resultado->getNombre()?></a></p>
					<?php }
					if($flag==1){?>
						<p>Pincho: <a href="index.php?controller=pinchos&amp;action=pinchoEspecifico&amp;id=<?= $resultado->getId() ?>"><?php echo $resultado->getNombre(); ?></a></p>
					<?php } ?>
		<?php endforeach; ?>
	</div>
</div>
