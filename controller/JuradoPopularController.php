<?php


require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");
require_once(__DIR__."/../model/JuradoPopular.php");
require_once(__DIR__."/../model/JuradoPopularMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class JuradoPopularController extends BaseController {
  
  /**
   * Reference to the PostMapper to interact
   * with the database
   * 
   * @var PostMapper
   */
  private $juradoPopularMapper;
  private $concursoMapper; 
  
  public function __construct() { 
    parent::__construct();
    
    $this->juradoPopularMapper = new JuradoPopularMapper();  
    $this->concursoMapper = new ConcursoMapper();   
  }
  
  
  public function index() {
  
    // obtain the data from the database
    $juradoPopular = $this->juradoPopularMapper->findAll(); 
    $concursos = $this->concursoMapper->findConcurso();   
    
    // put the array containing Post object to the view
    $this->view->setVariable("juradoPopular", $juradoPopular);
    $this->view->setVariable("concursos", $concursos);    
    
    $this->view->render("concursos", "index");
  }

  public function perfil(){
    $currentuser = $this->view->getVariable("currentusername");
    $juradoPopular = $this->juradoPopularMapper->findById($currentuser);
    $this->view->setVariable("juradoPop", $juradoPopular);
    $this->view->render("juradoPopular", "perfil");
  }

  public function modificar(){
    $currentuser = $this->view->getVariable("currentusername");
    $juradoPopular = $this->juradoPopularMapper->findById($currentuser);
    $this->view->setVariable("juradoPop", $juradoPopular);
    $this->view->render("juradoPopular", "modificar");
  }
  
}
