<?php 
require_once(__DIR__."/../../model/Pincho.php");
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$pincho = $view->getVariable("pincho");

?>
<div class="divInfo col-xs-12 col-sm-12 col-md-12">
	<div id="pincho_1" class="pinchos blurb" role="informacion">
		<!-- Tiltulo, establecimiento-->
		<div class="header module">
			<h4 class="heading">
				<h2><?php echo $pincho->nombre ?></h2>
				por
				<a class="login establecimiento" rel="establecimiento" href="establecimiento.html">Moe'Bar</a>
			</h4>
		</div>
		<!--ingredientes-->
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
			<li class="ingredientes">Sal</li>
			<li class="ingredientes">Harina</li>
			<li class="ingredientes">Agua</li>
			<li class="ingredientes">Aceite</li>
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
			<dt class"comentarios">Comentarios:</dt>
			<dd class"comentarios"><a href="/pinchos/15comentarios">14</a></dd>
		</dl>

	</div>
</div>