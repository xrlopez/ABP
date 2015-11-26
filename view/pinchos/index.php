<?php 
require_once(__DIR__."/../../model/Pincho.php");
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$numPinchos = $view->getVariable("num_pinchos");
$numPagina = $view->getVariable("num_pagina");
$pinchos = $view->getVariable("pinchos");
$pinchoFin = $view->getVariable("fin");
$pinchoInicio = $view->getVariable("inicio");
$paginas = ceil($numPinchos['num']/5);

?>

<div class="row index">
	<div>
		<h2 class="heading"><?php echo $pinchoInicio ?> - <?php echo $pinchoFin ?> de  <?php echo $numPinchos['num'] ?> Pinchos</h2>
		<ol class="navegacion acciones" title="paginacion" role="navegacion">

			<?php if ($numPagina == 1 ) { ?>
					<li class="anterior" title="anterior"><span class="deshabilitado"><-Anterior</span></li>
			<?php }else { ?>
					<li class="anterior" title="anterior"><a href="index.php?controller=pinchos&amp;action=page&amp;page=<?= $numPagina-1 ?>"><-Anterior</a>
			<?php } ?>
			
			<?php for ($i=1; $i < $paginas+1 ; $i++) { 
					if ($i == $numPagina) { ?>
						<li><span class="current"><?php echo $i?></span></li>
					<?php }else{ ?>
						<li><a href="index.php?controller=pinchos&amp;action=page&amp;page=<?= $i ?>"><?php echo $i?></a></li>
					<?php } ?>	
			<?php } ?>
			<?php if ($numPagina == $paginas ) { ?>
					<li class="siguiente" title="siguiente"><span class="deshabilitado">Siguiente-></span></li>
			<?php }else { ?>
					<li class="siguiente" title="siguiente"><a href="index.php?controller=pinchos&amp;action=page&amp;page=<?= $numPagina+1 ?>">Siguiente-></a>
			<?php } ?>
		</ol>
	</div>
	
	<?php foreach($pinchos as $pincho): ?>
	<div class="pinchos blurb">
		<div class="header module">
			<h4 class="heading">
				<a href="index.php?controller=pinchos&amp;action=pinchoEspecifico&amp;id=<?= $pincho->id_pincho ?>"><?php echo $pincho->nombre; ?></a>
				por
				<a class="login establecimiento" rel="establecimiento" href="index.php?controller=establecimiento&amp;action=info&amp;id=<?= $pincho->getEstablecimiento() ?>"><?= $pincho->getNombreEstablecimiento() ?></a>
			</h4>
		</div>
		<div>
				<h6 class="landmark heading">Ingredientes</h6>
				<ul class="ingredientes">
					<li class="warnings">
						<?php
							if ($pincho->celiaco == 1) {
								echo "<strong>Apto para celíacos</strong>";
							}else{
								echo "<strong>No apto para celíacos</strong>";
							}
						?>	
					</li>
					<?php
					$ingredientes = $pincho->getIngredientes();
					foreach ($ingredientes as $ingrediente):
					?>
						<li class="ingrediente">
						<?= $ingrediente->getIngrediente() ?>
						</li>
					
					<?php endforeach; ?>
					
				</ul>
				<h6 class="landmark heading">Sumario</h6>
				<blockquote class="sumario pincho">
					<p>
					<?php echo $pincho->descripcion; ?>
					</p>
				</blockquote>
				<dl class="stats">
					<dt class"votos">Votos:</dt>
					<dd class"votos"><?php echo $pincho->num_votos; ?></dd>
					<dt class"comentarios">Comentarios:</dt>
					<dd class"comentarios">14</dd>
				</dl>
		</div>
		
	</div>
	<?php endforeach; ?>	
	<div>
		<ol class="navegacion acciones" title="paginacion" role="navegacion">

			<?php if ($numPagina == 1 ) { ?>
					<li class="anterior" title="anterior"><span class="deshabilitado"><-Anterior</span></li>
			<?php }else { ?>
					<li class="anterior" title="anterior"><a href="index.php?controller=pinchos&amp;action=page&amp;page=<?= $numPagina-1 ?>"><-Anterior</a>
			<?php } ?>
			
			<?php for ($i=1; $i < $paginas+1 ; $i++) { 
					if ($i == $numPagina) { ?>
						<li><span class="current"><?php echo $i?></span></li>
					<?php }else{ ?>
						<li><a href="index.php?controller=pinchos&amp;action=page&amp;page=<?= $i ?>"><?php echo $i?></a></li>
					<?php } ?>	
			<?php } ?>
			<?php if ($numPagina == $paginas ) { ?>
					<li class="siguiente" title="siguiente"><span class="deshabilitado">Siguiente-></span></li>
			<?php }else { ?>
					<li class="siguiente" title="siguiente"><a href="index.php?controller=pinchos&amp;action=page&amp;page=<?= $numPagina+1 ?>">Siguiente-></a>
			<?php } ?>
		</ol>
	</div>

</div>