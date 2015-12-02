<?php 

 
 require_once(__DIR__."/core/ViewManager.php");
 require_once(__DIR__."/model/EstablecimientoMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body class="ventana">
	<form action="index.php?controller=establecimiento&amp;action=generarCodigos" name="form2" method="POST">
		Introduce el número de códigos:<br>
		<input type="number" name="numero" id="numero" min="1"/>
        <p id="bot"><input name="submit" type="submit" id="boton" value="Aceptar" class="boton" />
        <input name="submit" type="submit" id="boton" value="Salir" class="boton" onclick="window.close()"/></p>
	</form>
</body>
</html>