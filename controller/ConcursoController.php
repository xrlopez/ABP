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
  
  /*redirecciona a la página principal del sitio web*/
  public function index() {
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");    
    $this->view->setVariable("concursos", $concursos);    
    $this->view->render("concursos", "index");

  }

  /*recupera del formulario de busqueda, el valor a buscar y llama a findConcurso() de
  ConcursoMapper.php, que devuelve el resultado de la busqueda*/
  public function buscarInfo(){
    $busqueda = $_POST['busqueda'];
    $result = $this->concursoMapper->buscarInfo($busqueda);
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");    
    $this->view->setVariable("concursos", $concursos);  
    $this->view->setVariable("informacion",$result);
    $this->view->render("concursos","info");
  }
  
}
