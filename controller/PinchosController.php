<?php
//require_once(__DIR__."/../view/pinchos/index.php");

require_once(__DIR__."/../model/Pincho.php");
require_once(__DIR__."/../model/EstablecimientoMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

	class PinchosController extends BaseController  {

		private $establecimientoMapper;

		public function __construct() {    
			parent::__construct();

			$this->establecimientoMapper = new EstablecimientoMapper();
   
		}

		/*lista todos los pinchos validados*/
		public function index(){
			$pinchos = Pincho::getPinchos();

			$numPinchos = Pincho::getNumPinchos();		
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

		/*crea las paginas del listado de pinchos*/
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

		/*devuelve los datos de un pincho indicado*/
		public function pinchoEspecifico()
		{
			$id = $_GET['id'];
			$pincho = Pincho::find($id);
			$comentarios = Pincho::getComentario($id);
			$this->view->setVariable("pincho", $pincho);
			$this->view->setVariable("comentarios", $comentarios);
			$this->view->render("pinchos", "pincho");
		}

		/*valida un pincho*/
		public function validarPincho(){
			$id = $_POST['pinchoID'];
			Pincho::validar($id);
			$this->view->redirect("organizador", "validar");
		}

		/*al invalidar un pincho lo elimina*/
		public function eliminar(){
			$id = $_POST['pinchoID'];
			Pincho::eliminar($id);
			$this->view->redirect("organizador", "validar"); 
		}

		/*lista los pinchos ordenados por votos de los jurados populares*/
		public function votosJPop(){
			$pinchos = Pincho::allOrdenados();
			$this->view->setVariable("pinchos", $pinchos);
			$this->view->render("pinchos", "votosPop");

		}

	}
?>