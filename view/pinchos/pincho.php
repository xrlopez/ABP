<?php 
require_once(__DIR__."/../../model/Pincho.php");
require_once(__DIR__."/../../model/Comentario.php");
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$pincho = $view->getVariable("pincho");
$comentarios = $view->getVariable("comentarios");

?>
<div class="divInfo col-xs-12 col-sm-12 col-md-12">
	<div id="pincho_1" class="row pinchos blurb" role="informacion">
		<!-- Tiltulo, establecimiento-->
		<div class="header module col-xs-12 col-sm-12 col-md-12">
			<h4 class="heading">
				<h2><?php echo $pincho->nombre ?></h2>
				por
				<a class="login establecimiento" rel="establecimiento" href="index.php?controller=establecimiento&amp;action=info&amp;id=<?= $pincho->getEstablecimiento() ?>"><?= $pincho->getNombreEstablecimiento() ?></a>
			</h4>
		</div>
		<!--ingredientes-->
		<div class="header module col-xs-6 col-sm-6 col-md-6">
		<h6 class="landmark heading">Ingredientes</h6>
		<ul class="ingredientes commas">
			<li class="warnings">
			<?php
				if ($pincho->celiaco == 1) {
					echo "<strong>Apto para celíacos</strong>";
				}else{
					echo "<strong>No apto para celíacos</strong>";
				}
			?>	
			</li>
			<?php $ingredientes = $pincho->getIngredientes();
					foreach($ingredientes as $ingrediente){ ?>
				<li class="ingrediente"><?= $ingrediente->getIngrediente() ?></li>
						<?php }	?>
		</ul>
		<!--sumario-->
		<h6 class="landmark heading">Sumario</h6>
		<blockquote class="sumario pincho">
			<p><?php echo $pincho->descripcion ?></p>
		</blockquote>
		<!--stats-->
		<dl class="stats">
			<dt class"votos">Votos:</dt>
			<dd class"votos"><?php echo $pincho->num_votos; ?></dd>
		</dl>
		</div>
		<div class ="col-xs-6 col-sm-6 col-md-6">
			<img class="imagen" src="imagenes/pincho_<?= $pincho->imagen ?>" alt="imagenPincho" width="300px">
		</div>
	</div>
</div>

<?php if($comentarios!=null){ ?>
	<div>
		<h2>Comentarios</h2>
		<?php foreach ($comentarios as $comentario): ?>
				<div class="coment">
					<h2><?php echo $comentario->getJpop()?></h2>
					<span><?php echo $comentario->getComentario()?></span>
				</div>
		<?php endforeach; ?>
	</div>
<?php }?>