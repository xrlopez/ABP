<?php


require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class ConcursoController extends BaseController {
  
  /**
   * Reference to the PostMapper to interact
   * with the database
   * 
   * @var PostMapper
   */
  private $concursoMapper;  
  
  public function __construct() { 
    parent::__construct();
    
    $this->concursoMapper = new ConcursoMapper();          
  }
  
  
  public function index() {
  
    // obtain the data from the database
    $concursos = $this->concursoMapper->findConcurso();    
    
    // put the array containing Post object to the view
    $this->view->setVariable("concursos", $concursos);    
    
    // render the view (/view/posts/index.php)
    $this->view->render("concursos", "index");
  }
  
}
