<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$jurados = $view->getVariable("juradosProfesionales");


?>

					<div class="row registrarE">
						<div class="divLogin col-xs-12 col-sm-12 col-md-12">
							<h2>Selecciona un miembro del Jurado Profesional</h2>
								<form id="asignarPincho" action="index.php?controller=organizador&amp;action=asignarJurado" method="post" >
									<?php
									foreach ($jurados as $jurado) {
									?>	
										<p><input type="radio" name="usuario" id="usuario" value="<?= $jurado->getId()?>" checked><?php echo $jurado->getNombre() ?></p>
									<?php
									}
									?>
									<p id="bot"><input name="submit" type="submit" id="boton" value="Elegir" class="boton"/></p>
				                </form>
						</div>
					</div>
				