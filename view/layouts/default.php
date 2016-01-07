<?php
 //file: view/layouts/default.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 $tipoUsuario = "";
 if(isset($_SESSION["tipoUsuario"])){
	 $tipoUsuario = $_SESSION["tipoUsuario"];
 }
 
 
?><!DOCTYPE html>
<html>
  <head>
  	<script>
		function popup()
		{
			window.open("ventana.php","","width=500,height=200");
		}
	</script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <link href='https://fonts.googleapis.com/css?family=Lato:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>CPTP</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <?= $view->getFragment("css") ?>
    <?= $view->getFragment("javascript") ?>
  </head>
  <body>    
    <div id="container" class="container">
            <!-- header -->
            <div id="header" class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<ul id="menu">
						<!-- menu organizador -->
						<?php if($tipoUsuario == "organizador"){ ?>
							<li class="option"><a href="index.php?controller=organizador&amp;action=gestionJurado">Jurado profesional</a></li>
							<li class="option"><a href="index.php?controller=organizador&amp;action=validar">Validar pinchos</a></li>
							<li class="option"><a href="index.php?controller=organizador&amp;action=asignar">Asignar pinchos</a></li>
							<li class="option"><a href="index.php?controller=organizador&amp;action=finalistas">Elegir finalistas</a></li>
							<li class="option"><a href="index.php?controller=organizador&amp;action=premios">Premios</a></li>
							<li class="option"><a href="index.php?controller=pinchos&amp;action=page&amp;page=1">Pinchos</a></li>
							<li><a href="index.php?controller=users&amp;action=info"><?= sprintf("Hola %s", $currentuser) ?></a></li>
							<li><a  href="index.php?controller=users&amp;action=logout">Salir</a></li>
							
						<!-- menu jurado profesional -->
						<?php } else if($tipoUsuario == "juradoProfesional"){ ?>
							<li class="option"><a href="index.php?controller=juradoProfesional&amp;action=votar">Votar</a></li>
							<li class="option"><a href="index.php?controller=pinchos&amp;action=page&amp;page=1">Pinchos</a></li>
							<li><a href="index.php?controller=users&amp;action=info"><?= sprintf("Hola %s", $currentuser) ?></a></li>
							<li><a  href="index.php?controller=users&amp;action=logout">Salir</a></li>
							
						<!-- menu jurado popular -->
						<?php } else if($tipoUsuario == "juradoPopular"){ ?>
							<li class="option"><a href="index.php?controller=juradoPopular&amp;action=introCodigos">Votar</a></li>
							<li class="option"><a href="index.php?controller=juradoPopular&amp;action=comentar">Comentar</a></li>
							<li class="option"><a href="index.php?controller=pinchos&amp;action=page&amp;page=1">Pinchos</a></li>
							<li><a href="index.php?controller=users&amp;action=info"><?= sprintf("Hola %s", $currentuser) ?></a></li>
							<li><a  href="index.php?controller=users&amp;action=logout">Salir</a></li>
							
						<!-- menu establecimiento -->
						<?php } else if($tipoUsuario == "establecimiento"){ ?>
							<li class="option"><a href="index.php?controller=establecimiento&amp;action=registerPincho">Proponer Pincho</a></li>
							<li class="option"><a onclick="popup()">Generar códigos</a></li>
							<li class="option"><a href="index.php?controller=pinchos&amp;action=page&amp;page=1">Pinchos</a></li>
							<li><a href="index.php?controller=users&amp;action=info"><?= sprintf("Hola %s", $currentuser) ?></a></li>
							<li><a  href="index.php?controller=users&amp;action=logout">Salir</a></li>
							
						<!-- menu usuario sin sesion iniciada -->
						<?php } else{ ?>
							<li class="option"><a href="index.php?controller=pinchos&amp;action=page&amp;page=1">Pinchos</a></li>
							<li><a href="index.php?controller=users&amp;action=login">Iniciar sesión</a></li>
							
						<?php } ?>
				
					</ul> 
				</div>
              <div class="nombre col-xs-12 col-sm-12 col-md-12">
                <a href="index.php"><h1>Concurso de pinchos</h1></a>
              </div>  
            </div>
            <div class="row">
              <div id="main" class="col-xs-12 col-sm-12 col-md-8">
                  <?= $view->popFlash() ?>
			           <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>    
              </div>
              <div id="news" class="col-xs-12 col-sm-12 col-md-4">
                <ul class="menuAux">
                  <li class="intruBusca">
                  		<form id="form-aceptar" action="index.php?controller=concurso&amp;action=buscarInfo" method="post" >
	                      <input type="search" name="busqueda" id="busqueda" size="30" placeholder="buscar">
	                      <button name="submit" type="submit" id="buttonBusqueda">buscar</button>
	                    </form>
                    </li>           
                  <li class="preg"><a href="index.php?controller=establecimiento&amp;action=listar">Establecimientos</a></li>
                  <li class="preg"><a href="index.php?controller=concurso&amp;action=folleto">Folleto</a></li>
                  
                </ul>
              </div>
            </div>
    </div>
  </body>
</html>
