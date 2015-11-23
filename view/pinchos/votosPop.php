<?php 
require_once(__DIR__."/../../model/Pincho.php");
?>

<div class="row index">
<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();


$pinchos = $view->getVariable("pinchos");


?>
<h2 class="heading">Lista de Pinchos por Votación Popular</h2>
<ol class="pinchos index group">
<?php
foreach($pinchos as $pincho) {
?>
					
<li id="pincho_1" class="pinchos blurb group" role="informacion">
	<!-- Tiltulo, establecimiento-->
	<div class="header module">
		<h4 class="heading">
			<a href="index.php?controller=pinchos&amp;action=pinchoEspecifico&amp;id=<?= $pincho->id_pincho ?>"><?php echo $pincho->nombre; ?></a>
			por
			<a class="login establecimiento" rel="establecimiento" href="establecimiento.html"><?= $pincho->getNombreEstablecimiento() ?></a>
		</h4>
	</div>
	<!--ingredientes-->
	
	<!--sumario-->

	<!--stats-->
	<dl class="stats">
		<dt class"votos">Votos:</dt>
		<dd class"votos"><?php echo $pincho->num_votos; ?></dd>
		<dt class"comentarios">Comentarios:</dt>
		<dd class"comentarios"><a href="/pinchos/15comentarios">14</a></dd>
	</dl>
	
</li>
<?php
}
?>						
	