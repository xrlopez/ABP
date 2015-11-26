<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");
require_once(__DIR__."/../controller/OrganizadorController.php");

require_once(__DIR__."/../model/Premio.php");
require_once(__DIR__."/../model/PremioMapper.php");

require_once(__DIR__."/../model/Pincho.php");

class PremiosController extends BaseController {
  
	private $premioMapper;


	public function __construct() { 
		parent::__construct();

		$this->premioMapper = new PremioMapper();

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

	public function asignarPremio(){
		$premios = $this->premioMapper->findAll();
		if($premios==NULL){
			$this->view->setFlash(sprintf("No hay premios asignados"));
			$this->view->render("organizador", "gestionarPremios");	
		}else{
			$this->view->setVariable("premios", $premios);  
			$this->view->render("premios", "asignar");	
		}
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