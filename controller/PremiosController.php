<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");
require_once(__DIR__."/../controller/OrganizadorController.php");

require_once(__DIR__."/../model/Premio.php");
require_once(__DIR__."/../model/PremioMapper.php");
require_once(__DIR__."/../model/OrganizadorMapper.php");

require_once(__DIR__."/../model/Pincho.php");

class PremiosController extends BaseController {
  
	private $premioMapper;
	private $organizadorMapper;


	public function __construct() { 
		parent::__construct();

		$this->premioMapper = new PremioMapper();
		$this->organizadorMapper = new OrganizadorMapper();
	

	}

	//Redirecciona a la lista de todos los premios
	public function lista(){
		$premios = $this->premioMapper->findAll();
		$this->view->setVariable("premios", $premios);  
		$this->view->render("premios", "listar");
	}

	//Redireccionan al formulario de registro de un premio
	public function registerPremio(){
		$this->view->render("premios", "registerPremio");
	}

	/*Recupera los datos del formulario de registro de un premio, comprueba que son correctos y
	llama a save() de PremioMapper.php donde lo inserta.*/
	public function register() {
		$premio = $this->premioMapper->findById($_POST["id_premio"]);
		if($premio!=null){
		    $this->view->setFlash("Premio ".$premio->getId()." ya esta registrado.");
			$this->view->render("premios", "registerPremio");

		}else{
			if(isset($_POST["id_premio"],$_POST["tipo"]))
			{
				$prem= new Premio();
				$prem->setId($_POST["id_premio"]);
				$prem->setTipo($_POST["tipo"]);
				try{
		            $this->premioMapper->save($prem);
		            $this->view->setFlash("Premio ".$prem->getId()." registrado.");
	            }catch(ValidationException $ex) {
					$errors = $ex->getErrors();
					$this->view->setVariable("errors", $errors);
	            }
	        }
			$this->view->setVariable("premio", $prem);

			$this->view->render("organizador", "gestionarPremios");
		}
	}

	//Redirecciona a la vista para asignar los premios
	public function asignarPremio(){
		$premios = $this->premioMapper->findAll();
		if($premios==NULL){
			$this->view->setFlash(sprintf("No hay premios registrados."));
			$this->view->render("organizador", "gestionarPremios");	
		}else{
			if($this->organizadorMapper->votosNulos(2)==0 && $this->organizadorMapper->votosNulos(1)==0){ 
				$this->view->render("premios", "asig");
			}else{
			$this->view->setFlash(sprintf("Las votaciones no han terminado."));
			$this->view->render("organizador", "gestionarPremios");	
			}	
		}
	}

	
	//redirecciona a la vista para asignar los premios de los jurados populares
	public function premiosPop(){
		$premios = $this->premioMapper->findPop();
		$premios= $this->view->setVariable("premios", $premios);
		$tipo= $this->view->setVariable("tipo", "asignarPinchoPop");
		$this->view->render("premios", "asignar");
	}

	//redirecciona a la vista para asignar los premios de los jurados profesionales
	public function premiosPro(){
		$premios = $this->premioMapper->findPro();
		$premios= $this->view->setVariable("premios", $premios);
		$tipo= $this->view->setVariable("tipo", "asignarPinchoPro");
		$this->view->render("premios", "asignar");
	}
	
	//asigna un pincho a un premio de los jurados populares
	public function asignarPinchoPop(){
		$premioid = $_POST["id_premio"];
	    	$premio = $this->premioMapper->findById($premioid);
	    	$pinchos = Pincho::all();
	    	$this->view->setVariable("pinchos", $pinchos); 
	    	$this->view->setVariable("premio", $premio); 
		$this->view->render("premios", "asignarPinchosPop");
	}
	
	//asigna un pincho a un premio de los jurados profesionales
	public function asignarPinchoPro(){
		$premioid = $_POST["id_premio"];
	    	$premio = $this->premioMapper->findById($premioid);
	    	$idpinchos = $this->organizadorMapper->getPinchosPremios();
		$pinchos = array();
		foreach($idpinchos as $pincho){
			$new = Pincho::find($pincho);
			$new->setVotPro();
			array_push($pinchos,$new);
		}
	    	$this->view->setVariable("pinchos", $pinchos);
	    	$this->view->setVariable("premio", $premio); 
		$this->view->render("premios", "asignarPinchosPro");
	}

	/*
	public function asignarPinchos(){
		$premioid = $_REQUEST["id_premio"];
	    	$premio = $this->premioMapper->findById($premioid);
	    	$pinchos = Pincho::all();
	    	$this->view->setVariable("pinchos", $pinchos); 
	    	$this->view->setVariable("premio", $premio);  
		$this->view->render("premios", "asignarPinchos");
	}*/

	
	public function asignar(){
		$premioid = $_REQUEST["id_premio"];
		$pinchoid = $_REQUEST["id_pincho"];
		$posicion = $_REQUEST["posicion"];
		try{
	            $this->premioMapper->asignar($premioid, $pinchoid, $posicion);
	            $this->view->setFlash("Premio ".$premioid." asignado.");
            }catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
            }
		$this->view->render("organizador", "gestionarPremios");
	}
	

}


?>
