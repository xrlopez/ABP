<?php 

 
 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/JuradoProfesional.php");
 require_once(__DIR__."/../../model/JuradoProfesionalMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 $juradoProfesional = $view->getVariable("juradoPro");
 $votos = $view->getVariable("votos");
 $ronda = $view->getVariable("ronda");
 
?>

<div class="row">
	<h2>Votación de pinchos</h2>
	<?php
		if($ronda == 2){
	?>
		<h4 class="heading">Segunda ronda</h4>
	<?php } else {
	?>
		<h4 class="heading">Primera ronda</h4>
	<?php
	}
	?>
	<div class="divLogin col-xs-12 col-sm-12 col-md-12">
		<?php foreach($votos as $voto){
			$nombrePincho = $voto['nombre'];
			$votacion = $voto['votacion'];
			$idPincho = $voto['FK_pincho_vota'];
			?>
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-md-8">
					<h4 class="heading">
						<a href="index.php?controller=pinchos&amp;action=pinchoEspecifico&amp;id=<?php $idPincho ?>"><?php echo $nombrePincho ?></a> 
					</h4>
				</div>	
				<div class="col-xs-4 col-sm-4 col-md-4">
					<?php
						if($votacion == 0){ ?>
							<form class="votarPincho" action="index.php?controller=juradoProfesional&amp;action=votarPincho" method="post">

								<input type="hidden" name="currentusername" value= <?php echo "\"$currentuser\""; ?> />
								<input type="hidden" name="idPincho" value= <?php echo "\"$idPincho\""; ?> />
								<input type="submit" name="voto" value="1"/>
								<input type="submit" name="voto" value="2"/>
								<input type="submit" name="voto" value="3"/>
								<input type="submit" name="voto" value="4"/>
								<input type="submit" name="voto" value="5"/>
							</form>	
					<?php	} else{ 
						 echo '<h4>Puntuacion: '.$votacion.'</h4>';
					}
					?>
					
				</div>	
			</div>
		<?php } ?>
	</div>
</div>
