<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
require_once(__DIR__."/../../model/Pincho.php");
 $view = ViewManager::getInstance();
 
 $concursos = $view->getVariable("concursos");
 $establecimientos = $view->getVariable("establecimientos");
 $pinchos = $view->getVariable("pinchos");
 $currentuser = $view->getVariable("currentusername");
 
 $view->setVariable("title", "Concurso");
 $flag=0;
?>

<div class="row">
	<div class="informacion col-xs-12 col-sm-12 col-md-12">
		<h2><?= $concursos->getNombre()?></h2>	
		<p><?= $concursos->getDescripcionConcurso()?></p>
		<form action="index.php?controller=concurso&amp;action=generarFolleto" name="form" method="POST">
		<input name="submit" type="submit" id="boton" value="Descargar" class="boton"/>
        </form>
		<?php if($establecimientos!=null){?>	
			<h4 class="follEsta">Establecimientos participantes</h4>
			<?php foreach ($establecimientos as $establecimiento): ?>

				<p class="nombreEsta"><?= $establecimiento->getNombre() ?></p>
				<div class="folleto">
					<p><?= $establecimiento->getDescripcion() ?></p>
					<p><?= $establecimiento->getLocalizacion() ?></p>
					<p>Pincho:</p>
					<div class="pinchoFolleto">
					<?php foreach ($pinchos as $pincho): 
						if(($pincho->getEstablecimiento())==($establecimiento->getId())){?>
						<p><?php echo $pincho->nombre ?></p>
						<p><?php echo $pincho->getDescripcion() ?></p>
						<?php if($pincho->isCeliaco()) {?><p>Apto para celiaco</p>
						<?php }else{ ?>
							<p>No apto para celiaco</p>
						<?php } }
					endforeach; ?>
					</div>
				</div>

			<?php endforeach;}
		else{ ?>
		<p>No hay establecimientos participantes</p>
		<?php } ?>
	</div>
</div>
