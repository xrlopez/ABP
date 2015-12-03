<?php 

 
 require_once(__DIR__."/core/ViewManager.php");
 require_once(__DIR__."/model/EstablecimientoMapper.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 
?>
<!--
ventana para introducir el numero de codigos a generar para un establecimiento.
-->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body class="ventana">
	No tienes un pincho registrado
    <p><input name="submit" type="submit" id="boton" value="Salir" class="boton" onclick="window.close()"/></p>
</body>
</html>