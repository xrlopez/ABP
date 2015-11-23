<?php
//require_once(__DIR__."/../view/pinchos/index.php");

require_once(__DIR__."/../model/Pincho.php");
require_once(__DIR__."/../model/PinchoMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

	class PinchosController extends BaseController  {

		private $pinchoMapper;    

		public function __construct() {    
			parent::__construct();

			$this->pinchoMapper = new PinchoMapper();
   
		}


		public function index(){
			$pinchos = Pincho::getPinchos();

			//$this->view->setLayout("welcome");

			//calling a method to get the records with the limit set
			$numPinchos = Pincho::getNumPinchos();		
			//$this->view->setVariable("num_pinchos", $numPinchos);
			// render the view (/view/users/login.php)
			//$this->view->render("layouts", "pagination");
			$this->view->setVariable("num_pagina", 1);

			if (5 < $numPinchos ) {
				$fin = 5;
			}else{
				$fin = $numPinchos;
			}
			$this->view->setVariable("inicio", 1);
			$this->view->setVariable("fin", $fin);
			$this->view->setVariable("pinchos", $pinchos);  
			$this->view->setVariable("num_pinchos", $numPinchos);
			$this->view->render("pinchos", "index");     
		}

		public function page()
		{
			$numPage = $_GET['page'];
			$inicio = $numPage*5-4;
			$pinchos = Pincho::getPinchos($inicio-1,5);
			$numPinchos = Pincho::getNumPinchos();
			$fin = $numPage*5;
			if ($fin > $numPinchos['num'] ) {
				$fin = $numPinchos['num'];
			}
			$this->view->setVariable("inicio", $inicio);
			$this->view->setVariable("fin", $fin);
			$this->view->setVariable("num_pagina", $numPage);
			$this->view->setVariable("num_pinchos", $numPinchos);
			$this->view->setVariable("pinchos", $pinchos);
			$this->view->render("pinchos", "index"); 
		}

		public function pinchoEspecifico()
		{
			$id = $_GET['id'];
			$pincho = Pincho::find($id);
			$this->view->setVariable("pincho", $pincho);
			$this->view->render("pinchos", "pincho");
		}

		public function validarPincho(){
			$id = $_POST['pinchoID'];
			Pincho::validar($id);
			$this->view->redirect("organizador", "perfil");
		}

		public function eliminar(){
			$id = $_POST['pinchoID'];
			Pincho::eliminar($id);
			$this->view->redirect("organizador", "perfil"); 
		}

		public function votosJPop(){
			$pinchos = Pincho::allOrdenados();
			$this->view->setVariable("pinchos", $pinchos);
			$this->view->render("pinchos", "votosPop");

		}

		public function register(){
			$currentuser = $this->view->getVariable("currentusername");
			$pincho = new Pincho();
			if (isset($_POST["nombre"])){ 
				$pincho->setNombre($_POST["nombre"]);
				$pincho->setCeliaco($_POST["celiaco"]);
				$pincho->setDescripcion($_POST["descripcion"]);
				$pincho->setEstablecimiento($currentuser);    
      
				try{
					$pincho->checkIsValidForCreate(); 
   					$this->view->redirect("pinchos", "pincho");
      			}catch(ValidationException $ex) {
			      	$errors = $ex->getErrors();
			      	$this->view->setVariable("errors", $errors);
      			}
    		}
    
    // Put the User object visible to the view
    		$this->view->setVariable("pincho", $pincho);
    
    // render the view (/view/users/register.php)
    		$this->view->render("pinchos", "registerPincho");
		}

	}
?>