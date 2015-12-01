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
		<?php 
		$tam=sizeof($resultados);
		if($tam==1){ ?>
			<p><i style="color:red;font-size:30px;">
      			No se ha encontrado informacion </i></p>
			<?php	$flag=1;
		}
		foreach ($resultados as $resultado): 
					if($resultado=="cambiar"){ ?>
						<?php	$flag=1;
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
