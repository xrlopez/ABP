<?php
//require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$numPinchos = $view->getVariable("num_pinchos");
$currentPage = $view->getVariable("currentPage");
$numPages = $numPinchos/5;

?>

<h2 class="heading"><?php echo $currentPage ?> - <?php echo $currentPage*5 ?> de  <?php echo $numPinchos['num'] ?> Pinchos</h2>
<ol class="navegacion acciones" title="paginacion" role="navegacion">
	<?php 
		if ($currentPage == 1 ) {
			echo "<li class="anterior" title="anterior"><span class="deshabilitado"><-Anterior</span></li><li><span class="current">1</span></li>";

		}else {
			echo "<li class="anterior" title="anterior"><a href=""><-Anterior</a></li><li><a href="">1</a></li>";
		}
	?>
	
	<li><a href="">2</a></li>
	<li><a href="">3</a></li>
	<li><span>...</span></li>
	<li><a href="">7</a></li>
	<liclass="siguiente" title="siguiente"><a href="">Siguiente-></a></li>
</ol>
<ol class="pinchos index group">