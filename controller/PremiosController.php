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

	public function lista(){
		$premios = $this->premioMapper->findAll();
		$this->view->setVariable("premios", $premios);  
		$this->view->render("premios", "listar");
	}

	public function registerPremio(){
		$this->view->render("premios", "registerPremio");
	}

	public function register() {
		$premio = new Premio();
		if($this->premioMapper->findById($_POST["id_premio"])){
		    $this->view->setFlash("Premio ".$premio->getId()." ya esta registrado.");
			$this->view->render("premios", "registerPremio");

		}else{
			if(isset($_POST["id_premio"],$_POST["tipo"]))
			{
				$premio->setId($_POST["id_premio"]);
				$premio->setTipo($_POST["tipo"]);
				try{
		            $this->premioMapper->save($premio);
		            $this->view->setFlash("Premio ".$premio->getId()." registrado.");
	            }catch(ValidationException $ex) {
					$errors = $ex->getErrors();
					$this->view->setVariable("errors", $errors);
	            }
	        }
			$this->view->setVariable("premio", $premio);

			$this->view->render("organizador", "gestionarPremios");
		}
	}

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
	public function premiosPop(){
		$premios = $this->premioMapper->findPop();
		$premios= $this->view->setVariable("premios", $premios);
		$tipo= $this->view->setVariable("tipo", "asignarPinchoPop");
		$this->view->render("premios", "asignar");
	}

	public function premiosPro(){
		$premios = $this->premioMapper->findPro();
		$premios= $this->view->setVariable("premios", $premios);
		$tipo= $this->view->setVariable("tipo", "asignarPinchoPro");
		$this->view->render("premios", "asignar");
	}
	
	public function asignarPinchoPop(){
		$premioid = $_POST["id_premio"];
	    	$premio = $this->premioMapper->findById($premioid);
	    	$pinchos = Pincho::all();
	    	$this->view->setVariable("pinchos", $pinchos); 
	    	$this->view->setVariable("premio", $premio); 
		$this->view->render("premios", "asignarPinchosPop");
	}
	
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

	public function asignarPinchos(){
		$premioid = $_REQUEST["id_premio"];
	    	$premio = $this->premioMapper->findById($premioid);
	    	$pinchos = Pincho::all();
	    	$this->view->setVariable("pinchos", $pinchos); 
	    	$this->view->setVariable("premio", $premio);  
		$this->view->render("premios", "asignarPinchos");
	}

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
