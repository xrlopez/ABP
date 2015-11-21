<?php


require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class ConcursoController extends BaseController {
  private $concursoMapper;  
  
  public function __construct() {

    parent::__construct();
    $this->concursoMapper = new ConcursoMapper();  
            
  }
  
  
  public function index() {

    $concursos = $this->concursoMapper->findConcurso();    
    $this->view->setVariable("concursos", $concursos);    
    $this->view->render("concursos", "index");

  }
  
}