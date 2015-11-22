<?php


require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/EstablecimientoMapper.php");
require_once(__DIR__."/../model/Codigo.php");
require_once(__DIR__."/../model/CodigoMapper.php");
require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");
require_once(__DIR__."/../model/Pincho.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class EstablecimientoController extends BaseController {
  
  private $juradoPopularMapper;  
  private $codigoMapper;
  private $concursoMapper;  
  private $pincho;  
  
  public function __construct() { 
    parent::__construct();
    
    $this->establecimientoMapper = new EstablecimientoMapper();      
    $this ->codigoMapper = new CodigoMapper();     
    $this ->pincho = new Pincho();   
    $this->concursoMapper = new ConcursoMapper();
  }
  
  
  public function index() {
  
    $establecimiento = $this->establecimientoMapper->findAll();  
    $concursos = $this->concursoMapper->findConcurso();   
    $this->view->setVariable("establecimiento", $establecimiento); 
    $this->view->setVariable("concursos", $concursos);    
    
    $this->view->render("concursos", "index");
    
  }

  public function perfil(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $this->view->setVariable("establecimiento", $establecimiento);
    $this->view->render("establecimiento", "perfil");
  }

  public function modificar(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $this->view->setVariable("establecimiento", $establecimiento);
    $this->view->render("establecimiento", "modificar");
  
  }
  public function update(){
    //telo que implementar
  }

  public function generarCodigos(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $cods = $this->establecimientoMapper->generarCodigos($establecimiento);
    $this->codigoMapper->generarPDF($cods,$establecimiento->getNombre());
  }

  public function listar(){
    $establecimientos = $this->establecimientoMapper->findAll();  
    $this->view->setVariable("establecimientos", $establecimientos); 
    $this->view->render("establecimiento", "listar");

  }

  public function findPincho(){
    $estab = $_GET["id"];
    $establecimiento = $this->establecimientoMapper->findById($estab);
    $pincho = $this->pincho->findByEstablecimiento($establecimiento);
    if($pincho == NULL){
      throw new Exception("No existe el pincho");
    }
    $this->view->setVariable("pincho", $pincho); 
    $this->view->render("pinchos", "pincho");
      
  }

  public function getInfo(){
    $estab = $_GET["id"];
    $establecimiento = $this->establecimientoMapper->findById($estab);
    $this->view->setVariable("esta", $establecimiento); 
    $this->view->render("establecimiento", "index");

  }
  
}
