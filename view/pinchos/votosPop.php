<?php 
require_once(__DIR__."/../../model/Pincho.php");
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$pinchos = $view->getVariable("pinchos");
?>
<div class="row index">
	<h2 class="heading">Lista de Pinchos por Votación Popular</h2>

	<form action="index.php?controller=organizador&amp;action=premios" method="post" >
		<input name="submit" type="submit" id="boton" value="Atras" class="boton"/>
    </form>
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
				<span class"comentarios"><?php echo $pincho->getNumComentarios(); ?></span>
			</div>
		</div>	
<?php
}
?>
</div>				
	