<?php 
require_once(__DIR__."/../../model/Pincho.php");

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();


$pinchos = $view->getVariable("pinchos");
$ronda = $view->getVariable("ronda");

?>
<div class="row index">
	<h2 class="heading">Lista de Pinchos por Votación Profesional Ronda <?= $ronda ?></h2>
	<?php
	foreach($pinchos as $pincho) {
	?>
		<div class="pinchos">
			<!-- Tiltulo, establecimiento-->
			<div class="header module">
				<h4 class="heading">
					<a href="index.php?controller=pinchos&amp;action=pinchoEspecifico&amp;id=<?= $pincho->id_pincho ?>"><?php echo $pincho->nombre; ?></a>
					por
					<a class="login establecimiento" rel="establecimiento" href="establecimiento.html"><?= $pincho->getNombreEstablecimiento() ?></a>
				</h4>
			</div>

			<!--stats-->
			<div class="stats">
				<span class"votos">Votos:</span>
				<span class"votos"><?php echo $pincho->num_votos; ?></span>
				<span class"comentarios">Comentarios:</span>
				<span class"comentarios">14</span>
			</div>
		</div>	
<?php
}
?>
</div>